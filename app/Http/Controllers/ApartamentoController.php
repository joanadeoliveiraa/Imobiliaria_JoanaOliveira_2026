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
    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;
        $ordenar = in_array($request->ordenar, ['referencia', 'tipologia', 'morada', 'area', 'preco', 'estado'], true)
            ? $request->ordenar
            : null;
        $estado = in_array($request->estado, [Apartamento::ESTADO_DISPONIVEL, Apartamento::ESTADO_INDISPONIVEL], true)
            ? $request->estado
            : null;

        $apartamentos = Apartamento::query()

            ->when($pesquisa, function ($query) use ($pesquisa) {
                $query->where(function ($query) use ($pesquisa) {
                    $query->where('referencia', 'like', "%{$pesquisa}%")
                        ->orWhere('tipologia', 'like', "%{$pesquisa}%")
                        ->orWhere('morada', 'like', "%{$pesquisa}%");
                });
            })

            ->when($estado, function ($query) use ($estado) {

                $query->where('estado', $estado);
            })

            ->when($ordenar, function ($query) use ($ordenar) {
                $query->orderBy($ordenar, 'asc');
            })
            ->when(! $ordenar, fn ($query) => $query->latest())

            ->paginate(9)
            ->withQueryString();

        return view('Apartamentos.index', compact('apartamentos'));
    }

    public function manage(Request $request)
    {
        $pesquisa = $request->string('pesquisa')->trim()->toString();
        $estado = in_array($request->estado, [Apartamento::ESTADO_DISPONIVEL, Apartamento::ESTADO_INDISPONIVEL], true)
            ? $request->estado
            : null;

        $apartamentos = Apartamento::query()
            ->comEstadoAtual(now('Europe/Lisbon')->toDateString())
            ->when($pesquisa, function ($query) use ($pesquisa) {
                $query->where(function ($query) use ($pesquisa) {
                    $query->where('referencia', 'like', "%{$pesquisa}%")
                        ->orWhere('tipologia', 'like', "%{$pesquisa}%")
                        ->orWhere('morada', 'like', "%{$pesquisa}%");
                });
            })
            ->when($estado, fn ($query) => $query->where('estado', $estado))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('Apartamentos.manage', compact('apartamentos'));
    }

    public function create()
    {
        return view('Apartamentos.create');
    }

    public function store(StoreApartamentoRequest $request)
    {

        DB::transaction(function () use ($request): void {
            $ultimoApartamento = Apartamento::query()->lockForUpdate()->latest('id')->first();
            $numero = $ultimoApartamento ? $ultimoApartamento->id + 1 : 1;
            $dados = $request->safe()->except('fotografia');
            $dados['referencia'] = 'ALG'.str_pad($numero, 3, '0', STR_PAD_LEFT);
            $dados['fotografia'] = $request->file('fotografia')?->store('apartamentos', 'public');

            Apartamento::create($dados);
        });

        return redirect()
            ->route('admin.apartamentos.index')
            ->with('success', 'Apartamento registado com sucesso.');
    }

    public function show(int $id)
    {
        $apartamento = Apartamento::findOrFail($id);

        return view('Apartamentos.show', compact('apartamento'));
    }

    public function edit(int $id)
    {
        $apartamento = Apartamento::findOrFail($id);

        return view('Apartamentos.edit', compact('apartamento'));
    }

    public function update(UpdateApartamentoRequest $request, int $id)
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
            ->route('admin.apartamentos.index')
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
            ->route('admin.apartamentos.index')
            ->with('success', 'Apartamento eliminado com sucesso.');
    }

}
