<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Backoffice') — Olive Properties</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_folhaVerde.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-site">
    <div class="admin-shell" x-data="{ navigationOpen: false }">
        <aside class="admin-sidebar" :class="{ 'is-open': navigationOpen }">
            <a href="{{ route('dashboard') }}" class="admin-brand">
                <img src="{{ asset('images/logo_folhaVerde.png') }}" alt="">
                <span><strong>Olive</strong><small>Properties</small></span>
            </a>
            <nav id="admin-navigation" class="admin-nav" aria-label="Navegação do backoffice">
                <a href="{{ route('dashboard') }}" @class(['is-active' => request()->routeIs('dashboard')])>Dashboard</a>
                <a href="{{ route('admin.apartamentos.index') }}" @class(['is-active' => request()->routeIs('admin.apartamentos.*', 'apartamentos.create', 'apartamentos.edit')])>Propriedades</a>
                <a href="{{ route('clientes.index') }}" @class(['is-active' => request()->routeIs('clientes.*')])>Clientes</a>
                <a href="{{ route('vendas.index') }}" @class(['is-active' => request()->routeIs('vendas.*')])>Vendas e reservas</a>
            </nav>
            <a href="{{ route('home') }}" class="admin-sidebar__website">Ver website público</a>
        </aside>
        <div class="admin-content">
            <header class="admin-topbar">
                <button type="button" class="admin-menu-toggle" @click="navigationOpen = ! navigationOpen" :aria-expanded="navigationOpen.toString()" aria-controls="admin-navigation">Menu</button>
                <div>
                    <span>{{ auth()->user()->name }}</span>
                    <a href="{{ route('profile.edit') }}">Perfil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Terminar sessão</button>
                    </form>
                </div>
            </header>
            <main class="admin-main">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
