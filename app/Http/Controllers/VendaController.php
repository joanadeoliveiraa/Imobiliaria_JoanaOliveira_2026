<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use App\Models\Apartamento;
use App\Models\Cliente;

class VendaController extends Controller
{
    public function index() // Mostrar a lista de vendas
    {
        $vendas = Venda::all(); // Buscar todas as vendas

        return view('vendas.index', compact('vendas')); // Abrir a página index e enviar os dados
    }

    // public function create(Request $request) // Mostrar o formulário de criação
    // {
    //     $apartamento = Apartamento::find($request->apartamento);

    //     return view('vendas.create', compact('apartamento'));
    // }


    // public function create()
    // {

    //     // Cria vrdas/reservas apenas para imóveis disponiveis
    //     $apartamentos = Apartamento::where('estado', 'Disponivel')->get();

    //     return view(
    //         'vendas.create',
    //         compact('apartamentos')
    //     );
    // }

    public function create()
    {
        $apartamentos = Apartamento::where('estado', 'Disponivel')->get();

        $clientes = Cliente::all();

        return view(
            'vendas.create',
            compact('apartamentos', 'clientes')
        );
    }

    // public function store(Request $request) // Gravar venda
    // {
    //     Venda::create([
    //         'cliente' => $request->cliente,
    //         'apartamento' => $request->apartamento,
    //         'data_entrada' => $request->data_entrada,
    //         'data_saida' => $request->data_saida,
    //         'valor_total' => $request->valor_total
    //     ]);

    //     $apartamento = Apartamento::where(
    //         'referencia',
    //         $request->apartamento
    //     )->first();


    //     if ($apartamento) {
    //         $apartamento->estado = 'Nao Disponivel';
    //         $apartamento->save();
    //     }
    //     return redirect()
    //         ->route('vendas.index')
    //         ->with('success', 'Reserva registada com sucesso.');
    // }


    public function store(Request $request) // Gravar reserva
    {
        $venda = Venda::create([
            'cliente' => $request->cliente,
            'apartamento' => $request->apartamento,
            'data_entrada' => $request->data_entrada,
            'data_saida' => $request->data_saida,
            'valor_total' => $request->valor_total
        ]);

        $apartamento = Apartamento::where('referencia', $request->apartamento)->first();

        if ($apartamento) {
            $apartamento->estado = 'Nao Disponivel';
            $apartamento->save();
        }

        return view('vendas.resumo', compact('venda', 'apartamento'));
    }


    // public function show(int $id) // Mostrar os detalhes da venda
    // {
    //     $venda = Venda::findOrFail($id);

    //     return view('vendas.show', compact('venda'));
    // }

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


    public function update(Request $request, int $id) // Atualizar venda
    {
        $venda = Venda::findOrFail($id);

        $venda->update([
            'cliente' => $request->cliente,
            'apartamento' => $request->apartamento,
            'data_entrada' => $request->data_entrada,
            'data_saida' => $request->data_saida,
            'valor_total' => $request->valor_total
        ]);

        return redirect()
            ->route('vendas.index')
            ->with('success', 'Venda atualizada com sucesso.');
    }


    public function destroy(int $id) // Apagar venda
    {
        $venda = Venda::findOrFail($id);

        $venda->delete();

        return redirect()
            ->route('vendas.index')
            ->with('success', 'Venda apagada com sucesso.');
    }


    // Histórico Cliente
    public function historicoCliente(string $cliente)
    {
        $vendas = Venda::where('cliente', $cliente)->get();
        $totalReservas = $vendas->count();
        $totalGasto = $vendas->sum('valor_total');
        $ultimaReserva = $vendas->max('data_entrada');

        return view(
            'vendas.historico', compact(
                'vendas',
                'cliente',
                'totalReservas',
                'totalGasto',
                'ultimaReserva'
            )
        );
    }
}
