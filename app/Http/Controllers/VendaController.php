<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendaRequest;
use App\Http\Requests\UpdateVendaRequest;
use App\Models\Apartamento;
use App\Models\Atividade;
use App\Models\Cliente;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VendaController extends Controller
{
    public function index() // Mostrar a lista de vendas
    {
        $vendas = Venda::latest('data_entrada')->paginate(15);

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

    public function create(Request $request)
    {
        $apartamentos = Apartamento::where(
            'estado',
            'Disponivel'
        )->get();

        $clientes = Cliente::all();

        $clienteSelecionado = $request->cliente;

        return view('vendas.create',
            compact(
                'apartamentos',
                'clientes',
                'clienteSelecionado'));
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

    public function store(StoreVendaRequest $request) // Gravar reserva
    {
        [$venda, $apartamento] = DB::transaction(function () use ($request): array {
            $apartamento = Apartamento::where('referencia', $request->apartamento)
                ->lockForUpdate()
                ->firstOrFail();

            if ($apartamento->estado !== 'Disponivel') {
                throw ValidationException::withMessages([
                    'apartamento' => 'A propriedade selecionada já não está disponível.',
                ]);
            }

            $dados = $request->validated();
            $dados['valor_total'] = $apartamento->preco;
            $venda = Venda::create($dados);

            Atividade::create(['descricao' => 'Reserva criada: '.$apartamento->referencia]);
            $apartamento->update(['estado' => 'Nao Disponivel']);

            return [$venda, $apartamento];
        });

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

    public function update(UpdateVendaRequest $request, int $id) // Atualizar venda
    {
        $venda = Venda::findOrFail($id);

        DB::transaction(function () use ($venda, $request): void {
            $apartamento = Apartamento::where('referencia', $venda->apartamento)
                ->lockForUpdate()
                ->firstOrFail();
            $dados = $request->validated();
            $dados['apartamento'] = $venda->apartamento;
            $dados['valor_total'] = $apartamento->preco;
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
