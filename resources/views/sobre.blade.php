@extends('layouts.public')
@section('title', 'Sobre nós — Olive Properties')
@section('content')
<section class="page-hero"><div class="site-container">
    <p class="eyebrow">Olive Properties · Algarve</p>
    <h1>A nossa história</h1>
    <p>Conheça a origem e os valores da Olive Properties.</p>
</div></section>
<section class="section"><div class="site-container">
    <div class="editorial-copy"><p class="lead">
                    A Olive Properties nasceu de uma ligação profunda à terra,
                    às tradições e aos valores que definem a nossa identidade.
                </p>

                <p>
                    Inspirado no apelido da família Oliveira, o nome da empresa
                    reflete as nossas raízes e o respeito pelas pessoas,
                    pela autenticidade e pela beleza única do Algarve.
                </p>
                <p>
                    Especializamo-nos na gestão de alojamentos turísticos,
                    oferecendo aos proprietários um serviço de excelência e aos
                    hóspedes experiências memoráveis em destinos cuidadosamente
                    selecionados.
                </p>
                <p>
                    Acreditamos que as melhores férias vão muito além de um lugar
                    para ficar. São momentos de descanso, descoberta e partilha
                    que se transformam em recordações para toda a vida.
                </p>
                <p>
                    Por isso, cada propriedade que gerimos é preparada com atenção
                    ao detalhe, conforto e qualidade, garantindo estadias à altura
                    das expectativas dos nossos hóspedes.
                </p>
                <p>
                    Guiados pela confiança, profissionalismo e proximidade,
                    trabalhamos diariamente para proporcionar experiências
                    autênticas que refletem o melhor da hospitalidade algarvia.
                </p>
                <blockquote> Não gerimos apenas propriedades.
                    Criamos ambientes onde nascem memórias inesquecíveis.
                </blockquote>
            </div>
    <img src="{{ asset('images/familia-oliveira.jpg') }}" alt="Família Oliveira" class="about-image">
    <a href="{{ route('home') }}" class="button button--outline">Voltar ao início</a>
</div></section>
@endsection
