<?php

use App\Models\Apartamento;
use App\Models\Atividade;
use App\Models\Cliente;
use App\Models\PagamentoSimulado;
use App\Models\User;
use App\Models\Venda;

beforeEach(function () {
    $this->admin = User::factory()->create(['tipo' => 'administrador']);
    $this->client = Cliente::create(['nome' => 'Cliente Teste', 'email' => 'cliente@example.test', 'telefone' => '912345678', 'morada' => 'Faro', 'nif' => '123456789']);
    $this->property = Apartamento::create(['referencia' => 'SIM001', 'tipologia' => 'T2', 'morada' => 'Olhão Marina', 'area' => 90, 'preco' => 700, 'estado' => 'Disponivel']);
    $this->bookingData = ['cliente_id' => $this->client->id, 'apartamento_id' => $this->property->id, 'data_entrada' => now()->addDays(7)->toDateString(), 'data_saida' => now()->addDays(17)->toDateString()];
    $this->actingAs($this->admin);
});

function beginCheckout($test, array $overrides = []): string
{
    return $test->post(route('vendas.store'), array_replace($test->bookingData, $overrides))->assertRedirect()->headers->get('Location');
}

it('only creates the booking after approved simulation and keeps a printable immutable receipt', function () {
    $url = beginCheckout($this, ['valor_total' => 1]);
    expect(Venda::count())->toBe(0)->and($this->property->fresh()->estado)->toBe('Disponivel');
    $this->get($url)->assertOk()->assertSee('Pagamento simulado')->assertSee('1.000,00')->assertSee('Olhão Marina');
    $confirmation = $this->post($url, ['metodo' => 'mbway', 'resultado' => 'aprovado', 'valor_total' => 1])->assertRedirect()->headers->get('Location');
    expect(Venda::count())->toBe(1)->and(PagamentoSimulado::count())->toBe(1)
        ->and(Venda::first()->valor_total)->toBe('1000.00')->and($this->property->fresh()->estado)->toBe('Nao Disponivel');
    $this->get($confirmation)->assertOk()->assertSee('Reserva confirmada')->assertSee('SEM COBRANÇA REAL')->assertSee('Imprimir / Guardar PDF')->assertSee('cliente@example.test');
    $this->client->update(['nome' => 'Nome atualizado']);
    $this->property->update(['morada' => 'Localização atualizada']);
    $this->get($confirmation)->assertSee('Cliente Teste')->assertSee('Olhão Marina')->assertDontSee('Nome atualizado');
});

it('allows a refused simulation to be retried without creating records prematurely', function () {
    $url = beginCheckout($this);
    $this->from($url)->post($url, ['metodo' => 'cartao', 'resultado' => 'recusado'])->assertRedirect($url)->assertSessionHasErrors('pagamento');
    expect(Venda::count())->toBe(0)->and(PagamentoSimulado::count())->toBe(0)->and($this->property->fresh()->estado)->toBe('Disponivel');
    $this->post($url, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertRedirect();
    expect(Venda::count())->toBe(1);
});

it('does not duplicate bookings or payments when the payment is submitted again', function () {
    $url = beginCheckout($this);
    $confirmation = $this->post($url, ['metodo' => 'transferencia', 'resultado' => 'aprovado'])->assertRedirect()->headers->get('Location');
    $this->post($url, ['metodo' => 'transferencia', 'resultado' => 'aprovado'])->assertRedirect($confirmation);
    $this->get($url)->assertRedirect($confirmation);
    expect(Venda::count())->toBe(1)->and(PagamentoSimulado::count())->toBe(1)->and(Atividade::count())->toBe(1);
});

it('rechecks availability when another draft was confirmed first', function () {
    $first = beginCheckout($this);
    $second = beginCheckout($this);
    $this->post($first, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertRedirect();
    $this->from($second)->post($second, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertSessionHasErrors('apartamento_id');
    expect(Venda::count())->toBe(1);
});

it('rejects a stale quote instead of confirming an unseen price', function () {
    $url = beginCheckout($this);
    $this->property->update(['preco' => 1400]);
    $this->from($url)->post($url, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertSessionHasErrors('reserva');
    expect(Venda::count())->toBe(0);
});

it('expires abandoned drafts and preserves the property', function () {
    $url = beginCheckout($this);
    $this->travel(31)->minutes();
    $this->post($url, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertRedirect(route('vendas.create'))->assertSessionHasErrors('reserva');
    expect(Venda::count())->toBe(0)->and($this->property->fresh()->estado)->toBe('Disponivel');
});

it('does not allow another administrator to use a draft from the same session', function () {
    $url = beginCheckout($this);
    $this->actingAs(User::factory()->create(['tipo' => 'administrador']));
    $this->post($url, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertRedirect(route('vendas.create'));
    expect(Venda::count())->toBe(0);
});

it('validates dates and payment choices on the server', function () {
    $this->post(route('vendas.store'), array_replace($this->bookingData, ['data_entrada' => now()->subDay()->toDateString()]))->assertSessionHasErrors('data_entrada');
    $this->post(route('vendas.store'), array_replace($this->bookingData, ['data_saida' => $this->bookingData['data_entrada']]))->assertSessionHasErrors('data_saida');
    $url = beginCheckout($this);
    $this->post($url, ['metodo' => 'real', 'resultado' => 'aprovado'])->assertSessionHasErrors('metodo');
    expect(Venda::count())->toBe(0);
});

it('restores the selected client, property and dates when returning to step one', function () {
    $url = beginCheckout($this);
    $token = basename($url);
    $this->get(route('vendas.create', ['rascunho' => $token]))->assertOk()->assertSee('value="'.$this->bookingData['data_entrada'].'"', false);
});

it('does not expose payment or confirmation to ordinary users', function () {
    $url = beginCheckout($this);
    $confirmation = $this->post($url, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->headers->get('Location');
    $this->actingAs(User::factory()->create(['tipo' => 'cliente']));
    $this->get($url)->assertForbidden();
    $this->post($url, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertForbidden();
    $this->get($confirmation)->assertForbidden();
});
