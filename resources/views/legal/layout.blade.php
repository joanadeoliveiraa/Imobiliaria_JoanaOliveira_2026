@extends('layouts.public')

@section('content')
<div class="site-container legal-page">
    <header class="legal-page__header">
        <p class="eyebrow">Olive Properties · Informação legal</p>
        <h1>@yield('legal_title')</h1>
        <p>@yield('legal_intro')</p>
    </header>
    <article class="legal-copy" aria-label="@yield('legal_title')">
        @yield('legal_content')
    </article>
</div>
@endsection
