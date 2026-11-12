@extends('layouts.public')
@section('title', 'Perguntas Frequentes — Olive Properties')
@section('meta_description', 'Respostas às perguntas mais frequentes sobre reservas, pagamentos, estadias e a sua conta na Olive Properties.')
@section('content')
<section class="page-hero"><div class="site-container">
    <p class="eyebrow">Olive Properties · Estamos aqui para ajudar</p>
    <h1>Perguntas Frequentes</h1>
    <p>Encontre a informação de que precisa para preparar a sua estadia.</p>
</div></section>
<section class="section"><div class="site-container" x-data="faqTabs">
    <div class="faq-tabs" role="tablist" aria-label="Categorias de perguntas" x-cloak>
        @foreach(config('faqs') as $category)
            <button type="button" role="tab" id="faq-tab-{{ $loop->index }}" aria-controls="faq-panel-{{ $loop->index }}"
                :aria-selected="active === {{ $loop->index }}" :tabindex="active === {{ $loop->index }} ? 0 : -1"
                @click="active = {{ $loop->index }}" @keydown="navigate($event, {{ $loop->index }}, {{ count(config('faqs')) }})">{{ $category['title'] }}</button>
        @endforeach
    </div>
    @foreach(config('faqs') as $category)
        <section class="faq-panel" id="faq-panel-{{ $loop->index }}" :role="'tabpanel'" :aria-labelledby="'faq-tab-{{ $loop->index }}'"
            :hidden="active !== {{ $loop->index }}" tabindex="0">
            <h2>{{ $category['title'] }}</h2>
            @foreach($category['items'] as [$question, $answer])
                <details class="faq-item" @if($loop->first) open @endif>
                    <summary>{{ $question }}</summary>
                    <div class="faq-answer"><p>{{ $answer }}</p>
                        <a href="{{ route('contactos', ['assunto' => $category['subject']]) }}">Contactar sobre este tema<span class="sr-only">: {{ $question }}</span></a>
                    </div>
                </details>
            @endforeach
        </section>
    @endforeach
    <section class="help-card" aria-labelledby="faq-contact-title">
        <h2 id="faq-contact-title">Ainda tem dúvidas?</h2>
        <p>Não encontrou a resposta que procurava? A nossa equipa está disponível para ajudar.</p>
        <a class="button button--primary" href="{{ route('contactos') }}">Entre em contacto</a>
    </section>
</div></section>
@endsection
