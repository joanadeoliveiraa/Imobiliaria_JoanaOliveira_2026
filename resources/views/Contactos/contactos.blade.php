@extends('layouts.public')
@section('title', 'Contactos — Olive Properties')
@section('content')
<section class="page-hero"><div class="site-container">
    <p class="eyebrow">Olive Properties · Algarve</p>
    <h1>Entre em contacto</h1>
    <p>Estamos disponíveis para esclarecer qualquer questão relacionada com os nossos alojamentos turísticos.</p>
</div></section>
<section class="section"><div class="site-container">
    @if(session('success'))
        <div class="alert alert--success" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())<div class="alert alert--danger" role="alert">Reveja os campos assinalados antes de enviar o pedido.</div>@endif
    <div class="contact-layout">
        <aside class="contact-details">
            <h2>Vamos conversar</h2>
            <p>Informações de contacto</p>
            <address>
                <p>Rua das Oliveiras, 25<br>8200-000 Albufeira</p>
                <p><a href="tel:+351289000000">+351 289 000 000</a></p>
                <p><a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a></p>
            </address>
        </aside>
        <div class="contact-form">
            <section class="help-card" aria-labelledby="contact-faq-title">
                <h2 id="contact-faq-title">Já consultou as nossas perguntas frequentes?</h2>
                <p>Encontre respostas rápidas às dúvidas mais comuns sobre reservas, pagamentos, check-in e estadias.</p>
                <a class="button button--outline" href="{{ route('faqs') }}">Consultar FAQs</a>
            </section>
            <h2>Envie-nos uma mensagem</h2>
            <form action="{{ route('contactos.enviar') }}" method="POST">
                @csrf
                @if($reserva)
                    <p class="field-help">Contacto sobre a reserva RES-{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}.</p>
                @endif
                <input type="hidden" name="venda_id" value="{{ old('venda_id', $reserva?->id) }}">
                @error('venda_id')<p class="field-error">{{ $message }}</p>@enderror
                <div class="form-grid">
                    <div class="field"><label for="nome">Nome *</label><input id="nome" name="nome" value="{{ old('nome', auth()->user()?->cliente?->nome ?? auth()->user()?->name) }}" autocomplete="name" @readonly(auth()->user()?->tipo === 'cliente') maxlength="120" aria-invalid="{{ $errors->has('nome') ? 'true' : 'false' }}" aria-describedby="nome-error" required><span id="nome-error" class="field-error">@error('nome'){{ $message }}@enderror</span></div>
                    <div class="field"><label for="contact-email">Email *</label><input id="contact-email" type="email" name="email" value="{{ old('email', auth()->user()?->cliente?->email ?? auth()->user()?->email) }}" autocomplete="email" @readonly(auth()->user()?->tipo === 'cliente') maxlength="255" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="email-error" required><span id="email-error" class="field-error">@error('email'){{ $message }}@enderror</span></div>
                    <div class="field"><label for="telefone">Telefone</label><input id="telefone" type="tel" name="telefone" value="{{ old('telefone') }}" autocomplete="tel" maxlength="30" aria-invalid="{{ $errors->has('telefone') ? 'true' : 'false' }}" aria-describedby="telefone-error"><span id="telefone-error" class="field-error">@error('telefone'){{ $message }}@enderror</span></div>
                    <x-contact-subject :default="$reserva ? \App\Support\ContactSubjects::RESERVATION : $assunto" />
                    <div class="field form-grid__full">
                        <label for="mensagem">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" rows="5" minlength="10" maxlength="5000" aria-invalid="{{ $errors->has('mensagem') ? 'true' : 'false' }}" aria-describedby="message-help mensagem-error" placeholder="Descreva a sua questão…" required>{{ old('mensagem') }}</textarea>
                        <small id="message-help" class="field-help">Mínimo de 10 caracteres. * Campos obrigatórios.</small><span id="mensagem-error" class="field-error">@error('mensagem'){{ $message }}@enderror</span>
                    </div>
                </div>
                <p class="field-help">Os seus dados serão usados para tratar este pedido.</p>
                <div class="field form-grid__full">
                    <div class="privacy-confirmation">
                        <input id="privacidade_lida" type="checkbox" name="privacidade_lida" value="1" required aria-invalid="{{ $errors->has('privacidade_lida') ? 'true' : 'false' }}" aria-describedby="privacidade_lida-error">
                        <label for="privacidade_lida">Li e compreendi a <a href="{{ route('legal.privacy') }}">Política de Privacidade</a>. *</label>
                    </div>
                    <span id="privacidade_lida-error" class="field-error">@error('privacidade_lida'){{ $message }}@enderror</span>
                </div>
                <div class="form-actions"><button type="submit" class="button button--primary">Enviar mensagem</button></div>
            </form>
        </div>
    </div>
</div></section>
@endsection
