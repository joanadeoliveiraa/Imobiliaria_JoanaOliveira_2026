@extends('layouts.client')
@section('title', 'Minhas reservas — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Área do cliente</p><h1>Minhas reservas</h1></header>
@forelse($reservas as $reserva)
<article class="client-panel client-reservation">
    @if($reserva->propriedade?->fotografia)<img src="{{ asset('storage/'.$reserva->propriedade->fotografia) }}" alt="" loading="lazy">@endif
    <div><h2>{{ $reserva->propriedade?->tipologia ?? $reserva->apartamento }} · {{ $reserva->apartamento }}</h2>
    <p>{{ $reserva->data_entrada->format('d/m/Y') }} a {{ $reserva->data_saida->format('d/m/Y') }} · {{ $reserva->data_entrada->diffInDays($reserva->data_saida) }} noites</p>
    <p>{{ $reserva->estadoNaData(today()->toDateString()) }} · {{ number_format((float) $reserva->valor_total, 2, ',', '.') }} €</p>
    <a class="button button--outline" href="{{ route('client.reservations.show', $reserva) }}">Ver detalhes</a></div>
</article>
@empty
<p class="client-panel">Ainda não existem reservas associadas à sua conta.</p>
@endforelse
{{ $reservas->links() }}
@endsection
