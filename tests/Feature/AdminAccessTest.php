<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects visitors away from administrative routes', function () {
    $this->get(route('clientes.index'))->assertRedirect(route('login'));
    $this->get(route('vendas.index'))->assertRedirect(route('login'));
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

it('forbids authenticated clients from administrative routes', function () {
    $user = User::factory()->create(['tipo' => 'cliente']);

    $this->actingAs($user)->get(route('clientes.index'))->assertForbidden();
    $this->actingAs($user)->get(route('vendas.index'))->assertForbidden();
    $this->actingAs($user)->get(route('dashboard'))->assertForbidden();
});

it('allows administrators to access customer management', function () {
    $admin = User::factory()->create(['tipo' => 'administrador']);

    $this->actingAs($admin)->get(route('clientes.index'))->assertOk();
});

it('keeps the property catalogue public', function () {
    $this->get(route('apartamentos.index'))->assertOk();
});
