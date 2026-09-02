<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Olive Properties — propriedades selecionadas no Algarve.')">
    <title>@yield('title', 'Olive Properties')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_folhaVerde.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-site">
    <a href="#conteudo" class="skip-link">Saltar para o conteúdo</a>

    <header class="public-header" x-data="{ open: false }">
        <div class="site-container public-header__inner">
            <a href="{{ route('home') }}" class="brand" aria-label="Olive Properties — início">
                <img src="{{ asset('images/logo_folhaVerde.png') }}" alt="" class="brand__mark">
                <span class="brand__wordmark">
                    <strong>Olive</strong>
                    <small>Properties</small>
                </span>
            </a>

            <button type="button" class="menu-toggle" @click="open = ! open" :aria-expanded="open.toString()" aria-controls="public-navigation">
                <span class="sr-only">Abrir menu de navegação</span>
                <span></span><span></span><span></span>
            </button>

            <nav id="public-navigation" class="public-nav" :class="{ 'is-open': open }" aria-label="Navegação principal">
                <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>Início</a>
                <a href="{{ route('apartamentos.index') }}" @class(['is-active' => request()->routeIs('apartamentos.*')])>Propriedades</a>
                <a href="{{ route('sobre') }}" @class(['is-active' => request()->routeIs('sobre')])>Sobre</a>
                <a href="{{ route('contactos') }}" @class(['is-active' => request()->routeIs('contactos*')])>Contactos</a>
                @auth
                    @if(auth()->user()->tipo === 'administrador')
                        <a href="{{ route('dashboard') }}" class="button button--small button--outline">Backoffice</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="button button--small button--outline">Perfil</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="button button--small button--outline">Área reservada</a>
                @endauth
            </nav>
        </div>
    </header>

    <main id="conteudo">
        @yield('content')
    </main>

    <footer class="public-footer">
        <div class="site-container public-footer__main">
            <a href="{{ route('home') }}" class="footer-wordmark" aria-label="Olive Properties — início">
                <strong>Olive</strong><span>Properties</span>
            </a>
            <nav class="public-footer__nav" aria-label="Navegação do rodapé">
                <a href="{{ route('apartamentos.index') }}">Propriedades</a>
                <a href="{{ route('sobre') }}">Sobre nós</a>
                <a href="{{ route('contactos') }}">Contactos</a>
            </nav>
            <address class="public-footer__contact">
                <a href="tel:+351289000000">+351 289 000 000</a>
                <a href="mailto:info@oliveproperties.pt">info@oliveproperties.pt</a>
            </address>
        </div>
        <div class="site-container public-footer__bottom">
            <p>&copy; {{ now()->year }} Olive Properties. Projeto desenvolvido em homenagem às raízes da família Oliveira.</p>
        </div>
    </footer>
</body>
</html>
