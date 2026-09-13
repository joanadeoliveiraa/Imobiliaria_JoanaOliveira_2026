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

class VendaController extends Controller
{
    public function index() // Mostrar a lista de vendas
    {
        $vendas = Venda::latest('data_entrada')->paginate(15);

        return view('vendas.index', compact('vendas')); // Abrir a página index e enviar os dados
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

        return view('vendas.create',
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
            'vendas.show',
            compact('venda', 'apartamento')
        );
    }

    public function edit(int $id) // Mostrar formulário de edição
    {
        $venda = Venda::findOrFail($id);

        return view('vendas.edit', compact('venda'));
    }

    public function update(UpdateVendaRequest $request, int $id) // Atualizar venda
    {
        $venda = Venda::findOrFail($id);

        DB::transaction(function () use ($venda, $request): void {
            $apartamento = Apartamento::where('referencia', $venda->apartamento)
                ->lockForUpdate()
                ->firstOrFail();
            $dados = $request->validated();
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

    public function destroy(int $id) // Apagar venda
    {
        $venda = Venda::findOrFail($id);

        DB::transaction(function () use ($venda): void {
            Atividade::create(['descricao' => 'Reserva cancelada: '.$venda->apartamento]);
            $referencia = $venda->apartamento;
            $venda->delete();

            if (! Venda::where('apartamento', $referencia)->exists()) {
                Apartamento::where('referencia', $referencia)
                    ->update(['estado' => 'Disponivel']);
            }
        });

        return redirect()
            ->route('vendas.index')
            ->with('success', 'Reserva cancelada com sucesso.');
    }

    // Histórico Cliente
    public function historicoCliente(string $cliente)
    {
        $vendas = Venda::where('cliente', $cliente)->get();
        $totalReservas = $vendas->count();
        $totalGasto = $vendas->sum('valor_total');
        $ultimaReserva = $vendas->max('data_entrada');

        return view(
            'vendas.historico',
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
