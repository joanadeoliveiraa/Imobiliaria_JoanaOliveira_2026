@extends('layouts.client')
@section('title', 'Detalhes da reserva — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Minhas reservas</p><h1>Reserva #{{ $venda->id }}</h1><p>{{ $venda->estadoNaData(today()->toDateString()) }}</p></header>
<article class="client-panel"><h2>{{ $venda->propriedade?->tipologia ?? $venda->apartamento }} · {{ $venda->apartamento }}</h2><p>{{ $venda->propriedade?->morada }}</p>
<dl class="booking-details"><div><dt>Check-in</dt><dd>{{ $venda->data_entrada->format('d/m/Y') }}</dd></div><div><dt>Check-out</dt><dd>{{ $venda->data_saida->format('d/m/Y') }}</dd></div><div><dt>Noites</dt><dd>{{ $venda->data_entrada->diffInDays($venda->data_saida) }}</dd></div><div><dt>Valor</dt><dd>{{ number_format((float) $venda->valor_total, 2, ',', '.') }} €</dd></div>@if($venda->pagamentoSimulado)<div><dt>Método de pagamento</dt><dd>{{ \App\Http\Controllers\ReservaCheckoutController::METHODS[$venda->pagamentoSimulado->metodo] ?? $venda->pagamentoSimulado->metodo }}</dd></div>@endif</dl>
@if($venda->pagamentoSimulado)<a class="button button--primary" href="{{ route('client.reservations.receipt', $venda) }}">Imprimir comprovativo</a>@endif
@if(\App\Support\ReservationCalendar::isAvailable($venda))<a class="button button--outline" href="{{ \App\Support\ReservationCalendar::googleUrl($venda) }}" target="_blank" rel="noopener noreferrer">▣ Adicionar ao Google Calendar</a>@endif
<a class="button button--outline" href="{{ route('client.reservations.index') }}">Voltar às minhas reservas</a></article>
<a class="button button--outline" href="{{ route('contactos', ['reserva' => $venda->id]) }}">Contactar sobre esta reserva</a>
@endsection
