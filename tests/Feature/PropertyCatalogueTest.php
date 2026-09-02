<?php

use App\Models\Apartamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createProperty(array $attributes = []): Apartamento
{
    return Apartamento::create(array_merge([
        'referencia' => 'ALG100',
        'tipologia' => 'T2',
        'morada' => 'Vilamoura',
        'area' => 95,
        'preco' => 1200,
        'estado' => Apartamento::ESTADO_DISPONIVEL,
    ], $attributes));
}

it('shows properties in the public catalogue', function () {
    createProperty();

    $this->get(route('apartamentos.index'))
        ->assertOk()
        ->assertSee('ALG100')
        ->assertSee('Vilamoura');
});

it('combines search and availability filters correctly', function () {
    createProperty();
    createProperty([
        'referencia' => 'ALG101',
        'morada' => 'Vilamoura Marina',
        'estado' => Apartamento::ESTADO_INDISPONIVEL,
    ]);

    $this->get(route('apartamentos.index', [
        'pesquisa' => 'Vilamoura',
        'estado' => Apartamento::ESTADO_DISPONIVEL,
    ]))
        ->assertOk()
        ->assertSee('ALG100')
        ->assertDontSee('ALG101');
});

it('protects the property management list', function () {
    $this->get(route('admin.apartamentos.index'))->assertRedirect(route('login'));

    $cliente = User::factory()->create(['tipo' => 'cliente']);
    $this->actingAs($cliente)->get(route('admin.apartamentos.index'))->assertForbidden();

    $admin = User::factory()->create(['tipo' => 'administrador']);
    $this->actingAs($admin)->get(route('admin.apartamentos.index'))->assertOk();
    $this->actingAs($admin)->get(route('apartamentos.create'))->assertOk();
});
