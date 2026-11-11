@props(['default' => ''])
<div class="field form-grid__full" x-data="{ subject: @js(old('assunto', $default)) }">
    <label for="assunto">Assunto *</label>
    <select id="assunto" name="assunto" x-model="subject" required aria-invalid="{{ $errors->has('assunto') ? 'true' : 'false' }}" aria-describedby="assunto-error">
        <option value="" disabled @selected(old('assunto', $default) === '')>Selecione o assunto</option>
        @foreach(\App\Support\ContactSubjects::OPTIONS as $subject)
            <option value="{{ $subject }}" @selected(old('assunto', $default) === $subject)>{{ $subject }}</option>
        @endforeach
    </select>
    <span id="assunto-error" class="field-error">@error('assunto'){{ $message }}@enderror</span>
    <div class="field" x-cloak x-show="subject === 'Outros assuntos'">
        <label for="outro-assunto">Especifique o assunto *</label>
        <input id="outro-assunto" name="outro_assunto" value="{{ old('outro_assunto') }}" minlength="3" maxlength="120" :required="subject === 'Outros assuntos'" :disabled="subject !== 'Outros assuntos'" aria-describedby="outro-assunto-error" aria-invalid="{{ $errors->has('outro_assunto') ? 'true' : 'false' }}">
        <span id="outro-assunto-error" class="field-error">@error('outro_assunto'){{ $message }}@enderror</span>
    </div>
</div>
