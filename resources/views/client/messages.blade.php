@extends('layouts.client')
@section('title', 'Mensagens — Olive Properties')
@section('client_content')
<header class="client-heading"><p class="eyebrow">Área do cliente</p><h1>Mensagens</h1><p>Consulte os pedidos enviados com a sua conta.</p></header>
<p><a class="button button--primary" href="{{ route('contactos') }}">Criar novo pedido</a></p>
@forelse($pedidos as $pedido)<article class="client-panel"><h2>{{ $pedido->assunto }}</h2><p>{{ $pedido->created_at->format('d/m/Y H:i') }} · {{ $pedido->estado_texto }}</p><a class="button button--outline" href="{{ route('client.messages.show', $pedido) }}">Ver mensagem</a></article>
@empty<p class="client-panel">Ainda não existem pedidos de contacto associados à sua conta.</p>@endforelse
{{ $pedidos->links() }}
@endsection
