<?php

use App\Models\Apartamento;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Venda;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('separates current occupancy from administrative unavailability and excludes exact duplicates from period totals', function () {
    CarbonImmutable::setTestNow('2026-09-15 12:00:00');
    $admin = User::factory()->create(['tipo' => 'administrador']);
    Cliente::create(['nome' => 'Cliente Teste', 'email' => 'teste@example.com', 'telefone' => '912345678', 'morada' => 'Faro', 'nif' => '123456789']);
    foreach (['ALG001' => 'Disponivel', 'ALG002' => 'Nao Disponivel'] as $reference => $state) {
        Apartamento::create(['referencia' => $reference, 'tipologia' => 'T1', 'morada' => 'Faro', 'area' => 50, 'preco' => 100, 'estado' => $state]);
    }
    $reservation = ['cliente' => 'Cliente Teste', 'apartamento' => 'ALG001', 'data_entrada' => '2026-09-14', 'data_saida' => '2026-09-17', 'valor_total' => 100];
    Venda::create($reservation);
    Venda::create($reservation);

    $queries = 0;
    DB::listen(function () use (&$queries) { $queries++; });
    $this->actingAs($admin)->get(route('dashboard'))
        ->assertOk()->assertSee('Ocupadas hoje')->assertSee('Indisponíveis')
        ->assertSee('chart-value')->assertSee('chart-state')->assertSee('chart-occupancy')
        ->assertSee(route('vendas.create'), false)->assertSee(route('clientes.create'), false)
        ->assertSee(route('apartamentos.create'), false)
        ->assertViewHas('ocupadas', 1)->assertViewHas('indisponiveis', 1)
        ->assertViewHas('reservas', 1)->assertViewHas('receita', 100.0)
        ->assertViewHas('taxaOcupacao', 50.0)
        ->assertViewHas('ocupacaoMensal', function ($series) { expect($series->last()['total'])->toBe(6.7); return true; });
    expect($queries)->toBeLessThan(30);
    $this->get(route('dashboard.report'))->assertOk()->assertSee('ALG002')->assertSee('Indisponível')
        ->assertSee('← Voltar atrás')->assertSee(route('dashboard', ['periodo' => 'mes']), false)
        ->assertSee('brand__wordmark');
    CarbonImmutable::setTestNow();
});

it('shows clear empty states when the administrative database has no operational records', function () {
    $admin = User::factory()->create(['tipo' => 'administrador']);
    $this->actingAs($admin)->get(route('dashboard'))->assertOk()
        ->assertSee('Sem situações que necessitem de atenção.')
        ->assertSee('Sem entradas próximas.')
        ->assertSee('Sem saídas próximas.')
        ->assertSee('Sem reservas no período.');
});

it('applies month and custom date filters consistently to totals, rankings and the printable report', function () {
    CarbonImmutable::setTestNow('2026-09-15 12:00:00');
    $admin = User::factory()->create(['tipo' => 'administrador']);
    Cliente::create(['nome' => 'Cliente Teste', 'email' => 'teste@example.com', 'telefone' => '912345678', 'morada' => 'Faro', 'nif' => '123456789']);
    Apartamento::create(['referencia' => 'ALG001', 'tipologia' => 'T1', 'morada' => 'Faro', 'area' => 50, 'preco' => 100, 'estado' => 'Disponivel']);
    Venda::create(['cliente' => 'Cliente Teste', 'apartamento' => 'ALG001', 'data_entrada' => '2026-08-10', 'data_saida' => '2026-08-12', 'valor_total' => 200]);
    Venda::create(['cliente' => 'Cliente Teste', 'apartamento' => 'ALG001', 'data_entrada' => '2026-09-10', 'data_saida' => '2026-09-12', 'valor_total' => 100]);

    $this->actingAs($admin)->get(route('dashboard', ['periodo' => 'anterior']))
        ->assertOk()->assertViewHas('reservas', 1)->assertViewHas('receita', 200.0)
        ->assertViewHas('topPropriedades', fn ($items) => $items->first()->total === 1);
    $filter = ['periodo' => 'personalizado', 'from' => '2026-09-01', 'to' => '2026-09-15'];
    $this->get(route('dashboard', $filter))->assertOk()->assertViewHas('receita', 100.0);
    $this->get(route('dashboard.report', $filter))->assertOk()->assertSee('01/09/2026')->assertSee('15/09/2026')->assertSee('100,00');
    $this->get(route('dashboard', ['periodo' => 'personalizado', 'from' => '2026-09-01', 'to' => '2026-09-30']))->assertSessionHasErrors('to');
    CarbonImmutable::setTestNow();
});
