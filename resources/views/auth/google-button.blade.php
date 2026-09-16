<div class="auth-social">
    <x-input-error :messages="$errors->get('google')" class="mb-4" />
    @if(config('services.google.client_id') && config('services.google.client_secret'))
        <a class="button button--outline auth-submit" href="{{ route('auth.google') }}">Continuar com Google</a>
    @else
        <button class="button button--outline auth-submit" type="button" disabled aria-describedby="google-unavailable">Continuar com Google</button>
        <p id="google-unavailable" class="auth-social__note">Disponível em breve. Pode criar a sua conta com email.</p>
    @endif
    <p class="auth-social__divider">ou use o seu email</p>
</div>
