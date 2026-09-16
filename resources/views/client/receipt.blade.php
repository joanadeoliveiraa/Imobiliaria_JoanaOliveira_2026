@extends('layouts.client')
@section('title', 'Comprovativo de reserva — Olive Properties')
@section('client_content')
<div class="receipt-actions no-print"><a class="button button--outline" href="{{ route('client.reservations.show', $venda) }}">Voltar à reserva</a><button class="button button--primary" type="button" onclick="window.print()">Imprimir comprovativo</button></div>
<article class="client-receipt">
    <header><p class="eyebrow">Olive Properties</p><h1>Comprovativo de reserva</h1><p>Referência RES-{{ str_pad($venda->id, 6, '0', STR_PAD_LEFT) }} · Emitido em {{ today()->format('d/m/Y') }}</p></header>
    <section><h2>Cliente</h2><p>{{ $venda->clienteRegistado?->nome ?? $venda->cliente }}<br>{{ $venda->clienteRegistado?->email }}@if($venda->clienteRegistado?->telefone)<br>{{ $venda->clienteRegistado->telefone }}@endif</p></section>
    <section><h2>Propriedade</h2><p>{{ $venda->propriedade?->tipologia ?? $venda->apartamento }} · {{ $venda->apartamento }}<br>{{ $venda->propriedade?->morada }}</p></section>
    <section><h2>Estadia</h2><p>Check-in: {{ $venda->data_entrada->format('d/m/Y') }}<br>Check-out: {{ $venda->data_saida->format('d/m/Y') }}<br>{{ $venda->data_entrada->diffInDays($venda->data_saida) }} noites · {{ $venda->estadoNaData(today()->toDateString()) }}</p></section>
    <section><h2>Resumo</h2><p>Valor total: {{ number_format((float) $venda->valor_total, 2, ',', '.') }} €<br>Método de pagamento simulado: {{ \App\Http\Controllers\ReservaCheckoutController::METHODS[$venda->pagamentoSimulado->metodo] ?? $venda->pagamentoSimulado->metodo }}</p></section>
    <footer><p>Documento gerado pela plataforma Olive Properties.</p><p>Pagamento simulado para fins demonstrativos. Este documento não constitui fatura, recibo fiscal ou comprovativo de uma transação bancária real.</p><p>Olive Properties · Rua das Oliveiras, 25 · 8200-000 Albufeira · Portugal<br>+351 289 000 000 · info@oliveproperties.pt</p></footer>
</article>
@endsection
