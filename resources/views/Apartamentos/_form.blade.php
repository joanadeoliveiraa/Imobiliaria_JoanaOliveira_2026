@php($editing = isset($apartamento))

<div class="form-grid">
    @if($editing)
        <div class="field form-grid__full">
            <label for="referencia">Referência</label>
            <input id="referencia" value="{{ $apartamento->referencia }}" disabled>
        </div>
    @endif

    <div class="field">
        <label for="tipologia">Tipologia</label>
        <input id="tipologia" name="tipologia" value="{{ old('tipologia', $apartamento->tipologia ?? '') }}" placeholder="Ex.: T2" required>
        @error('tipologia')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="field">
        <label for="estado">Estado</label>
        <select id="estado" name="estado" required>
            <option value="Disponivel" @selected(old('estado', $apartamento->estado ?? 'Disponivel') === 'Disponivel')>Disponível</option>
            <option value="Nao Disponivel" @selected(old('estado', $apartamento->estado ?? '') === 'Nao Disponivel')>Indisponível</option>
        </select>
        @error('estado')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="field form-grid__full">
        <label for="morada">Localização</label>
        <input id="morada" name="morada" value="{{ old('morada', $apartamento->morada ?? '') }}" placeholder="Ex.: Marina de Vilamoura" required>
        @error('morada')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="field">
        <label for="area">Área (m²)</label>
        <input id="area" type="number" name="area" min="1" max="999999.99" step="0.01" value="{{ old('area', $apartamento->area ?? '') }}" required>
        @error('area')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="field">
        <label for="preco">Preço semanal (€)</label>
        <input id="preco" type="number" name="preco" min="0" max="99999999.99" step="0.01" value="{{ old('preco', $apartamento->preco ?? '') }}" required>
        @error('preco')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div class="field form-grid__full">
        <label for="fotografia">Fotografia</label>
        <input id="fotografia" type="file" name="fotografia" accept="image/jpeg,image/png,image/webp" aria-describedby="fotografia-ajuda">
        <span id="fotografia-ajuda" class="field-help">JPG, PNG ou WebP, até 5 MB.@if($editing) Deixe vazio para manter a fotografia atual.@endif</span>
        @error('fotografia')<span class="field-error">{{ $message }}</span>@enderror
    </div>
</div>

@if($editing && $apartamento->fotografia)
    <div class="current-image">
        <span>Fotografia atual</span>
        <img src="{{ asset('storage/'.$apartamento->fotografia) }}" alt="{{ $apartamento->tipologia }} em {{ $apartamento->morada }}">
    </div>
@endif

<div class="form-actions">
    <button type="submit" class="button button--primary">{{ $editing ? 'Guardar alterações' : 'Adicionar propriedade' }}</button>
    <a href="{{ route('admin.apartamentos.index') }}" class="button button--ghost">Cancelar</a>
</div>
