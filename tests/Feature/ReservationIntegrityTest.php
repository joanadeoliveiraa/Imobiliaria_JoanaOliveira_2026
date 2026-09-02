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
        'cliente' => $cliente->nome,
        'apartamento' => $apartamento->referencia,
        'data_entrada' => '2026-09-10',
        'data_saida' => '2026-09-17',
        'valor_total' => 1,
    ]);

    $response->assertSessionHasErrors('apartamento');
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

    $this->actingAs($admin)->post(route('vendas.store'), [
        'cliente' => $cliente->nome,
        'apartamento' => $apartamento->referencia,
        'data_entrada' => '2026-09-10',
        'data_saida' => '2026-09-17',
        'valor_total' => 1,
    ])->assertOk();

    expect(Venda::first()->valor_total)->toBe('850.00')
        ->and($apartamento->fresh()->estado)->toBe('Nao Disponivel');
});
