<?php

use App\Mail\RespostaPedidoContacto;
use App\Models\PedidoContacto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () { $this->originalMailer = config('mail.default'); });
afterEach(function () { config()->set('mail.default', $this->originalMailer); });

function contactData(array $changes = []): array
{
    return array_replace([
        'nome' => 'Joana Oliveira', 'email' => 'joana@example.test', 'telefone' => '912345678',
        'assunto' => 'Disponibilidade no Algarve', 'mensagem' => 'Gostaria de saber se existe disponibilidade para a próxima semana.',
    ], $changes);
}

it('stores a valid public contact request and redirects to a clear, empty form', function () {
    $this->get(route('contactos'))->assertOk()->assertDontSee('O envio pelo formulário ainda não está disponível');
    $this->from(route('contactos'))->post(route('contactos.enviar'), contactData())
        ->assertRedirect(route('contactos'))->assertSessionHas('success', 'Pedido enviado com sucesso. A nossa equipa entrará em contacto consigo brevemente.');
    expect(PedidoContacto::count())->toBe(1)
        ->and(PedidoContacto::first()->estado)->toBe('new')
        ->and(PedidoContacto::first()->eventos()->first()->descricao)->toBe('Pedido recebido');
    $this->get(route('contactos'))->assertOk()->assertSee('Pedido enviado com sucesso.')->assertDontSee('value="Joana Oliveira"', false);
    expect(PedidoContacto::count())->toBe(1);
});

it('validates untrusted public input and limits repeated submissions', function () {
    $this->from(route('contactos'))->post(route('contactos.enviar'), contactData([
        'nome' => 'A', 'email' => 'invalido', 'telefone' => '<script>', 'assunto' => 'X', 'mensagem' => 'curta',
    ]))->assertRedirect(route('contactos'))->assertSessionHasErrors(['nome', 'email', 'telefone', 'assunto', 'mensagem']);
    expect(PedidoContacto::count())->toBe(0);
    foreach (range(1, 5) as $number) {
        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.45'])->post(route('contactos.enviar'), contactData(['email' => "joana{$number}@example.test"]))->assertRedirect();
    }
    $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.45'])->post(route('contactos.enviar'), contactData())->assertStatus(429);
    expect(PedidoContacto::count())->toBe(5);
});

it('protects the backoffice, highlights unread requests and keeps filters and archive history', function () {
    $pedido = PedidoContacto::create(contactData());
    $pedido->eventos()->create(['tipo' => 'received', 'descricao' => 'Pedido recebido']);
    PedidoContacto::create(contactData(['nome' => 'Maria Costa', 'email' => 'maria@example.test', 'assunto' => 'Outro pedido', 'estado' => 'archived']));
    $this->get(route('admin.contactos.index'))->assertRedirect(route('login'));
    $this->actingAs(User::factory()->create(['tipo' => 'cliente']))->get(route('admin.contactos.index'))->assertForbidden();
    $admin = User::factory()->create(['tipo' => 'administrador']);
    $this->actingAs($admin)->get(route('admin.contactos.index', ['pesquisa' => 'Joana', 'estado' => 'new']))
        ->assertOk()->assertSee('Joana Oliveira')->assertDontSee('Maria Costa')->assertSee('Não lido');
    $this->get(route('dashboard'))->assertOk()->assertViewHas('novosContactos', 1)->assertSee('Pedidos de contacto');
    $this->get(route('admin.contactos.show', $pedido))->assertOk()->assertSee('Pedido recebido');
    expect($pedido->fresh()->lido_em)->not->toBeNull()->and($pedido->fresh()->estado)->toBe('new');
    $this->patch(route('admin.contactos.update', $pedido), ['estado' => 'in_progress', 'notas_internas' => 'Confirmar datas com a equipa.'])
        ->assertRedirect(route('admin.contactos.show', $pedido));
    $this->get(route('admin.contactos.show', $pedido))->assertSee('Confirmar datas com a equipa.')->assertSee('Estado alterado para Em análise');
    $this->post(route('admin.contactos.archive', $pedido))->assertRedirect();
    expect($pedido->fresh()->estado)->toBe('archived')->and(PedidoContacto::count())->toBe(2);
    $this->get(route('admin.contactos.index', ['estado' => 'archived', 'pesquisa' => 'Joana']))->assertSee('Joana Oliveira')->assertDontSee('Maria Costa');
});

