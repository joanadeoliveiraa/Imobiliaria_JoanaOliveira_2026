<?php

use App\Models\Apartamento;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Venda;

it('renders management screens with one common header and footer and preserves records', function () {
    $admin = User::factory()->create(['tipo' => 'administrador']);
    $cliente = Cliente::create(['nome' => 'Cliente QA', 'email' => 'qa@example.test', 'telefone' => '912345678', 'morada' => 'Faro', 'nif' => '123456789']);
    $apartamento = Apartamento::create(['referencia' => 'QA001', 'tipologia' => 'T2', 'morada' => 'Faro', 'area' => 80, 'preco' => 950, 'estado' => 'Disponivel']);
    $venda = Venda::create(['cliente' => $cliente->nome, 'apartamento' => $apartamento->referencia, 'data_entrada' => '2026-10-01', 'data_saida' => '2026-10-08', 'valor_total' => 950]);
    $before = [$cliente->fresh()->toArray(), $apartamento->fresh()->toArray(), $venda->fresh()->toArray()];
    $this->actingAs($admin);
    $urls = ['/dashboard', '/backoffice/propriedades', '/apartamentos/create', '/apartamentos/'.$apartamento->id.'/edit', '/clientes', '/clientes/create', '/clientes/'.$cliente->id, '/clientes/'.$cliente->id.'/edit', route('clientes.reservas', $cliente->nome), '/vendas', '/vendas/create', '/vendas/'.$venda->id, '/vendas/'.$venda->id.'/edit', '/profile'];
    foreach ($urls as $url) {
        $response = $this->get($url)->assertOk()
            ->assertSee('images/folhas_brancas.png')
            ->assertSee('Projeto desenvolvido em homenagem às raízes da família Oliveira.')
            ->assertSee('Terminar sessão');
        expect(substr_count($response->getContent(), 'class="public-header"'))->toBe(1)
            ->and(substr_count($response->getContent(), 'class="public-footer"'))->toBe(1);
    }
    expect([$cliente->fresh()->toArray(), $apartamento->fresh()->toArray(), $venda->fresh()->toArray()])->toBe($before);
    $this->get('/vendas/'.$venda->id.'/edit')->assertSee('value="2026-10-01"', false)->assertSee('value="2026-10-08"', false);
    $this->get('/vendas')->assertSee('data-delete-url="'.route('vendas.destroy', $venda->id).'"', false);
});

it('shows the shared layout on account screens without exposing administrator navigation', function () {
    $user = User::factory()->create(['tipo' => 'cliente']);
    $this->actingAs($user)->get('/profile')->assertOk()->assertSee('O meu perfil')->assertSee('Informação legal')->assertDontSee('href="'.route('clientes.index').'"', false);
    $this->get('/dashboard')->assertForbidden();
});

it('keeps the reservation summary inside the shared layout', function () {
    $this->actingAs(User::factory()->create(['tipo' => 'administrador']));
    $cliente = Cliente::create(['nome' => 'Cliente Resumo', 'email' => 'resumo@example.test', 'telefone' => '912345678', 'morada' => 'Faro', 'nif' => '123456789']);
    $apartamento = Apartamento::create(['referencia' => 'QA002', 'tipologia' => 'T1', 'morada' => 'Faro', 'area' => 60, 'preco' => 800, 'estado' => 'Disponivel']);
    $this->post('/vendas', ['cliente' => $cliente->nome, 'apartamento' => $apartamento->referencia, 'data_entrada' => '2026-10-01', 'data_saida' => '2026-10-08', 'valor_total' => 800])->assertOk()
        ->assertSee('class="public-header"', false)->assertSee('class="public-footer"', false)->assertSee('Reserva Confirmada');
});
