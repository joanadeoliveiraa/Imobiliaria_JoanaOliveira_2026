@extends('layouts.public')

@section('title', 'Olive Properties — Imobiliária no Algarve')
@section('meta_description', 'Descubra propriedades selecionadas no Algarve com um acompanhamento próximo, transparente e personalizado.')

@section('content')
    <section class="hero" aria-labelledby="hero-title">
        <img src="{{ asset('images/Alg011.png') }}" alt="Propriedade Olive Properties no Algarve" class="hero__media">
        <div class="hero__overlay" aria-hidden="true"></div>
        <div class="site-container hero__content">
            <p class="eyebrow">Algarve · Portugal</p>
            <h1 id="hero-title" class="display-title">Um lugar distinto para viver e investir.</h1>
            <p class="hero__intro">Selecionamos propriedades com carácter e acompanhamos cada decisão com experiência, transparência e atenção pessoal.</p>
            <div class="hero__actions">
                <a href="{{ route('apartamentos.index') }}" class="button button--primary">Explorar propriedades</a>
                <a href="{{ route('contactos') }}" class="button button--outline">Falar connosco</a>
            </div>
        </div>
    </section>

    <div class="search-panel" aria-label="Pesquisa de propriedades">
        <div class="search-panel__intro">
            <span>Encontre a sua propriedade</span>
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
                <p class="lead">Uma seleção cuidada de espaços que combinam localização, conforto e qualidade de vida.</p>
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

    <section class="section section--surface" aria-labelledby="valor-title">
        <div class="site-container">
            <div class="section-heading section-heading--center">
                <p class="eyebrow">A nossa abordagem</p>
                <h2 id="valor-title" class="section-title">Imobiliário com proximidade e critério</h2>
            </div>
            <div class="value-grid">
                <article class="value-item">
                    <span class="value-item__number">01</span>
                    <h3>Seleção cuidada</h3>
                    <p>Avaliamos cada propriedade com atenção à localização, qualidade e potencial.</p>
                </article>
                <article class="value-item">
                    <span class="value-item__number">02</span>
                    <h3>Acompanhamento próximo</h3>
                    <p>Uma relação clara e pessoal, desde a primeira conversa até à decisão final.</p>
                </article>
                <article class="value-item">
                    <span class="value-item__number">03</span>
                    <h3>Conhecimento local</h3>
                    <p>Experiência no Algarve para encontrar o lugar certo para viver, investir ou descansar.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section" aria-labelledby="sobre-title">
        <div class="site-container split-feature">
            <img src="{{ asset('images/familia-oliveira.jpg') }}" alt="Família Oliveira" class="split-feature__image" loading="lazy">
            <div>
                <p class="eyebrow">Sobre a Olive Properties</p>
                <h2 id="sobre-title" class="section-title">Uma marca construída sobre confiança.</h2>
                <p class="lead">A Olive Properties nasceu de uma ligação familiar ao Algarve e de uma forma simples de entender o imobiliário: ouvir primeiro, aconselhar com honestidade e cuidar de cada detalhe.</p>
                <a href="{{ route('sobre') }}" class="button button--outline">Conhecer a nossa história</a>
            </div>
        </div>
    </section>

@endsection
