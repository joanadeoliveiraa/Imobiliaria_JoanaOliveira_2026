@extends('layouts.public')
@section('title', 'Área reservada — Olive Properties')
@section('content')
<section class="auth-section">
    <div class="auth-card">
        <header class="auth-card__header">
            <p class="eyebrow">Olive Properties</p>
            <h1>{{ request()->routeIs('register') ? 'Criar conta de cliente' : 'Área reservada' }}</h1>
            <p>{{ request()->routeIs('register') ? 'Guarde as suas reservas e acompanhe as suas mensagens.' : 'Aceda à sua conta com segurança.' }}</p>
        </header>
        {{ $slot }}
    </div>
</section>
@endsection
