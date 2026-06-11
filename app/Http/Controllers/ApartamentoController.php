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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartamento $apartamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartamento $apartamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartamento $apartamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartamento $apartamento)
    {
        //
    }
}
