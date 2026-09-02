@extends('layouts.public')

@section('title', $apartamento->referencia.' — '.$apartamento->morada.' | Olive Properties')

@section('content')
    <article class="property-detail">
        <div class="site-container property-detail__breadcrumb">
            <a href="{{ route('apartamentos.index') }}">Propriedades</a><span aria-hidden="true">/</span><span>{{ $apartamento->referencia }}</span>
        </div>

        <div class="site-container property-detail__layout">
            <div class="property-detail__media">
                @if($apartamento->fotografia)
                    <img src="{{ asset('storage/'.$apartamento->fotografia) }}" alt="{{ $apartamento->tipologia }} em {{ $apartamento->morada }}">
                @else
                    <div class="property-detail__placeholder">Imagem brevemente disponível</div>
                @endif
            </div>
            <div class="property-detail__content">
                <div class="property-detail__heading">
                    <p class="eyebrow">{{ $apartamento->referencia }} · {{ $apartamento->tipologia }}</p>
                    <h1>{{ $apartamento->morada }}</h1>
                    <span class="badge {{ $apartamento->estado === 'Disponivel' ? 'badge--success' : 'badge--neutral' }}">{{ $apartamento->estado === 'Disponivel' ? 'Disponível' : 'Indisponível' }}</span>
                </div>
                <dl class="property-facts">
                    <div><dt>Tipologia</dt><dd>{{ $apartamento->tipologia }}</dd></div>
                    <div><dt>Área</dt><dd>{{ number_format((float) $apartamento->area, 0, ',', '.') }} m²</dd></div>
                    <div><dt>Valor semanal</dt><dd>{{ number_format((float) $apartamento->preco, 2, ',', '.') }} €</dd></div>
                </dl>
                <div class="property-detail__copy">
                    <h2>Sobre esta propriedade</h2>
                    <p>Uma propriedade Olive Properties cuidadosamente selecionada pela localização, conforto e qualidade. Contacte a nossa equipa para receber informação detalhada e esclarecer todas as suas questões.</p>
                </div>
                <div class="property-detail__actions">
                    <a href="{{ route('contactos', ['referencia' => $apartamento->referencia]) }}" class="button button--primary">Pedir informações</a>
                    <a href="{{ route('apartamentos.index') }}" class="button button--outline">Voltar ao catálogo</a>
                    @auth
                        @if(auth()->user()->tipo === 'administrador')<a href="{{ route('apartamentos.edit', $apartamento) }}" class="button button--ghost">Editar propriedade</a>@endif
                    @endauth
                </div>
            </div>
        </div>
    </article>
@endsection
