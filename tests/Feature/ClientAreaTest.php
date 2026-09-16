<?php

use App\Mail\ReservaConfirmada;
use App\Models\Apartamento;
use App\Models\Cliente;
use App\Models\PagamentoSimulado;
use App\Models\PedidoContacto;
use App\Models\User;
use App\Models\Venda;
use App\Support\ClientAccount;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->admin = User::factory()->create(['tipo' => 'administrador']);
    $this->user = User::factory()->create(['tipo' => 'cliente', 'name' => 'Joana Oliveira', 'email' => 'joana@example.test']);
    $this->other = User::factory()->create(['tipo' => 'cliente', 'name' => 'Maria Costa', 'email' => 'maria@example.test']);
    $this->cliente = ClientAccount::for($this->user);
    $this->outroCliente = ClientAccount::for($this->other);
    $this->property = Apartamento::create(['referencia' => 'ALG777', 'tipologia' => 'T2', 'morada' => 'Albufeira', 'area' => 70, 'preco' => 700, 'estado' => 'Disponivel']);
    $this->dates = ['apartamento_id' => $this->property->id,
        'data_entrada' => now()->addDays(7)->toDateString(),
        'data_saida' => now()->addDays(14)->toDateString()];
});

it('separates client and administrative routes and protects reservations by explicit ownership', function () {
    $otherReservation = Venda::create(['cliente_id' => $this->outroCliente->id, 'cliente' => $this->outroCliente->nome,
        'apartamento' => $this->property->referencia, 'data_entrada' => now()->addMonth()->toDateString(),
        'data_saida' => now()->addMonth()->addDays(3)->toDateString(), 'valor_total' => 300]);
    $this->get(route('client.home'))->assertRedirect(route('login'));
    $this->actingAs($this->admin)->get(route('client.home'))->assertForbidden();
    $this->actingAs($this->user)->get(route('client.home'))->assertOk()->assertSee('Olá, Joana Oliveira');
    $this->get(route('client.reservations.index'))->assertOk()->assertDontSee('Maria Costa');
    $this->get(route('client.reservations.show', $otherReservation))->assertForbidden();
    $this->get(route('client.reservations.receipt', $otherReservation))->assertForbidden();
    $this->get(route('client.reservations.confirmation', $otherReservation))->assertForbidden();
    $this->get(route('vendas.edit', $otherReservation))->assertForbidden();
    $this->get(route('clientes.index'))->assertForbidden();
    $this->get(route('dashboard.report'))->assertForbidden();
});

it('uses the authenticated client and server price through summary, simulated checkout and confirmation', function () {
    config()->set('mail.default', 'smtp');
    Mail::fake();
    $this->actingAs($this->user);
    $summary = $this->post(route('client.reservations.start'), $this->dates +
        ['cliente_id' => $this->outroCliente->id, 'valor_total' => 1])->assertRedirect()->headers->get('Location');
    expect(Venda::count())->toBe(0);
    $this->get($summary)->assertOk()->assertSee('Resumo da reserva')->assertSee('Joana Oliveira')->assertSee('700,00');
    $token = basename($summary);
    $payment = $this->post(route('client.reservations.continue', $token))->assertRedirect()->headers->get('Location');
    $this->get($payment)->assertOk()->assertSee('Pagamento simulado');
    $confirmed = $this->post($payment, ['metodo' => 'cartao', 'resultado' => 'aprovado', 'valor_total' => 1, 'cliente_id' => $this->outroCliente->id])
        ->assertRedirect()->headers->get('Location');
    $reserva = Venda::first();
    expect($reserva->cliente_id)->toBe($this->cliente->id)
        ->and($reserva->valor_total)->toBe('700.00')
        ->and(PagamentoSimulado::count())->toBe(1)
        ->and($reserva->pagamentoSimulado->email_estado)->toBe('sent')
        ->and($this->admin->notifications()->count())->toBe(1);
    Mail::assertSent(ReservaConfirmada::class, fn ($mail) => $mail->hasTo('joana@example.test'));
    $this->post($payment, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->assertRedirect($confirmed);
    expect(Venda::count())->toBe(1)->and($this->admin->notifications()->count())->toBe(1);
    $this->get($confirmed)->assertOk()->assertSee('A confirmação foi enviada');
    $this->get(route('client.reservations.show', $reserva))->assertOk()->assertSee('ALG777');
    $this->get(route('client.reservations.receipt', $reserva))->assertOk()->assertSee('Comprovativo de reserva')->assertSee('não constitui fatura');
    $this->actingAs($this->other)->get(route('client.reservations.receipt', $reserva))->assertForbidden();
});

it('keeps a confirmed reservation if the confirmation email fails', function () {
    config()->set('mail.default', 'smtp');
    Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('SMTP indisponível'));
    $this->actingAs($this->user);
    $summary = $this->post(route('client.reservations.start'), $this->dates)->headers->get('Location');
    $payment = $this->post(route('client.reservations.continue', basename($summary)))->headers->get('Location');
    $confirmed = $this->post($payment, ['metodo' => 'cartao', 'resultado' => 'aprovado'])->headers->get('Location');
    expect(Venda::count())->toBe(1)->and(PagamentoSimulado::first()->email_estado)->toBe('failed');
    $this->get($confirmed)->assertOk()->assertSee('não foi enviada');
});

