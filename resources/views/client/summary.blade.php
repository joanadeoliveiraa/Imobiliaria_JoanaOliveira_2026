@extends('layouts.client')
@section('title', 'Resumo da reserva — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Nova reserva · passo 2 de 4</p><h1>Resumo da reserva</h1></header>
<article class="client-panel">
    @if($property->fotografia)<img class="client-property-image" src="{{ asset('storage/'.$property->fotografia) }}" alt="Fotografia de {{ $property->tipologia }}">@endif
    <h2>{{ $property->tipologia }} · {{ $property->referencia }}</h2><p>{{ $property->morada }}</p>
    <dl class="booking-details"><div><dt>Check-in</dt><dd>{{ \Carbon\Carbon::parse($draft['data_entrada'])->format('d/m/Y') }}</dd></div><div><dt>Check-out</dt><dd>{{ \Carbon\Carbon::parse($draft['data_saida'])->format('d/m/Y') }}</dd></div><div><dt>Duração</dt><dd>{{ $draft['quote']['noites'] }} noites</dd></div><div><dt>Hóspede</dt><dd>{{ $cliente->nome }} · {{ $cliente->email }} @if($cliente->telefone) · {{ $cliente->telefone }} @endif</dd></div><div><dt>Preço semanal</dt><dd>{{ number_format((float) $draft['quote']['preco_semanal'], 2, ',', '.') }} €</dd></div></dl>
    <div class="booking-total"><span>Valor total</span><strong>{{ number_format((float) $draft['quote']['total'], 2, ',', '.') }} €</strong></div>
    <form method="POST" action="{{ route('client.reservations.continue', $token) }}">@csrf<button class="button button--primary" type="submit">Continuar para pagamento</button><a class="button button--outline" href="{{ route('client.reservations.create') }}">Voltar</a></form>
</article>
@endsection
