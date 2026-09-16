@extends('layouts.public')
@section('content')
<div class="client-area site-container">
    <nav class="client-nav" aria-label="Área do cliente">
        <a href="{{ route('client.home') }}">Minha área</a>
        <a href="{{ route('client.reservations.index') }}">Minhas reservas</a>
        <a href="{{ route('client.reservations.create') }}">Nova reserva</a>
        <a href="{{ route('client.messages.index') }}">Mensagens</a>
        <a href="{{ route('profile.edit') }}">O meu perfil</a>
    </nav>
    @yield('client_content')
</div>
@endsection
