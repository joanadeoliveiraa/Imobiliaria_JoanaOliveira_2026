<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedidoContactoRequest;
use App\Models\PedidoContacto;
use App\Models\User;
use App\Models\Venda;
use App\Notifications\AdministrativeEvent;
use App\Support\ClientAccount;
use App\Support\ContactSubjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    public function create(Request $request)
    {
        $subject = $request->query('assunto');
        $assunto = is_string($subject) && in_array($subject, ContactSubjects::OPTIONS, true) ? $subject : '';
        $reserva = null;
        if ($request->filled('reserva')) {
            abort_unless($request->user()?->tipo === 'cliente', 403);
            $request->validate(['reserva' => ['integer']]);
            $reserva = Venda::whereHas('clienteRegistado', fn ($query) => $query->where('user_id', $request->user()->id))->findOrFail($request->input('reserva'));
        }

        return view('Contactos.contactos', compact('reserva', 'assunto'));
    }

    public function store(StorePedidoContactoRequest $request)
    {
        $pedido = DB::transaction(function () use ($request) {
            $data = $request->safe()->except(['privacidade_lida', 'outro_assunto']);
            if ($data['assunto'] === ContactSubjects::OTHER) {
                $data['assunto'] .= ': '.$request->validated('outro_assunto');
            }
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
