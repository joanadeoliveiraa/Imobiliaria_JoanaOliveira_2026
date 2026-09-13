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
    <div class="contact-layout">
        <aside class="contact-details">
            <h2>Vamos conversar</h2>
            <p>Informações de contacto</p>
            <address>
                <p>Rua das Oliveiras, 25<br>8200-000 Albufeira</p>
                <p><a href="tel:+351289000000">+351 289 000 000</a></p>
                <p><a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a></p>
            </address>
            <p>Olive Properties - Algarve<br>Luxury Holiday Apartments • Algarve • Portugal</p>
        </aside>
        <div class="contact-form">
            <h2>Envie-nos uma mensagem</h2>
            <p>O envio pelo formulário ainda não está disponível. Para contactar a equipa, utilize o email ou telefone indicados.</p>
            <form action="{{ route('contactos.enviar') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="field"><label for="nome">Nome *</label><input id="nome" name="nome" value="{{ old('nome') }}" autocomplete="name" required></div>
                    <div class="field"><label for="contact-email">Email *</label><input id="contact-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required></div>
                    <div class="field"><label for="telefone">Telefone</label><input id="telefone" type="tel" name="telefone" value="{{ old('telefone') }}" autocomplete="tel"></div>
                    <div class="field"><label for="assunto">Assunto *</label><input id="assunto" name="assunto" value="{{ old('assunto') }}" required></div>
                    <div class="field form-grid__full">
                        <label for="mensagem">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" rows="5" minlength="100" aria-describedby="message-help" placeholder="Descreva a sua questão…" required>{{ old('mensagem') }}</textarea>
                        <small id="message-help" class="field-help">Mínimo de 100 caracteres. * Campos obrigatórios.</small>
                    </div>
                </div>
                <div class="form-actions"><button type="submit" class="button button--primary">Enviar mensagem</button></div>
            </form>
        </div>
    </div>
</div></section>
@endsection
