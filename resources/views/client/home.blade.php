@extends('layouts.client')
@section('title', 'Minha área — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Área do cliente</p><h1>Olá, {{ auth()->user()->name }}</h1><p>Acompanhe as suas estadias e comunicações.</p></header>
<div class="client-cards">
    <a class="client-card" href="{{ route('client.reservations.index') }}"><span>Reservas</span><strong>{{ $reservas->count() }}</strong><small>Ver as minhas reservas</small></a>
    <a class="client-card" href="{{ route('client.messages.index') }}"><span>Pedidos e mensagens</span><strong>{{ $pedidos }}</strong><small>Ver comunicações</small></a>
</div>
@if($proxima)
<section class="client-panel"><h2>Próxima estadia</h2><p>{{ $proxima->propriedade?->tipologia ?? $proxima->apartamento }} · {{ $proxima->apartamento }}</p><p>{{ $proxima->data_entrada->format('d/m/Y') }} a {{ $proxima->data_saida->format('d/m/Y') }} · {{ $proxima->estadoNaData(today()->toDateString()) }}</p><p>{{ number_format((float) $proxima->valor_total, 2, ',', '.') }} €</p><a class="button button--outline" href="{{ route('client.reservations.show', $proxima) }}">Ver reserva</a></section>
@else
<section class="client-panel"><h2>A sua próxima estadia</h2><p>Ainda não existem reservas futuras associadas à sua conta.</p></section>
@endif
<div class="form-actions"><a class="button button--primary" href="{{ route('client.reservations.create') }}">Fazer uma reserva</a><a class="button button--outline" href="{{ route('contactos') }}">Contactar a Olive Properties</a></div>
@endsection
