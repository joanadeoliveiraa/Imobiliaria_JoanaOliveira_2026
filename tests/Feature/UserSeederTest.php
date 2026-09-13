<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    config(['seeding.admin' => [
        'name' => 'Admin local',
        'email' => 'admin@example.test',
        'password' => 'Local-test-password-2026',
    ]]);
});

it('creates an administrator who can log in and access the dashboard', function () {
    $this->seed(UserSeeder::class);
    $this->post('/login', ['email' => 'admin@example.test', 'password' => 'Local-test-password-2026'])
        ->assertRedirect('/dashboard');
    $this->assertAuthenticated();
    $this->get('/dashboard')->assertOk();
});

it('preserves existing passwords and does not duplicate users', function () {
    $this->seed(UserSeeder::class);
    config(['seeding.admin.password' => 'Different-test-password']);
    $this->seed(UserSeeder::class);
    expect(User::count())->toBe(1)
        ->and(Hash::check('Local-test-password-2026', User::first()->password))->toBeTrue();
});

it('does not promote an existing ordinary account', function () {
    $user = User::factory()->create(['email' => 'admin@example.test', 'tipo' => 'cliente']);
    expect(fn () => $this->seed(UserSeeder::class))->toThrow(RuntimeException::class);
    expect($user->fresh()->tipo)->toBe('cliente');
});

it('refuses demo accounts in production', function () {
    app()->instance('env', 'production');
    expect(fn () => (new UserSeeder)->run())->toThrow(RuntimeException::class);
    expect(User::count())->toBe(0);
});

it('requires explicitly configured credentials', function () {
    config(['seeding.admin.password' => null]);
    expect(fn () => $this->seed(UserSeeder::class))->toThrow(RuntimeException::class);
    expect(User::count())->toBe(0);
});
