<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedidoContactoRequest;
use App\Models\PedidoContacto;
use App\Models\User;
use App\Notifications\AdministrativeEvent;
use App\Support\ClientAccount;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    public function store(StorePedidoContactoRequest $request)
    {
        $pedido = DB::transaction(function () use ($request) {
            $data = $request->safe()->except('privacidade_lida');
            if ($request->user()?->tipo === 'cliente') {
                $cliente = ClientAccount::for($request->user());
                $data['user_id'] = $request->user()->id;
                $data['nome'] = $cliente->nome;
                $data['email'] = $cliente->email;
            }
            $pedido = PedidoContacto::create($data);
            $pedido->eventos()->create(['tipo' => 'received', 'descricao' => 'Pedido recebido']);
            return $pedido;
        });
        $notification = new AdministrativeEvent('contact', 'Novo pedido de contacto',
            $pedido->nome.' — '.$pedido->assunto, route('admin.contactos.show', $pedido));
        User::where('tipo', 'administrador')->get()->each(fn ($admin) => $admin->notify($notification));

        return redirect()->route('contactos')->with('success', 'Pedido enviado com sucesso. A nossa equipa entrará em contacto consigo brevemente.');
    }
}
