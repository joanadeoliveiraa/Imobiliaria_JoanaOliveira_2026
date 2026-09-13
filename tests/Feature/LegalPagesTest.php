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
        ->assertSee(auth()->guard('web')->getRecallerName());
    $this->get(route('legal.privacy'))->assertSee('[A PREENCHER:');
    $this->get(route('legal.terms'))->assertSee('[A PREENCHER:');
});
