@extends('layouts.public')
@section('title', 'Área reservada — Olive Properties')
@section('content')
<section class="auth-section">
    <div class="auth-card">
        <header class="auth-card__header">
            <p class="eyebrow">Olive Properties</p>
            <h1>Área reservada</h1>
            <p>Aceda à sua conta com segurança.</p>
        </header>
        {{ $slot }}
    </div>
</section>
@endsection