it('shows only own contact requests and sent replies without internal notes', function () {
    $own = PedidoContacto::create(['user_id' => $this->user->id, 'nome' => 'Joana Oliveira', 'email' => 'joana@example.test',
        'assunto' => 'Datas', 'mensagem' => 'Gostaria de saber as datas.', 'notas_internas' => 'Nota confidencial']);
    $own->respostas()->create(['assunto' => 'Re: Datas', 'mensagem' => 'Temos disponibilidade.', 'enviado_em' => now()]);
    $other = PedidoContacto::create(['user_id' => $this->other->id, 'nome' => 'Maria Costa', 'email' => 'maria@example.test',
        'assunto' => 'Outro', 'mensagem' => 'Outra mensagem privada.']);
    $this->actingAs($this->user)->get(route('client.messages.index'))->assertOk()->assertSee('Datas')->assertDontSee('Outro');
    $this->get(route('client.messages.show', $own))->assertOk()->assertSee('Temos disponibilidade.')->assertDontSee('Nota confidencial');
    $this->get(route('client.messages.show', $other))->assertForbidden();
    $this->post(route('contactos.enviar'), ['nome' => 'Pessoa falsa', 'email' => 'falsa@example.test',
        'assunto' => 'Novo contacto', 'mensagem' => 'Precisava de uma informação.', 'privacidade_lida' => '1'])->assertRedirect();
    expect(PedidoContacto::latest('id')->first()->user_id)->toBe($this->user->id)
        ->and(PedidoContacto::latest('id')->first()->email)->toBe('joana@example.test');
});

it('rejects unavailable dates and prevents a client from changing roles through profile input', function () {
    $this->actingAs($this->user);
    Venda::create(['cliente_id' => $this->outroCliente->id, 'cliente' => $this->outroCliente->nome,
        'apartamento' => $this->property->referencia, 'data_entrada' => $this->dates['data_entrada'],
        'data_saida' => $this->dates['data_saida'], 'valor_total' => 700]);
    $this->post(route('client.reservations.start'), $this->dates)->assertSessionHasErrors('apartamento_id');
    $this->patch(route('profile.update'), ['name' => 'Joana Nova', 'email' => 'joana@example.test',
        'telefone' => '912345678', 'morada' => 'Faro', 'tipo' => 'administrador'])
        ->assertRedirect(route('profile.edit'));
    expect($this->user->fresh()->tipo)->toBe('cliente')
        ->and($this->cliente->fresh()->telefone)->toBe('912345678')
        ->and($this->cliente->fresh()->nome)->toBe('Joana Nova');
});

it('marks administrative event notifications read and keeps their destination internal', function () {
    $this->actingAs($this->user)->post(route('contactos.enviar'), [
        'nome' => 'Joana Oliveira', 'email' => 'joana@example.test', 'assunto' => 'Pedido',
        'mensagem' => 'Gostaria de saber mais informações.', 'privacidade_lida' => '1',
    ])->assertRedirect();
    $notification = $this->admin->notifications()->first();
    expect($notification)->not->toBeNull()->and($notification->read_at)->toBeNull();
    $this->actingAs($this->admin)->post(route('admin.notifications.open', $notification->id))
        ->assertRedirect(route('admin.contactos.show', PedidoContacto::first()));
    expect($notification->fresh()->read_at)->not->toBeNull();
});

it('rejects notification links that only share the application URL prefix', function () {
    $this->admin->notify(new \App\Notifications\AdministrativeEvent(
        'contact', 'Pedido', 'Teste', url('/').'.example.test/phishing'
    ));
    $notification = $this->admin->notifications()->first();

    $this->actingAs($this->admin)->post(route('admin.notifications.open', $notification->id))
        ->assertStatus(400);

    expect($notification->fresh()->read_at)->toBeNull();
});
