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
