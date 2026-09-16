<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @include('auth.google-button')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="field mt-4">
            <label for="password">Palavra-passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="auth-options">
            <label for="remember_me"><input id="remember_me" type="checkbox" name="remember"> Lembrar-me</label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Recuperar palavra-passe</a>
            @endif
        </div>
        <button class="button button--primary auth-submit" type="submit">Entrar</button>
    </form>
    <p class="auth-switch">Ainda não tem conta? <a href="{{ route('register') }}">Criar conta de cliente</a></p>
</x-guest-layout>
