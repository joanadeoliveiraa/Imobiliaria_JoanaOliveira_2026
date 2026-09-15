<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateVendaRequest;
use App\Models\Apartamento;
use App\Models\Atividade;
use App\Models\Cliente;
use App\Models\Venda;
use App\Support\ReservationPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::latest('data_entrada')->paginate(15);

        return view('Vendas.index', compact('vendas'));
    }

    public function create(Request $request)
    {
        $apartamentos = Apartamento::where(
            'estado',
            'Disponivel'
        )->get();

        $clientes = Cliente::all();

        $clienteSelecionado = $request->cliente;
        $draft = $request->session()->get('reservation_drafts.'.$request->query('rascunho'), []);
        if (($draft['user_id'] ?? null) !== $request->user()->id || ($draft['expires_at'] ?? 0) <= now()->timestamp) {
            $draft = [];
        }
        $apartamentoSelecionado = $request->query('apartamento');

        return view('Vendas.create',
            compact(
                'apartamentos',
                'clientes',
                'clienteSelecionado', 'apartamentoSelecionado', 'draft'));
    }

    public function show(int $id)
    {
        $venda = Venda::findOrFail($id);

        $apartamento = Apartamento::where(
            'referencia',
            $venda->apartamento
        )->first();

        return view(
            'Vendas.show',
            compact('venda', 'apartamento')
        );
    }

    public function edit(int $id)
    {
        $venda = Venda::findOrFail($id);

        return view('Vendas.edit', compact('venda'));
    }

    public function update(UpdateVendaRequest $request, int $id)
    {
        $venda = Venda::findOrFail($id);

        DB::transaction(function () use ($venda, $request): void {
            $apartamento = Apartamento::where('referencia', $venda->apartamento)
                ->lockForUpdate()
                ->firstOrFail();
            $dados = $request->validated();
            if ($apartamento->reservas()->sobrepostas($dados['data_entrada'], $dados['data_saida'])->where('id', '!=', $venda->id)->exists()) {
                throw ValidationException::withMessages(['data_entrada' => 'Já existe uma reserva para esta propriedade nas datas selecionadas.']);
            }
            $dados['apartamento'] = $venda->apartamento;
            $dados['valor_total'] = $venda->pagamentoSimulado
                ? ReservationPricing::quote($apartamento->preco, $dados['data_entrada'], $dados['data_saida'])['total']
                : $apartamento->preco;
            $venda->update($dados);

            Atividade::create(['descricao' => 'Reserva editada: '.$venda->apartamento]);
        });

        return redirect()
            ->route('vendas.index')
            ->with('success', 'Reserva atualizada com sucesso.');
    }

    public function destroy(int $id)
    {
        $venda = Venda::findOrFail($id);

        DB::transaction(function () use ($venda): void {
            Atividade::create(['descricao' => 'Reserva cancelada: '.$venda->apartamento]);
            $venda->delete();
        });

        return redirect()
            ->route('vendas.index')
            ->with('success', 'Reserva cancelada com sucesso.');
    }

    public function historicoCliente(string $cliente)
    {
        $vendas = Venda::where('cliente', $cliente)->get();
        $totalReservas = Venda::deGestao()->where('cliente', $cliente)->count();
        $totalGasto = Venda::receitaEntre('0001-01-01', now('Europe/Lisbon')->toDateString())->where('cliente', $cliente)->sum('valor_total');
        $ultimaReserva = $vendas->max('data_entrada');

        return view(
            'Vendas.historico',
            compact(
                'vendas',
                'cliente',
                'totalReservas',
                'totalGasto',
                'ultimaReserva'
            )
        );
    }
}
