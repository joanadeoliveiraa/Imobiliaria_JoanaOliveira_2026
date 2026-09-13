@csrf
<div class="form-grid">
    @foreach(['nome' => 'Nome', 'email' => 'Email', 'telefone' => 'Telefone', 'morada' => 'Morada', 'nif' => 'NIF'] as $field => $label)
        <div class="field {{ $field === 'morada' ? 'form-grid__full' : '' }}">
            <label for="{{ $field }}">{{ $label }} *</label>
            <input id="{{ $field }}" name="{{ $field }}" type="{{ $field === 'email' ? 'email' : ($field === 'telefone' ? 'tel' : 'text') }}"
                value="{{ old($field, $cliente->{$field} ?? '') }}" required
                @if($field === 'nif') inputmode="numeric" pattern="[0-9]{9}" maxlength="9" @endif
                aria-describedby="{{ $field }}-error">
            <span id="{{ $field }}-error" class="field-error">@error($field){{ $message }}@enderror</span>
        </div>
    @endforeach
</div>
<p class="field-help">* Campos obrigatórios.</p>
