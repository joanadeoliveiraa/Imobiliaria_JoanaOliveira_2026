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

    @include('layouts.header')

    <main id="conteudo">
        @yield('content')
    </main>

    @include('layouts.footer')
    @include('legal.cookie-notice')
    @stack('scripts')
</body>
</html>
