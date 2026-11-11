@extends('layouts.client')
@section('title', 'Pagamento — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Nova reserva · passo 3 de 4</p><h1>Pagamento</h1><p>Escolha o método de pagamento para concluir a sua reserva.</p></header>
@include('layouts.management-feedback')
<div class="client-checkout">
<section class="client-panel"><h2>Resumo da estadia</h2><p>{{ $apartamento->tipologia }} · {{ $apartamento->referencia }}</p><p>{{ \Carbon\Carbon::parse($draft['data_entrada'])->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($draft['data_saida'])->format('d/m/Y') }} · {{ $draft['quote']['noites'] }} noites</p><div class="booking-total"><span>Valor total</span><strong>{{ number_format((float) $draft['quote']['total'], 2, ',', '.') }} €</strong></div></section>
<form class="client-panel" method="POST" action="{{ route('client.reservations.pay', $token) }}" x-data="{ submitting: false }" @submit="submitting = true">
    @csrf
    <fieldset class="payment-methods" aria-describedby="payment-notice"><legend>Método de pagamento</legend>
        @foreach($methods as $value => $label)<label><input type="radio" name="metodo" value="{{ $value }}" @checked(old('metodo', 'cartao') === $value) required><span>{{ $label }}</span></label>@endforeach
    </fieldset>
    <input type="hidden" name="resultado" value="aprovado">
    <p class="field-help" id="payment-notice">Pagamento simulado — não será efetuada qualquer cobrança real.</p>
    <button class="button button--primary" type="submit" :disabled="submitting" x-text="submitting ? 'A confirmar…' : 'Confirmar pagamento'">Confirmar pagamento</button>
    <a class="button button--outline" href="{{ route('client.reservations.summary', $token) }}">Voltar</a>
</form>
</div>
@endsection
