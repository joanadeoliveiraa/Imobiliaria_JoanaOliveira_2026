<?php

use App\Mail\RespostaPedidoContacto;
use App\Models\PedidoContacto;
use App\Models\User;
use App\Models\Venda;
use App\Support\ClientAccount;
use App\Support\ContactSubjects;

beforeEach(function () {
    $this->data = ['nome' => 'Joana Oliveira', 'email' => 'joana@example.test',
        'assunto' => ContactSubjects::OPTIONS[0], 'mensagem' => 'Preciso de informações adicionais.', 'privacidade_lida' => '1'];
});

it('renders every subject and stores each allowed selection', function (string $subject) {
    $this->get(route('contactos'))->assertOk()->assertSee('Selecione o assunto')->assertSee($subject);
    $this->post(route('contactos.enviar'), array_replace($this->data, ['assunto' => $subject, 'outro_assunto' => 'Pedido específico']))
        ->assertSessionHasNoErrors();
    expect(PedidoContacto::sole()->assunto)->toBe($subject === ContactSubjects::OTHER ? $subject.': Pedido específico' : $subject);
})->with(ContactSubjects::OPTIONS);

it('rejects missing arbitrary and incomplete other subjects', function () {
    foreach (['', 'Assunto inventado', ContactSubjects::OTHER] as $subject) {
        $this->post(route('contactos.enviar'), array_replace($this->data, ['assunto' => $subject]))
            ->assertSessionHasErrors($subject === ContactSubjects::OTHER ? 'outro_assunto' : 'assunto');
    }
    expect(PedidoContacto::count())->toBe(0);
});

it('prefills account details and associates only reservations belonging to that client', function () {
    $user = User::factory()->create(['tipo' => 'cliente', 'name' => 'Joana Oliveira']);
    $client = ClientAccount::for($user);
    $reservation = Venda::create(['cliente_id' => $client->id, 'cliente' => $client->nome,
        'apartamento' => 'ALG001', 'data_entrada' => now()->addDays(7)->toDateString(),
        'data_saida' => now()->addDays(10)->toDateString(), 'valor_total' => 300]);
    $this->actingAs($user)->get(route('contactos', ['reserva' => $reservation->id]))->assertOk()
        ->assertSee('value="Joana Oliveira"', false)->assertSee($user->email)
        ->assertSee(ContactSubjects::RESERVATION)->assertSee('RES-'.str_pad($reservation->id, 6, '0', STR_PAD_LEFT));
    $this->post(route('contactos.enviar'), $this->data + ['venda_id' => $reservation->id])->assertSessionHasNoErrors();
    expect(PedidoContacto::sole()->venda_id)->toBe($reservation->id);
    $this->actingAs(User::factory()->create(['tipo' => 'cliente']));
    $this->get(route('contactos', ['reserva' => $reservation->id]))->assertNotFound();
    $this->post(route('contactos.enviar'), $this->data + ['venda_id' => $reservation->id])->assertSessionHasErrors('venda_id');
    auth()->logout();
    $this->get(route('contactos', ['reserva' => $reservation->id]))->assertForbidden();
    $this->post(route('contactos.enviar'), $this->data + ['venda_id' => $reservation->id])->assertSessionHasErrors('venda_id');
    expect(PedidoContacto::count())->toBe(1);
});

it('includes the selected subject and reservation reference in the existing reply email', function () {
    $pedido = new PedidoContacto($this->data + ['venda_id' => 42]);
    $mail = new RespostaPedidoContacto($pedido, 'Resposta ao pedido', 'Vamos ajudar.');
    $mail->assertSeeInHtml(ContactSubjects::OPTIONS[0]);
    $mail->assertSeeInHtml('RES-000042');
});
