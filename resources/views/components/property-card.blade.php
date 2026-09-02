@props(['property'])

<article class="property-card">
    <a href="{{ route('apartamentos.show', $property) }}" class="property-card__media" aria-label="Ver {{ $property->referencia }} em {{ $property->morada }}">
        @if($property->fotografia)
            <img src="{{ asset('storage/'.$property->fotografia) }}" alt="{{ $property->tipologia }} em {{ $property->morada }}" loading="lazy">
        @else
            <div class="property-card__placeholder" aria-hidden="true">Olive Properties</div>
        @endif
        <span class="badge {{ $property->estado === \App\Models\Apartamento::ESTADO_DISPONIVEL ? 'badge--success' : 'badge--neutral' }}">
            {{ $property->estado === \App\Models\Apartamento::ESTADO_DISPONIVEL ? 'Disponível' : 'Indisponível' }}
        </span>
    </a>
    <div class="property-card__body">
        <div class="property-card__eyebrow">{{ $property->referencia }} · {{ $property->tipologia }}</div>
        <h3><a href="{{ route('apartamentos.show', $property) }}">{{ $property->morada }}</a></h3>
        <div class="property-card__meta">
            <span>{{ number_format((float) $property->area, 0, ',', '.') }} m²</span>
            <strong>{{ number_format((float) $property->preco, 0, ',', '.') }} €<small>/semana</small></strong>
        </div>
    </div>
</article>
