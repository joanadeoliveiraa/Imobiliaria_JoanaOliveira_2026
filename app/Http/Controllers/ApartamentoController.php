<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    public function index(Request $request)
    {

        $pesquisa = $request->pesquisa;
        $ordenar = $request->ordenar;

        $apartamentos = Apartamento::query()

            ->when($pesquisa, function ($query) use ($pesquisa) {

                $query->where('referencia', 'like', "%{$pesquisa}%")
                    ->orWhere('tipologia', 'like', "%{$pesquisa}%")
                    ->orWhere('morada', 'like', "%{$pesquisa}%");
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

    public function store(Request $request) // Gravar apartamento
    {
        // Gerar referência automática ALG001, ALG002, ...
        $ultimoApartamento = Apartamento::latest()->first();
        $numero = $ultimoApartamento ? $ultimoApartamento->id + 1 : 1;
        $referencia = 'ALG' . str_pad($numero, 3, '0', STR_PAD_LEFT);

        $foto = null;

        if ($request->hasFile('fotografia')) {
            $foto = $request->file('fotografia')
                ->store('apartamentos', 'public');
        }

        Apartamento::create([
            'referencia' => $referencia,
            'tipologia' => $request->tipologia,
            'morada' => $request->morada,
            'area' => $request->area,
            'preco' => $request->preco,
            'fotografia' => $foto,
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

        if ($request->hasFile('fotografia')) {

            $foto = $request->file('fotografia')
                ->store('apartamentos', 'public');

            $apartamento->fotografia = $foto;
        }

        $apartamento->tipologia = $request->tipologia;
        $apartamento->morada = $request->morada;
        $apartamento->area = $request->area;
        $apartamento->preco = $request->preco;
        $apartamento->estado = $request->estado;

        $apartamento->save();

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
