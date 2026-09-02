<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartamentoRequest;
use App\Http\Requests\UpdateApartamentoRequest;
use App\Models\Apartamento;
use App\Models\Atividade;
use App\Models\Cliente;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ApartamentoController extends Controller
{
    // public function index(Request $request)
    // {

    //     $pesquisa = $request->pesquisa;
    //     $ordenar = $request->ordenar;

    //     $apartamentos = Apartamento::query()

    //         ->when($pesquisa, function ($query) use ($pesquisa) {

    //             $query->where('referencia', 'like', "%{$pesquisa}%")
    //                 ->orWhere('tipologia', 'like', "%{$pesquisa}%")
    //                 ->orWhere('morada', 'like', "%{$pesquisa}%");
    //         })

    //         ->when($ordenar, function ($query) use ($ordenar) {

    //             $query->orderBy($ordenar, 'asc');
    //         })

    //         ->paginate(10);

    //     return view('apartamentos.index', compact('apartamentos'));
    // }

    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;
        $ordenar = in_array($request->ordenar, ['referencia', 'tipologia', 'morada', 'area', 'preco', 'estado'], true)
            ? $request->ordenar
            : null;
        $estado = $request->estado;

        $apartamentos = Apartamento::query()

            ->when($pesquisa, function ($query) use ($pesquisa) {

                $query->where('referencia', 'like', "%{$pesquisa}%")
                    ->orWhere('tipologia', 'like', "%{$pesquisa}%")
                    ->orWhere('morada', 'like', "%{$pesquisa}%");
            })

            ->when($estado, function ($query) use ($estado) {

                $query->where('estado', $estado);
            })

            ->when($ordenar, function ($query) use ($ordenar) {

                $query->orderBy($ordenar, 'asc');
            })

            ->paginate(10);

        return view('apartamentos.index', compact('apartamentos'));
    }

    public function create() // Mostrar o formulário de criação
    {
        return view('apartamentos.create'); // Abrir a página create
    }

    public function store(StoreApartamentoRequest $request) // Gravar apartamento
    {
        // Gerar referência automática ALG001, ALG002, ...
        DB::transaction(function () use ($request): void {
            $ultimoApartamento = Apartamento::query()->lockForUpdate()->latest('id')->first();
            $numero = $ultimoApartamento ? $ultimoApartamento->id + 1 : 1;
            $dados = $request->safe()->except('fotografia');
            $dados['referencia'] = 'ALG'.str_pad($numero, 3, '0', STR_PAD_LEFT);
            $dados['fotografia'] = $request->file('fotografia')?->store('apartamentos', 'public');

            Apartamento::create($dados);
        });

        return redirect()
            ->route('apartamentos.index')
            ->with('success', 'Apartamento registado com sucesso.');
    }

    public function show(int $id) // Mostrar os detalhes do apartamento
    {
        $apartamento = Apartamento::findOrFail($id); // Procurar apartamento pelo ID

        return view('apartamentos.show', compact('apartamento')); // Abrir a página show
    }

    public function edit(int $id) // Mostrar formulário de edição
    {
        $apartamento = Apartamento::findOrFail($id);

        return view('apartamentos.edit', compact('apartamento'));
    }

    public function update(UpdateApartamentoRequest $request, int $id) // Atualizar apartamento
    {
        $apartamento = Apartamento::findOrFail($id);

        $dados = $request->safe()->except('fotografia');

        if ($request->hasFile('fotografia')) {
            $fotografiaAnterior = $apartamento->fotografia;
            $dados['fotografia'] = $request->file('fotografia')->store('apartamentos', 'public');
            $apartamento->update($dados);

            if ($fotografiaAnterior) {
                Storage::disk('public')->delete($fotografiaAnterior);
            }
        } else {
            $apartamento->update($dados);
        }

        return redirect()
            ->route('apartamentos.index')
            ->with('success', 'Apartamento atualizado com sucesso.');
    }

    public function destroy(int $id)
    {
        $apartamento = Apartamento::findOrFail($id);

        if (Venda::where('apartamento', $apartamento->referencia)->exists()) {
            throw ValidationException::withMessages([
                'apartamento' => 'Não é possível eliminar uma propriedade com reservas associadas.',
            ]);
        }

        if ($apartamento->fotografia) {
            Storage::disk('public')->delete($apartamento->fotografia);
        }

        $apartamento->delete();

        return redirect()
            ->route('apartamentos.index')
            ->with('success', 'Apartamento eliminado com sucesso.');
    }

    // Dashboard
    public function dashboard()
    {
        $ultimoAcesso = now()->format('d/m/Y H:i');

        $disponiveis = Apartamento::where('estado', 'Disponivel')->count();

        $naoDisponiveis = Apartamento::where('estado', 'Nao Disponivel')->count();

        $clientes = Cliente::count();

        $reservas = Venda::count();

        $receitaTotal = Venda::sum('valor_total');

        $clienteTop = Venda::select('cliente')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('cliente')
            ->orderByDesc('total')
            ->first();

        $apartamentoTop = Venda::select('apartamento')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('apartamento')
            ->orderByDesc('total')
            ->first();

        $proximaReserva = Venda::orderBy('data_entrada')
            ->first();

        $atividades = Atividade::latest()
            ->take(10)
            ->get();

        $topClientes = Venda::select('cliente')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('cliente')
            ->orderByDesc('total')
            ->take(5)
            ->get();
        $labelsClientes = $topClientes->pluck('cliente');
        $dadosClientes = $topClientes->pluck('total');

        $reservasPorApartamento = Venda::select('apartamento')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('apartamento')
            ->orderByDesc('total')
            ->get();

        $labelsApartamentos = $reservasPorApartamento->pluck('apartamento');
        $dadosApartamentos = $reservasPorApartamento->pluck('total');

        $receitaMensal = Venda::selectRaw(" DATE_FORMAT(data_entrada, '%Y-%m') as mes,
        SUM(valor_total) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $labelsReceita = $receitaMensal->pluck('mes');

        $dadosReceita = $receitaMensal->pluck('total');

        $ocupacao = Apartamento::leftJoin('vendas', 'apartamentos.referencia', '=', 'vendas.apartamento')->select('apartamentos.referencia', 'apartamentos.estado', 'vendas.data_saida')
            ->orderBy('apartamentos.referencia')
            ->get();

        return view(
            'Dashboard.dashboard',
            compact(
                'disponiveis',
                'naoDisponiveis',
                'clientes',
                'reservas',
                'clienteTop',
                'apartamentoTop',
                'proximaReserva',
                'ultimoAcesso',
                'receitaTotal',
                'atividades',
                'topClientes',
                'reservasPorApartamento',
                'receitaMensal',
                'labelsReceita',
                'dadosReceita',
                'labelsClientes',
                'dadosClientes',
                'labelsApartamentos',
                'dadosApartamentos',
                'ocupacao'
            )
        );
    }
}
