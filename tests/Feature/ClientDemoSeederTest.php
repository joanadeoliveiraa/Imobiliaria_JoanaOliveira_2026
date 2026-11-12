<?php

use App\Models\Apartamento;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Venda;
use Database\Seeders\ClientDemoSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    config(['seeding.client_password' => 'Demo-test-password!2026']);
});

it('creates the demo client and permits login and client pages only', function () {
    $this->seed(ClientDemoSeeder::class);
    $user = User::where('email', 'joana@oliveproperties.test')->sole();
    expect($user->name)->toBe('Joana Oliveira')->and($user->tipo)->toBe('cliente')
        ->and($user->email_verified_at)->not->toBeNull()->and($user->cliente)->not->toBeNull();
    $this->post('/login', ['email' => $user->email, 'password' => 'Demo-test-password!2026'])
        ->assertRedirect('/minha-area');
    $this->assertAuthenticatedAs($user);
    foreach (['/minha-area', '/minha-area/reservas', '/minha-area/nova-reserva', '/minha-area/mensagens', '/profile'] as $url) {
        $this->get($url)->assertOk();
    }
    foreach (['/dashboard', '/clientes', '/vendas', '/apartamentos/create', '/backoffice/propriedades', '/backoffice/contactos'] as $url) {
        $this->get($url)->assertForbidden();
    }
});

it('allows the seeded client to reserve and consult payment history and receipts', function () {
    Mail::fake();
    $this->seed(ClientDemoSeeder::class);
    $user = User::where('email', 'joana@oliveproperties.test')->sole();
    $property = Apartamento::create(['referencia' => 'DEMO001', 'tipologia' => 'T2',
        'morada' => 'Faro', 'area' => 70, 'preco' => 700, 'estado' => 'Disponivel']);
    $this->actingAs($user);
    $summary = $this->post(route('client.reservations.start'), [
        'apartamento_id' => $property->id, 'data_entrada' => now()->addDays(7)->toDateString(),
        'data_saida' => now()->addDays(14)->toDateString(),
    ])->assertRedirect()->headers->get('Location');
    $payment = $this->post(route('client.reservations.continue', basename($summary)))
        ->assertRedirect()->headers->get('Location');
    $this->get($payment)->assertOk();
    $confirmation = $this->post($payment, ['metodo' => 'cartao', 'resultado' => 'aprovado'])
        ->assertRedirect()->headers->get('Location');
    $reservation = Venda::sole();
    expect($reservation->cliente_id)->toBe($user->cliente->id)
        ->and($reservation->pagamentoSimulado)->not->toBeNull();
    $this->get($confirmation)->assertOk();
    $this->get(route('client.reservations.index'))->assertOk()->assertSee('DEMO001');
    $this->get(route('client.reservations.show', $reservation))->assertOk();
    $this->get(route('client.reservations.receipt', $reservation))->assertOk();
    $this->actingAs(User::factory()->create(['tipo' => 'cliente']));
    $this->get(route('client.reservations.show', $reservation))->assertForbidden();
    $this->get(route('client.reservations.receipt', $reservation))->assertForbidden();
});

it('is idempotent and preserves administrators and existing credentials', function () {
    $admin = User::factory()->create(['tipo' => 'administrador']);
    $before = $admin->fresh()->getAttributes();
    $this->seed(ClientDemoSeeder::class);
    $user = User::where('email', 'joana@oliveproperties.test')->sole();
    $original = $user->getAttributes();
    config(['seeding.client_password' => 'Another-test-password!2026']);
    $this->seed(ClientDemoSeeder::class);
    expect(User::count())->toBe(2)->and(Cliente::count())->toBe(1)
        ->and($admin->fresh()->getAttributes())->toBe($before)
        ->and($user->fresh()->getAttributes())->toBe($original)
        ->and(Hash::check('Demo-test-password!2026', $user->fresh()->password))->toBeTrue();
});

it('never changes an administrator using the demo email', function () {
    $admin = User::factory()->create(['email' => 'joana@oliveproperties.test', 'tipo' => 'administrador']);
    $before = $admin->fresh()->getAttributes();
    expect(fn () => (new ClientDemoSeeder)->run())->toThrow(RuntimeException::class);
    expect($admin->fresh()->getAttributes())->toBe($before)->and(Cliente::count())->toBe(0);
});

it('rejects production and missing or short passwords', function () {
    config(['seeding.client_password' => 'short']);
    expect(fn () => (new ClientDemoSeeder)->run())->toThrow(RuntimeException::class);
    config(['seeding.client_password' => null]);
    expect(fn () => (new ClientDemoSeeder)->run())->toThrow(RuntimeException::class);
    config(['seeding.client_password' => 'Demo-test-password!2026']);
    app()->instance('env', 'production');
    expect(fn () => (new ClientDemoSeeder)->run())->toThrow(RuntimeException::class);
    expect(User::count())->toBe(0);
});
