<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\PedidoContacto;
use App\Models\Venda;
use App\Support\ClientAccount;
use Illuminate\Http\Request;

class ClientAreaController extends Controller
{
    public function home(Request $request)
    {
        $cliente = ClientAccount::for($request->user());
        $reservas = $cliente->reservas()->with('propriedade')->latest('data_entrada')->get();
        $proxima = $reservas->filter(fn ($reserva) => $reserva->data_saida->toDateString() > today()->toDateString())
            ->sortBy('data_entrada')->first();
        $pedidos = PedidoContacto::where('user_id', $request->user()->id)->count();

        return view('client.home', compact('cliente', 'reservas', 'proxima', 'pedidos'));
    }

    public function reservations(Request $request)
    {
        $reservas = ClientAccount::for($request->user())->reservas()
            ->with(['propriedade', 'pagamentoSimulado'])->latest('data_entrada')->paginate(10);

        return view('client.reservations', compact('reservas'));
    }

    public function reservation(Request $request, Venda $venda)
    {
        $this->authorizeReservation($request, $venda);
        $venda->load(['propriedade', 'pagamentoSimulado']);

        return view('client.reservation', compact('venda'));
    }

    public function newReservation(Request $request)
    {
        ClientAccount::for($request->user());
        $apartamentos = Apartamento::where('estado', Apartamento::ESTADO_DISPONIVEL)->orderBy('referencia')->get();

        return view('client.new-reservation', compact('apartamentos'));
    }

    public function messages(Request $request)
    {
        ClientAccount::for($request->user());
        $pedidos = PedidoContacto::where('user_id', $request->user()->id)->latest()->paginate(10);

        return view('client.messages', compact('pedidos'));
    }

    public function message(Request $request, PedidoContacto $pedido)
    {
        abort_unless($request->user()->tipo === 'cliente' && $pedido->user_id === $request->user()->id, 403);
        $pedido->load(['respostas' => fn ($query) => $query->whereNotNull('enviado_em')->orderBy('enviado_em')]);

        return view('client.message', compact('pedido'));
    }

    public function receipt(Request $request, Venda $venda)
    {
        $this->authorizeReservation($request, $venda);
        abort_unless($venda->pagamentoSimulado, 404);
        $venda->load(['propriedade', 'pagamentoSimulado']);

        return view('client.receipt', compact('venda'));
    }

    private function authorizeReservation(Request $request, Venda $venda): void
    {
        $cliente = ClientAccount::for($request->user());
        abort_unless($venda->cliente_id === $cliente->id, 403);
    }
}
