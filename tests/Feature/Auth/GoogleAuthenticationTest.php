<?php

use App\Models\Cliente;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;

beforeEach(function () {
    config()->set('services.google', [
        'client_id' => 'test-client', 'client_secret' => 'test-secret',
        'redirect' => 'http://localhost/auth/google/callback',
    ]);
});

function mockGoogleIdentity(string $email = 'cliente@example.test', bool $verified = true): void
{
    $identity = (new GoogleUser)->setRaw(['email_verified' => $verified])->map([
        'id' => 'google-123', 'name' => 'Cliente Google', 'email' => $email,
    ]);
    Socialite::shouldReceive('driver')->with('google')->andReturnSelf();
    Socialite::shouldReceive('user')->andReturn($identity);
}

it('shows registration and Google entry points on the account screens', function () {
    $this->get(route('login'))->assertOk()->assertSee(route('register'))->assertSee(route('auth.google'));
    $this->get(route('register'))->assertOk()->assertSee('Criar conta de cliente')->assertSee('Confirmar palavra-passe');
});

it('handles missing Google configuration without sending the visitor to Google', function () {
    config()->set('services.google.client_id', null);
    $this->get(route('login'))->assertOk()->assertSee('Disponível em breve');
    $this->get(route('auth.google'))->assertRedirect(route('login'))->assertSessionHasErrors('google');
    $this->assertGuest();
});

it('starts OAuth with a session state and rejects a mismatching callback', function () {
    $response = $this->get(route('auth.google'))->assertRedirect();
    parse_str(parse_url($response->headers->get('Location'), PHP_URL_QUERY), $query);
    expect(parse_url($response->headers->get('Location'), PHP_URL_HOST))->toBe('accounts.google.com');
    expect($query['state'])->toBe(session('state'))->not->toBeEmpty();
    $this->get(route('auth.google.callback', ['state' => 'wrong', 'code' => 'fake']))
        ->assertRedirect(route('login'))->assertSessionHasErrors('google');
    $this->assertGuest();
    expect(User::count())->toBe(0);
});

it('creates a client from Google and reuses the same account on later logins', function () {
    mockGoogleIdentity();
    $this->get(route('auth.google.callback'))->assertRedirect(route('client.home'));
    $user = User::first();
    $this->assertAuthenticatedAs($user);
    expect($user->tipo)->toBe('cliente')->and($user->google_id)->toBe('google-123')
        ->and($user->email_verified_at)->not->toBeNull()->and($user->cliente)->not->toBeNull();
    $this->post(route('logout'));
    $this->get(route('auth.google.callback'))->assertRedirect(route('client.home'));
    expect(User::count())->toBe(1)->and(Cliente::count())->toBe(1);
});

it('does not claim existing accounts by email', function (string $role) {
    $user = User::factory()->create(['email' => 'existing@example.test', 'tipo' => $role]);
    mockGoogleIdentity($user->email);
    $this->get(route('auth.google.callback'))->assertRedirect(route('login'))->assertSessionHasErrors('google');
    $this->assertGuest();
    expect($user->fresh()->google_id)->toBeNull()->and(User::count())->toBe(1);
})->with(['cliente', 'administrador']);

it('rejects Google login for an account promoted to administrator', function () {
    $user = User::factory()->create(['tipo' => 'administrador']);
    $user->forceFill(['google_id' => 'google-123'])->save();
    mockGoogleIdentity();
    $this->get(route('auth.google.callback'))->assertRedirect(route('login'))->assertSessionHasErrors('google');
    $this->assertGuest();
});

it('rejects an unverified Google email', function () {
    mockGoogleIdentity(verified: false);
    $this->get(route('auth.google.callback'))->assertRedirect(route('login'))->assertSessionHasErrors('google');
    $this->assertGuest();
    expect(User::count())->toBe(0);
});

it('handles consent cancellation', function () {
    $this->withSession(['state' => 'old'])->get(route('auth.google.callback', ['error' => 'access_denied']))
        ->assertRedirect(route('login'))->assertSessionHasErrors('google')->assertSessionMissing('state');
    $this->assertGuest();
});
