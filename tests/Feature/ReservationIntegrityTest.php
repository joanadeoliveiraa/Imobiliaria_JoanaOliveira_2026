<?php

use App\Models\Apartamento;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('does not allow a reservation for an unavailable property', function () {
    $admin = User::factory()->create(['tipo' => 'administrador']);
    $cliente = Cliente::create([
        'nome' => 'Maria Silva',
        'email' => 'maria@example.com',
        'telefone' => '912345678',
        'morada' => 'Faro',
        'nif' => '123456789',
    ]);
    $apartamento = Apartamento::create([
        'referencia' => 'ALG999',
        'tipologia' => 'T2',
        'morada' => 'Albufeira',
        'area' => 90,
        'preco' => 1200,
        'estado' => 'Nao Disponivel',
    ]);

    $response = $this->actingAs($admin)->post(route('vendas.store'), [
        'cliente_id' => $cliente->id,
        'apartamento_id' => $apartamento->id,
        'data_entrada' => now()->addDays(7)->toDateString(),
        'data_saida' => now()->addDays(14)->toDateString(),
        'valor_total' => 1,
    ]);

    $response->assertSessionHasErrors('apartamento_id');
    expect(Venda::count())->toBe(0);
});

it('uses the property price instead of a manipulated submitted value', function () {
    $admin = User::factory()->create(['tipo' => 'administrador']);
    $cliente = Cliente::create([
        'nome' => 'João Costa',
        'email' => 'joao@example.com',
        'telefone' => '919876543',
        'morada' => 'Lagos',
        'nif' => '987654321',
    ]);
    $apartamento = Apartamento::create([
        'referencia' => 'ALG998',
        'tipologia' => 'T1',
        'morada' => 'Lagos',
        'area' => 60,
        'preco' => 850,
        'estado' => 'Disponivel',
    ]);

    $response = $this->actingAs($admin)->post(route('vendas.store'), [
        'cliente_id' => $cliente->id,
        'apartamento_id' => $apartamento->id,
        'data_entrada' => now()->addDays(7)->toDateString(),
        'data_saida' => now()->addDays(14)->toDateString(),
        'valor_total' => 1,
    ])->assertRedirect();
    $this->post($response->headers->get('Location'), ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertRedirect();

    expect(Venda::first()->valor_total)->toBe('850.00')
        ->and($apartamento->fresh()->estado)->toBe('Disponivel');
});
