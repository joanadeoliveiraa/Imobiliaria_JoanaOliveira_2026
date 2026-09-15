<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendaRequest;
use App\Models\Apartamento;
use App\Models\Atividade;
use App\Models\Cliente;
use App\Models\PagamentoSimulado;
use App\Models\Venda;
use App\Support\ReservationPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReservaCheckoutController extends Controller
{
    public const METHODS = ['cartao' => 'Cartão', 'mbway' => 'MB WAY', 'transferencia' => 'Transferência'];

    public function start(StoreVendaRequest $request)
    {
        $data = $request->validated();
        $property = Apartamento::findOrFail($data['apartamento_id']);
        $this->assertAvailable($property, $data['data_entrada'], $data['data_saida']);
        $quote = ReservationPricing::quote($property->preco, $data['data_entrada'], $data['data_saida']);
        $token = (string) Str::uuid();
        $drafts = array_filter($request->session()->get('reservation_drafts', []), fn ($draft) => $draft['expires_at'] > now()->timestamp);
        $drafts[$token] = $data + ['user_id' => $request->user()->id, 'expires_at' => now()->addMinutes(30)->timestamp, 'quote' => $quote];
        $request->session()->put('reservation_drafts', $drafts);

        return redirect()->route('vendas.pagamento', $token);
    }

    public function show(Request $request, string $token)
    {
        if ($payment = $this->completed($request, $token)) {
            return redirect()->route('vendas.confirmacao', $payment->venda_id);
        }
        if (! $draft = $this->draft($request, $token)) {
            return $this->expired();
        }
        $cliente = Cliente::find($draft['cliente_id']);
        $apartamento = Apartamento::find($draft['apartamento_id']);
        if (! $cliente || ! $apartamento) {
            return redirect()->route('vendas.create')->withErrors(['reserva' => 'O cliente ou a propriedade já não estão disponíveis. Reveja a reserva.']);
        }

        return view('Vendas.pagamento', ['draft' => $draft, 'token' => $token, 'cliente' => $cliente, 'apartamento' => $apartamento, 'methods' => self::METHODS]);
    }

    public function pay(Request $request, string $token)
    {
        if ($payment = $this->completed($request, $token)) {
            return redirect()->route('vendas.confirmacao', $payment->venda_id);
        }
        if (! $draft = $this->draft($request, $token)) {
            return $this->expired();
        }
        $data = $request->validate([
            'metodo' => ['required', Rule::in(array_keys(self::METHODS))],
            'resultado' => ['required', Rule::in(['aprovado', 'recusado'])],
        ], ['metodo.required' => 'Selecione um método de demonstração.', 'resultado.required' => 'Selecione o resultado a simular.']);

        if ($data['resultado'] === 'recusado') {
            return back()->withInput()->withErrors(['pagamento' => 'Pagamento simulado recusado. Nenhuma reserva foi criada e não houve qualquer cobrança. Pode tentar novamente.']);
        }

        $payment = DB::transaction(function () use ($request, $draft, $token, $data) {
            $property = Apartamento::whereKey($draft['apartamento_id'])->lockForUpdate()->first();
            // The property lock serializes retries and competing checkouts for this property.
            if ($existing = $this->completed($request, $token)) {
                return $existing;
            }
            if (! $property) {
                throw ValidationException::withMessages(['reserva' => 'A propriedade foi removida. Volte ao primeiro passo.']);
            }
            $this->assertAvailable($property, $draft['data_entrada'], $draft['data_saida']);
            $client = Cliente::whereKey($draft['cliente_id'])->lockForUpdate()->first();
            if (! $client) {
                throw ValidationException::withMessages(['reserva' => 'O cliente foi removido. Volte ao primeiro passo.']);
            }
            if ($draft['data_entrada'] < now()->toDateString()) {
                throw ValidationException::withMessages(['reserva' => 'A data de entrada já passou. Reveja as datas.']);
            }
            $quote = ReservationPricing::quote($property->preco, $draft['data_entrada'], $draft['data_saida']);
            if ($quote !== $draft['quote']) {
                throw ValidationException::withMessages(['reserva' => 'O preço da propriedade mudou. Volte ao primeiro passo para rever o valor antes de simular o pagamento.']);
            }

            $venda = Venda::create([
                'cliente' => $client->nome, 'apartamento' => $property->referencia,
                'data_entrada' => $draft['data_entrada'], 'data_saida' => $draft['data_saida'], 'valor_total' => $quote['total'],
            ]);
            $payment = PagamentoSimulado::create([
                'venda_id' => $venda->id, 'user_id' => $request->user()->id, 'token' => $token, 'metodo' => $data['metodo'],
                'detalhes' => [
                    'criado_por' => $request->user()->name,
                    'cliente' => $client->only(['nome', 'email', 'telefone']),
                    'apartamento' => $property->only(['referencia', 'tipologia', 'morada', 'area']),
                    'data_entrada' => $draft['data_entrada'], 'data_saida' => $draft['data_saida'], 'quote' => $quote,
                ],
            ]);
            Atividade::create(['descricao' => 'Reserva criada após pagamento simulado: '.$property->referencia]);

            return $payment;
        });
        $request->session()->forget('reservation_drafts.'.$token);

        return redirect()->route('vendas.confirmacao', $payment->venda_id);
    }

    public function confirmation(Venda $venda)
    {
        $payment = $venda->pagamentoSimulado;
        if (! $payment) {
            return redirect()->route('vendas.show', $venda);
        }

        return view('Vendas.confirmacao', ['venda' => $venda, 'payment' => $payment, 'details' => $payment->detalhes]);
    }

    private function completed(Request $request, string $token): ?PagamentoSimulado
    {
        return PagamentoSimulado::where('token', $token)->where('user_id', $request->user()->id)->first();
    }

    private function draft(Request $request, string $token): ?array
    {
        $draft = $request->session()->get('reservation_drafts.'.$token);

        return $draft && $draft['user_id'] === $request->user()->id && $draft['expires_at'] > now()->timestamp ? $draft : null;
    }

    private function expired()
    {
        return redirect()->route('vendas.create')->withErrors(['reserva' => 'Esta simulação expirou ou já não está disponível. Inicie uma nova reserva.']);
    }

    private function assertAvailable(Apartamento $property, string $arrival, string $departure): void
    {
        if ($property->estado !== Apartamento::ESTADO_DISPONIVEL || $property->reservas()->sobrepostas($arrival, $departure)->exists()) {
            throw ValidationException::withMessages(['apartamento_id' => 'A propriedade selecionada já não está disponível. Volte ao primeiro passo e selecione outra.']);
        }
    }
}
