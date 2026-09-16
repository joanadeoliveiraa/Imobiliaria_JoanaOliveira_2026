@extends('layouts.client')
@section('title', 'Mensagem — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Mensagens</p><h1>{{ $pedido->assunto }}</h1><p>{{ $pedido->created_at->format('d/m/Y H:i') }} · {{ $pedido->estado_texto }}</p></header>
<article class="client-panel"><h2>A sua mensagem</h2><p class="client-message-text">{{ $pedido->mensagem }}</p></article>
@foreach($pedido->respostas as $resposta)<article class="client-panel"><h2>Resposta da Olive Properties</h2><p>{{ $resposta->enviado_em->format('d/m/Y H:i') }}</p><p class="client-message-text">{{ $resposta->mensagem }}</p></article>@endforeach
<a class="button button--outline" href="{{ route('client.messages.index') }}">Voltar às mensagens</a>
@endsection
