<header class="public-header" x-data="{ open: false }">
        <div class="site-container public-header__inner">
            <a href="{{ route('home') }}" class="brand" aria-label="Olive Properties — início">
                <img src="{{ asset('images/logo_folhaVerde.png') }}" alt="" class="brand__mark">
                <span class="brand__wordmark">
                    <strong>Olive</strong>
                    <small>Properties</small>
                </span>
            </a>

            <div class="public-header__actions">
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
                        <a href="{{ route('client.home') }}" class="button button--small button--outline">Minha área</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="button button--small button--outline">Terminar sessão</button></form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="button button--small button--outline">Área reservada</a>
                @endauth
            </nav>
            <button type="button" class="theme-toggle" data-theme-toggle aria-label="Ativar modo escuro" aria-pressed="false">
                <svg class="theme-toggle__moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.5 13a8.5 8.5 0 0 1-9.5-9.5A8.5 8.5 0 1 0 20.5 13Z"/></svg>
                <svg class="theme-toggle__sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2M5 5l1.5 1.5m11 11L19 19M5 19l1.5-1.5m11-11L19 5"/></svg>
            </button>
            </div>
        </div>
    </header>
