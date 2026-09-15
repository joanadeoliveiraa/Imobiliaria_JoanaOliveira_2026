<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedidoContactoRequest;
use App\Models\PedidoContacto;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    public function store(StorePedidoContactoRequest $request)
    {
        DB::transaction(function () use ($request) {
            $pedido = PedidoContacto::create($request->validated());
            $pedido->eventos()->create(['tipo' => 'received', 'descricao' => 'Pedido recebido']);
        });

        return redirect()->route('contactos')->with('success', 'Pedido enviado com sucesso. A nossa equipa entrará em contacto consigo brevemente.');
    }
}
