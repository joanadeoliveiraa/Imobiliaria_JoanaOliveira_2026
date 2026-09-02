@extends('layouts.public')

@section('title', 'Propriedades no Algarve — Olive Properties')
@section('meta_description', 'Explore a seleção de propriedades Olive Properties no Algarve.')

@section('content')
    <header class="page-hero">
        <div class="site-container">
            <p class="eyebrow">Portefólio Olive</p>
            <h1>Propriedades no Algarve</h1>
            <p>Espaços selecionados para viver, investir e desfrutar do melhor da região.</p>
        </div>
    </header>

    <section class="catalogue section">
        <div class="site-container">
            <form action="{{ route('apartamentos.index') }}" method="GET" class="catalogue-filters">
                <div class="field catalogue-filters__search">
                    <label for="pesquisa">Pesquisar propriedades</label>
                    <input id="pesquisa" type="search" name="pesquisa" value="{{ request('pesquisa') }}" placeholder="Localização, referência ou tipologia">
                </div>
                <div class="field">
                    <label for="estado">Disponibilidade</label>
                    <select id="estado" name="estado">
                        <option value="">Todas</option>
                        <option value="Disponivel" @selected(request('estado') === 'Disponivel')>Disponíveis</option>
                        <option value="Nao Disponivel" @selected(request('estado') === 'Nao Disponivel')>Indisponíveis</option>
                    </select>
                </div>
                <div class="field">
                    <label for="ordenar">Ordenar por</label>
                    <select id="ordenar" name="ordenar">
                        <option value="">Mais recentes</option>
                        <option value="preco" @selected(request('ordenar') === 'preco')>Preço</option>
                        <option value="area" @selected(request('ordenar') === 'area')>Área</option>
                        <option value="tipologia" @selected(request('ordenar') === 'tipologia')>Tipologia</option>
                    </select>
                </div>
                <button type="submit" class="button button--primary">Pesquisar</button>
            </form>

            <div class="catalogue-summary">
                <p><strong>{{ $apartamentos->total() }}</strong> {{ $apartamentos->total() === 1 ? 'propriedade encontrada' : 'propriedades encontradas' }}</p>
                @if(request()->hasAny(['pesquisa', 'estado', 'ordenar']))<a href="{{ route('apartamentos.index') }}">Limpar filtros</a>@endif
            </div>

            @if($apartamentos->isNotEmpty())
                <div class="property-grid">
                    @foreach($apartamentos as $apartamento)<x-property-card :property="$apartamento" />@endforeach
                </div>
                @if($apartamentos->hasPages())<div class="pagination-wrap">{{ $apartamentos->links() }}</div>@endif
            @else
                <div class="empty-state">
                    <h2>Não encontrámos propriedades</h2>
                    <p>Experimente ajustar a localização ou remover alguns filtros.</p>
                    <a href="{{ route('apartamentos.index') }}" class="button button--outline">Ver todas as propriedades</a>
                </div>
            @endif
        </div>
    </section>
@endsection
