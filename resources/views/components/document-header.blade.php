@props(['title', 'reference' => null, 'scope' => null, 'printOnly' => true])
<header @class(['document-header', 'apenas-impressao' => $printOnly])>
    <div class="document-header__top">
        <a href="{{ route('home') }}" class="document-header__brand brand" aria-label="Olive Properties — início"><img src="{{ asset('images/logo_folhaVerde.png') }}" alt="" class="brand__mark"><span class="brand__wordmark"><strong>Olive</strong><small>Properties</small></span></a>
        <span class="document-header__label">{{ $reference ?? 'Relatório de gestão' }}</span>
    </div>
    <h2>{{ $title }}</h2>
    <dl class="document-header__metadata">
        <div><dt>Data e hora de emissão · Lisboa</dt><dd><time data-document-issued-at datetime="{{ now()->toIso8601String() }}">{{ now()->timezone('Europe/Lisbon')->format('d/m/Y H:i:s') }}</time></dd></div>
        <div><dt>Documento gerado por</dt><dd>{{ auth()->user()?->name ?? 'Utilizador não identificado' }}</dd></div>
    </dl>
    @if($scope)<p class="document-header__scope">{{ $scope }}</p>@endif
</header>