it('shows empty states and preserves search and status filters across pagination', function () {
    $this->actingAs(User::factory()->create(['tipo' => 'administrador']));
    $this->get(route('admin.contactos.index'))->assertOk()->assertSee('Ainda não existem pedidos de contacto.');
    foreach (range(1, 16) as $number) {
        PedidoContacto::create(contactData(['nome' => 'Joana Oliveira', 'email' => "joana{$number}@example.test"]));
    }
    $this->get(route('admin.contactos.index', ['pesquisa' => 'Joana', 'estado' => 'new', 'page' => 2]))
        ->assertOk()->assertViewHas('pedidos', fn ($page) => $page->currentPage() === 2 && $page->count() === 1 && $page->total() === 16);
    $this->get(route('admin.contactos.index', ['pesquisa' => 'Inexistente']))->assertSee('Não foram encontrados pedidos com estes critérios.');
});

it('escapes visitor and reply text so no submitted HTML executes in the backoffice', function () {
    $pedido = PedidoContacto::create(contactData(['mensagem' => '<script>alert("x")</script> contacto pedido']));
    $this->actingAs(User::factory()->create(['tipo' => 'administrador']))->get(route('admin.contactos.show', $pedido))
        ->assertOk()->assertDontSee('<script>alert("x")</script>', false)->assertSee('&lt;script&gt;', false);
});

it('never records a reply when email is not configured or its transport fails', function () {
    $pedido = PedidoContacto::create(contactData());
    $this->actingAs(User::factory()->create(['tipo' => 'administrador']));
    config()->set('mail.default', 'log');
    $this->from(route('admin.contactos.reply', $pedido))->post(route('admin.contactos.send', $pedido), ['assunto' => 'Re: Disponibilidade', 'mensagem' => 'Obrigado pelo contacto. Vamos confirmar as datas.'])
        ->assertSessionHasErrors('email');
    expect($pedido->respostas()->count())->toBe(0)->and($pedido->fresh()->estado)->toBe('new');
    $this->patch(route('admin.contactos.update', $pedido), ['estado' => 'replied'])->assertSessionHasErrors('estado');
    config()->set('mail.default', 'smtp');
    Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('Falha SMTP'));
    $this->from(route('admin.contactos.reply', $pedido))->post(route('admin.contactos.send', $pedido), ['assunto' => 'Re: Disponibilidade', 'mensagem' => 'Obrigado pelo contacto. Vamos confirmar as datas.'])
        ->assertSessionHasErrors('email');
    expect($pedido->respostas()->count())->toBe(0)->and($pedido->fresh()->respondido_em)->toBeNull();
});

it('sends through the configured mailer, records the answer and permits completion', function () {
    $pedido = PedidoContacto::create(contactData());
    $this->actingAs(User::factory()->create(['tipo' => 'administrador']));
    config()->set('mail.default', 'smtp');
    Mail::fake();
    $data = ['assunto' => 'Re: Disponibilidade no Algarve', 'mensagem' => 'Obrigado pelo contacto. Temos disponibilidade nas datas solicitadas.'];
    $this->post(route('admin.contactos.send', $pedido), $data)->assertRedirect(route('admin.contactos.show', $pedido))->assertSessionHas('success');
    Mail::assertSent(RespostaPedidoContacto::class, fn ($mail) => $mail->hasTo('joana@example.test') && $mail->assunto === $data['assunto']);
    expect($pedido->fresh()->estado)->toBe('replied')->and($pedido->fresh()->respondido_em)->not->toBeNull()
        ->and($pedido->respostas()->count())->toBe(1)->and($pedido->respostas()->first()->mensagem)->toBe($data['mensagem']);
    $this->get(route('admin.contactos.show', $pedido))->assertSee('Resposta enviada por email')->assertSee($data['mensagem']);
    $this->patch(route('admin.contactos.update', $pedido), ['estado' => 'completed'])->assertRedirect();
    expect($pedido->fresh()->estado)->toBe('completed')->and($pedido->respostas()->count())->toBe(1);
});
