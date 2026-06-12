<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    public function index() // Mostrar a lista de apartamentos
    {
        $apartamentos = Apartamento::all(); // Buscar todos os apartamentos

        return view('apartamentos.index', compact('apartamentos')); // Abrir a página index e enviar os dados
    }


    public function create() // Mostrar o formulário de criação
    {
        return view('apartamentos.create'); // Abrir a página create
    }

    public function store(Request $request) // Gravar apartamento
    {
        // Gerar referência automática ALG001, ALG002, ...
        $ultimoApartamento = Apartamento::latest()->first();
        $numero = $ultimoApartamento ? $ultimoApartamento->id + 1 : 1;
        $referencia = 'ALG' . str_pad($numero, 3, '0', STR_PAD_LEFT);

        Apartamento::create([
            'referencia' => $referencia,
            'tipologia' => $request->tipologia,
            'morada' => $request->morada,
            'area' => $request->area,
            'preco' => $request->preco,
            'estado' => $request->estado
        ]);

        return redirect()
            ->route('apartamentos.index')
            ->with('success', 'Apartamento registado com sucesso.');
    }


    public function show(int $id) // Mostrar os detalhes do apartamento
    {
        $apartamento = Apartamento::findOrFail($id); // Procurar apartamento pelo ID

        return view('apartamentos.show', compact('apartamento')); // Abrir a página show
    }


    public function edit($id) // Mostrar formulário de edição
    {
        $apartamento = Apartamento::findOrFail($id);

        return view('apartamentos.edit', compact('apartamento'));
    }



    public function update(Request $request, $id) // Atualizar apartamento
    {
        $apartamento = Apartamento::findOrFail($id);

        $apartamento->update([
            'tipologia' => $request->tipologia,
            'morada' => $request->morada,
            'area' => $request->area,
            'preco' => $request->preco,
            'estado' => $request->estado
    ]);

    return redirect()
        ->route('apartamentos.index')
        ->with('success', 'Apartamento atualizado com sucesso.');


    }


    public function destroy($id) // Apagar apartamento
    {
        $apartamento = Apartamento::findOrFail($id);

        $apartamento->delete();

        return redirect()
            ->route('apartamentos.index');
    }
        
    }
