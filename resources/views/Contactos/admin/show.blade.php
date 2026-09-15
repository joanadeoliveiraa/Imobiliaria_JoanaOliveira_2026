@extends('layouts.admin')
@section('title', 'Pedido de contacto #'.$pedido->id.' — Olive Properties')
@section('admin_content')
<div class="management-page contact-admin-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada · Pedidos de contacto</p><h1>Pedido de contacto #{{ $pedido->id }}</h1><p>Recebido em {{ $pedido->created_at->timezone('Europe/Lisbon')->format('d/m/Y H:i') }}.</p></div></header>
    @include('layouts.management-feedback')
    <div class="contact-admin-actions"><a class="button button--outline" href="{{ route('admin.contactos.index') }}">← Voltar aos pedidos</a><a class="button button--primary" href="{{ route('admin.contactos.reply', $pedido) }}">Responder</a>@if($pedido->estado !== 'archived')<form method="post" action="{{ route('admin.contactos.archive', $pedido) }}">@csrf<button class="button button--outline" type="submit">Arquivar</button></form>@endif</div>
    <div class="contact-admin-detail">
        <div>
            <section class="contact-admin-panel"><h2>Dados do pedido</h2><dl class="contact-admin-data">
                <div><dt>Nome</dt><dd>{{ $pedido->nome }}</dd></div><div><dt>Email</dt><dd><a href="mailto:{{ $pedido->email }}">{{ $pedido->email }}</a></dd></div>
                <div><dt>Telefone</dt><dd>{{ $pedido->telefone ?: 'Não indicado' }}</dd></div><div><dt>Assunto</dt><dd>{{ $pedido->assunto }}</dd></div>
                <div><dt>Estado</dt><dd><span class="contact-status contact-status--{{ $pedido->estado }}">{{ $pedido->estado_texto }}</span></dd></div><div><dt>Data e hora de envio</dt><dd>{{ $pedido->created_at->timezone('Europe/Lisbon')->format('d/m/Y H:i') }}</dd></div>
            </dl><h3>Mensagem</h3><div class="contact-message">{{ $pedido->mensagem }}</div></section>
            <section class="contact-admin-panel"><h2>Histórico</h2>
                @foreach($pedido->eventos as $evento)<div class="contact-timeline"><time datetime="{{ $evento->created_at->toIso8601String() }}">{{ $evento->created_at->timezone('Europe/Lisbon')->format('d/m/Y H:i') }}</time><span>{{ $evento->descricao }}</span></div>@endforeach
                @foreach($pedido->respostas as $resposta)<div class="contact-reply-history"><h3>Resposta enviada · {{ $resposta->enviado_em->timezone('Europe/Lisbon')->format('d/m/Y H:i') }}</h3><p><strong>Assunto:</strong> {{ $resposta->assunto }}</p><div class="contact-message">{{ $resposta->mensagem }}</div></div>@endforeach
            </section>
        </div>
        <aside class="contact-admin-panel"><h2>Tratamento do pedido</h2><form method="post" action="{{ route('admin.contactos.update', $pedido) }}">@csrf @method('PATCH')
            <div class="field"><label for="pedido-estado" class="form-label">Estado</label><select id="pedido-estado" name="estado" class="form-select" required>@foreach(\App\Models\PedidoContacto::ESTADOS as $value => $label)<option value="{{ $value }}" @selected(old('estado', $pedido->estado) === $value)>{{ $label }}</option>@endforeach</select></div>
            <div class="field"><label for="pedido-notas" class="form-label">Notas internas</label><textarea id="pedido-notas" name="notas_internas" class="form-control" rows="8" maxlength="5000">{{ old('notas_internas', $pedido->notas_internas) }}</textarea><p class="field-help">Visíveis apenas no backoffice.</p></div>
            <button class="button button--primary" type="submit">Guardar alterações</button>
        </form></aside>
    </div>
</div>
@endsection
