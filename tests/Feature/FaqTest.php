<?php

use App\Models\User;
use App\Support\ContactSubjects;

it('serves all questions as server rendered content and links both pages', function () {
    $page = $this->get(route('faqs'))->assertOk();
    expect(config('faqs'))->toHaveCount(8);
    expect(collect(config('faqs'))->sum(fn ($category) => count($category['items'])))->toBe(34);
    foreach (config('faqs') as $category) {
        expect(ContactSubjects::OPTIONS)->toContain($category['subject']);
        foreach ($category['items'] as [$question, $answer]) {
            $page->assertSee($question)->assertSee($answer);
        }
    }
    $page->assertSee('href="'.route('contactos').'"', false)->assertSee('Ainda tem dúvidas?');
    $this->get(route('contactos'))->assertOk()->assertSee('href="'.route('faqs').'"', false)
        ->assertSeeInOrder(['Já consultou as nossas perguntas frequentes?', 'Envie-nos uma mensagem']);
});

it('permits both authenticated roles to read FAQs', function (string $role) {
    $this->actingAs(User::factory()->create(['tipo' => $role]))->get(route('faqs'))->assertOk();
})->with(['cliente', 'administrador']);

it('preselects only allowed FAQ subjects', function () {
    foreach (config('faqs') as $category) {
        $this->get(route('contactos', ['assunto' => $category['subject']]))->assertOk()
            ->assertViewHas('assunto', $category['subject']);
    }
    foreach (['<script>alert(1)</script>', ['unexpected'], 'Não permitido'] as $invalid) {
        $this->get(route('contactos', ['assunto' => $invalid]))->assertOk()->assertViewHas('assunto', '');
    }
});
