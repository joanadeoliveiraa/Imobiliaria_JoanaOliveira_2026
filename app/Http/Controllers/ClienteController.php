<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Atividade;
use App\Models\Cliente;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;
        $ordenar = in_array($request->ordenar, ['nome', 'email', 'telefone', 'nif'], true)
            ? $request->ordenar
            : null;

        $clientes = Cliente::query()

            ->when($pesquisa, function ($query) use ($pesquisa) {
                $query->where('nome', 'like', "%{$pesquisa}%")
                    ->orWhere('email', 'like', "%{$pesquisa}%")
                    ->orWhere('telefone', 'like', "%{$pesquisa}%")
                    ->orWhere('nif', 'like', "%{$pesquisa}%");
            })

            ->when($ordenar, function ($query) use ($ordenar) {

                $query->orderBy($ordenar, 'asc');
            })

            ->paginate(10);

        return view(
            'Clientes.index',
            compact('clientes')
        );
    }

    public function create()
    {
        return view('Clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create($request->safe()->except('origem'));

        Atividade::create([
            'descricao' => 'Novo cliente criado: '.$request->nome,
        ]);

        if ($request->origem == 'reserva') {

            return redirect()
                ->route('vendas.create', [
                    'cliente' => $cliente->nome,
                ])
                ->with('success', 'Cliente criado com sucesso.');
        }

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente registado com sucesso.');
    }

    public function show(int $id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('Clientes.show', compact('cliente'));
    }

    public function edit(int $id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('Clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, int $id)
    {
        $cliente = Cliente::findOrFail($id);

        DB::transaction(function () use ($cliente, $request): void {
            $nomeAnterior = $cliente->nome;
            $cliente->update($request->validated());

            if ($nomeAnterior !== $cliente->nome) {
                Venda::where('cliente', $nomeAnterior)->update(['cliente' => $cliente->nome]);
            }
        });

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(int $id)
    {
        $cliente = Cliente::findOrFail($id);

        if (Venda::where('cliente', $cliente->nome)->exists()) {
            throw ValidationException::withMessages([
                'cliente' => 'Não é possível eliminar um cliente com reservas associadas.',
            ]);
        }

        $cliente->delete();

        return redirect()->route('clientes.index');
    }
}
