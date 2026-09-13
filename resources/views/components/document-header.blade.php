@props(['title', 'reference' => null, 'scope' => null, 'printOnly' => true])
<header @class(['document-header', 'apenas-impressao' => $printOnly])>
    <div class="document-header__top">
        <div class="document-header__brand"><img src="{{ asset('images/logo_folhaVerde.png') }}" alt="" width="56" height="56"><span>OLIVE<small>PROPERTIES</small></span></div>
        <span class="document-header__label">{{ $reference ?? 'Relatório de gestão' }}</span>
    </div>
    <h2>{{ $title }}</h2>
    <dl class="document-header__metadata">
        <div><dt>Data e hora de emissão · Lisboa</dt><dd><time data-document-issued-at datetime="{{ now()->toIso8601String() }}">{{ now()->timezone('Europe/Lisbon')->format('d/m/Y H:i:s') }}</time></dd></div>
        <div><dt>Documento gerado por</dt><dd>{{ auth()->user()?->name ?? 'Utilizador não identificado' }}</dd></div>
    </dl>
    @if($scope)<p class="document-header__scope">{{ $scope }}</p>@endif
</header>
