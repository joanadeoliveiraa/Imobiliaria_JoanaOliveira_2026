@extends('layouts.client')
@section('title', 'Reserva confirmada — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Nova reserva · passo 4 de 4</p><h1>✓ Reserva confirmada</h1><p>A sua reserva foi registada com sucesso.</p></header>
<article class="client-panel"><h2>Reserva #{{ $venda->id }}</h2><p>{{ $venda->propriedade?->tipologia ?? $venda->apartamento }} · {{ $venda->apartamento }}</p><p>{{ $venda->data_entrada->format('d/m/Y') }} a {{ $venda->data_saida->format('d/m/Y') }} · {{ $venda->data_entrada->diffInDays($venda->data_saida) }} noites</p><p>{{ number_format((float) $venda->valor_total, 2, ',', '.') }} € · pagamento simulado</p>
@if($payment->email_estado === 'sent')<p>A confirmação foi enviada para {{ $venda->clienteRegistado?->email }}.</p>@else<p>A reserva está disponível nesta área. A confirmação por email não foi enviada; pode consultar e imprimir o comprovativo aqui.</p>@endif
<p class="simulation-notice">Não foi efetuada qualquer cobrança bancária real.</p>
<div class="form-actions"><a class="button button--primary" href="{{ route('client.reservations.show', $venda) }}">Ver a minha reserva</a><a class="button button--outline" href="{{ route('client.reservations.receipt', $venda) }}">Imprimir comprovativo</a><a class="button button--ghost" href="{{ route('client.home') }}">Voltar à minha área</a></div></article>
@endsection
