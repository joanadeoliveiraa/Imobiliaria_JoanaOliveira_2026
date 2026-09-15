<?php

it('serves complete legal pages publicly with working footer destinations', function (string $route, string $title) {
    $response = $this->get(route($route));
    $response->assertOk()->assertSee($title)
        ->assertSee('Projeto desenvolvido em homenagem às raízes da família Oliveira.')
        ->assertDontSee('href="#"', false);

    foreach (['legal.privacy', 'legal.cookies', 'legal.terms'] as $destination) {
        $response->assertSee('href="'.route($destination).'"', false);
        $this->get(route($destination))->assertOk();
    }
})->with([
    ['legal.privacy', 'Política de Privacidade'],
    ['legal.cookies', 'Política de Cookies'],
    ['legal.terms', 'Termos e Condições'],
]);

it('documents configured cookies and keeps incomplete legal details explicit', function () {
    config(['session.cookie' => 'olive_test_session', 'session.lifetime' => 37]);
    $this->get(route('legal.cookies'))->assertOk()
        ->assertSee('olive_test_session')->assertSee('37 minutos')
        ->assertSee('XSRF-TOKEN')->assertSee('180 dias')
        ->assertSee('400 dias')
        ->assertDontSee(auth()->guard('web')->getRecallerName())
        ->assertSee('olive-cookie-choice-v1')
        ->assertSee('Rever escolha de cookies')
        ->assertSee('href="'.route('legal.privacy').'"', false)
        ->assertSee('href="mailto:info@oliveproperties.pt"', false)
        ->assertSee('href="tel:+351289000000"', false)
        ->assertDontSee('[A PREENCHER]');
    $this->get(route('legal.privacy'))->assertOk()
        ->assertDontSee('[A PREENCHER]')
        ->assertDontSee('Informação em preparação')
        ->assertSee('15 de setembro de 2026')
        ->assertSee('href="'.route('legal.cookies').'"', false)
        ->assertSee('href="https://www.cnpd.pt/"', false)
        ->assertSee('href="mailto:info@oliveproperties.pt"', false)
        ->assertSee('href="tel:+351289000000"', false);
    $this->get(route('legal.terms'))->assertOk()
        ->assertDontSee('[A PREENCHER]')
        ->assertSee('pagamento exclusivamente simulado')
        ->assertSee('Ainda não existe uma Área de Cliente')
        ->assertSee('href="'.route('legal.privacy').'"', false)
        ->assertSee('href="'.route('legal.cookies').'"', false)
        ->assertSee('href="mailto:info@oliveproperties.pt"', false)
        ->assertSee('href="tel:+351289000000"', false);
});
