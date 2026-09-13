@extends('layouts.public')

@section('title', 'Olive Properties — Casas de férias de luxo no Algarve')
@section('meta_description', 'Gestão e aluguer de casas de férias de luxo no Algarve. Descubra a sua próxima estadia com a Olive Properties.')

@section('content')
    <section class="hero" aria-labelledby="hero-title">
        <img src="{{ asset('images/Alg011.png') }}" alt="Propriedade Olive Properties no Algarve" class="hero__media">
        <div class="hero__overlay" aria-hidden="true"></div>
        <div class="site-container hero__content">
            <p class="eyebrow">Algarve · Portugal</p>
            <h1 id="hero-title" class="display-title">O seu lugar para abrandar no Algarve.</h1>
            <p class="hero__intro">Casas de férias de luxo, lugares com carácter e tempo para desfrutar. Descubra a sua próxima estadia com a Olive Properties.</p>
            <div class="hero__actions">
                <a href="{{ route('apartamentos.index') }}" class="button button--primary">Explorar propriedades</a>
                <a href="{{ route('contactos') }}" class="button button--outline">Falar connosco</a>
            </div>
        </div>
    </section>

    <div class="search-panel" aria-label="Pesquisa de propriedades">
        <div class="search-panel__intro">
            <span>Encontre a sua casa de férias</span>
            <p>Pesquise a nossa seleção no Algarve</p>
        </div>
        <form action="{{ route('apartamentos.index') }}" method="GET" class="search-form">
            <div>
                <label for="pesquisa-home" class="sr-only">Referência, tipologia ou localização</label>
                <input id="pesquisa-home" type="search" name="pesquisa" placeholder="Ex.: Vilamoura, T2 ou ALG011" autocomplete="off">
            </div>
            <button type="submit" class="button button--primary">Pesquisar</button>
        </form>
    </div>

    <section class="section" aria-labelledby="destaques-title">
        <div class="site-container">
            <div class="section-heading">
                <p class="eyebrow">Seleção Olive</p>
                <h2 id="destaques-title" class="section-title">Propriedades em destaque</h2>
                <p class="lead">Casas escolhidas para dias de descanso, com conforto, privacidade e o Algarve à sua porta.</p>
            </div>

            @if($propriedadesDestaque->isNotEmpty())
                <div class="property-grid">
                    @foreach($propriedadesDestaque as $propriedade)
                        <x-property-card :property="$propriedade" />
                    @endforeach
                </div>
                <div class="property-grid__footer">
                    <a href="{{ route('apartamentos.index') }}" class="button button--outline">Ver todas as propriedades</a>
                </div>
            @else
                <div class="empty-state">
                    <h3>Estamos a preparar uma nova seleção</h3>
                    <p>Contacte-nos para conhecer oportunidades ainda não publicadas.</p>
                    <a href="{{ route('contactos') }}" class="button button--primary">Contactar a equipa</a>
                </div>
            @endif
        </div>
    </section>

    <x-holiday-steps />

    <section class="section" aria-labelledby="sobre-title">
        <div class="site-container split-feature">
            <img src="{{ asset('images/familia-oliveira.jpg') }}" alt="Família Oliveira" class="split-feature__image" loading="lazy">
            <div>
                <p class="eyebrow">Sobre a Olive Properties</p>
                <h2 id="sobre-title" class="section-title">Uma marca construída sobre confiança.</h2>
                <p class="lead">A Olive Properties nasceu de uma ligação familiar ao Algarve e da atenção dedicada à gestão e ao aluguer de casas de férias: ouvir primeiro, acompanhar cada estadia e cuidar de cada detalhe.</p>
                <a href="{{ route('sobre') }}" class="button button--outline">Conhecer a nossa história</a>
            </div>
        </div>
    </section>

@endsection
