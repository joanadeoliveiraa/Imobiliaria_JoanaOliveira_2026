<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function index() // Mostrar a lista de clientes
    {
        $clientes = Cliente::all(); // Buscar todos os clientes

        return view('clientes.index', compact('clientes')); // Abrir a página index e enviar os dados
    }


    public function create() // Mostrar o formulário de criação
    {
        return view('clientes.create'); // Abrir a página create
    }


    public function store(Request $request) // Gravar cliente
    {
        Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'morada' => $request->morada,
            'nif' => $request->nif
        ]);

        return redirect()->route('clientes.index');
    }


    public function show($id) // Mostrar os detalhes de um cliente
    {
        $cliente = Cliente::findOrFail($id); // Procurar o cliente pelo ID

        return view('clientes.show', compact('cliente')); // Abrir a página show e enviar os dados
    }


    public function edit($id) // Mostrar o formulário de edição
    {
        $cliente = Cliente::findOrFail($id); // Procurar cliente pelo ID

        return view('clientes.edit', compact('cliente')); // Abrir a página edit
    }


    public function update(Request $request, $id) // Atualizar cliente
    {
        $cliente = Cliente::findOrFail($id); // Procurar cliente

        $cliente->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'morada' => $request->morada,
            'nif' => $request->nif
        ]);

        return redirect()->route('clientes.index'); // Voltar para a listagem
    }

    public function destroy($id) // Apagar cliente
    {
        $cliente = Cliente::findOrFail($id); // Procurar cliente

        $cliente->delete(); // Apagar cliente

        return redirect()->route('clientes.index'); // Voltar à listagem
    }
}
