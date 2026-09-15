@extends('layouts.admin')
@section('title', 'Responder ao pedido #'.$pedido->id.' — Olive Properties')
@section('admin_content')
<div class="management-page contact-admin-page contact-reply-page">
    <header class="admin-page-heading"><div><p class="eyebrow">Área reservada · Pedidos de contacto</p><h1>Responder ao pedido #{{ $pedido->id }}</h1><p>Escreva a resposta para {{ $pedido->nome }}.</p></div></header>
    @include('layouts.management-feedback')
    @if(! in_array(config('mail.default'), ['smtp', 'sendmail', 'mailgun', 'ses', 'postmark', 'resend'], true))<div class="alert alert--danger" role="alert">O envio real de email não está configurado. Configure MAIL_MAILER e as credenciais do serviço de email antes de responder.</div>@endif
    <form class="contact-admin-panel" method="post" action="{{ route('admin.contactos.send', $pedido) }}">@csrf
        <div class="field"><label for="reply-to" class="form-label">Para</label><input id="reply-to" class="form-control" type="email" value="{{ $pedido->email }}" readonly></div>
        <div class="field"><label for="reply-subject" class="form-label">Assunto</label><input id="reply-subject" class="form-control" name="assunto" value="{{ old('assunto', 'Re: '.$pedido->assunto) }}" maxlength="160" required></div>
        <div class="field"><label for="reply-message" class="form-label">Mensagem</label><textarea id="reply-message" class="form-control" name="mensagem" rows="10" minlength="10" maxlength="10000" required>{{ old('mensagem') }}</textarea></div>
        <div class="contact-admin-actions"><button class="button button--primary" type="submit" @disabled(! in_array(config('mail.default'), ['smtp', 'sendmail', 'mailgun', 'ses', 'postmark', 'resend'], true))>Enviar resposta</button><a class="button button--outline" href="{{ route('admin.contactos.show', $pedido) }}">Cancelar</a></div>
    </form>
</div>
@endsection
