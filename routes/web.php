<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\VendaController;
use Illuminate\Http\Request;
use App\Models\Apartamento;


Route::get('/', function () {

    $alg011 = Apartamento::where('referencia', 'ALG011')->first();

    $alg012 = Apartamento::where('referencia', 'ALG012')->first();

    $alg013 = Apartamento::where('referencia', 'ALG013')->first();

    return view('welcome', compact(
        'alg011',
        'alg012',
        'alg013'
    ));

});


// ROTAS DOS CLIENTES
// CRUD completo de clientes:
// index, create, store, show, edit, update e destroy
Route::resource('clientes', ClienteController::class);


// ROTAS DOS APARTAMENTOS
// CRUD completo de apartamentos
Route::resource('apartamentos', ApartamentoController::class);


// ROTAS DAS VENDAS
Route::resource('vendas', VendaController::class);


//Rota Sobre nós
Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');


// ROTAS Contactos:
Route::get('/contactos', function () {
    return view('Contactos.contactos');
})->name('contactos');


Route::post('/contactos', function () {
    return back()->with(
        'success',
        'A sua mensagem foi enviada com sucesso. Entraremos em contacto brevemente.'
    );
})->name('contactos.enviar');

//Historico Cliente
Route::get(
    '/clientes/{cliente}/reservas',
    [VendaController::class, 'historicoCliente']
)->name('clientes.reservas');

// Dashboard
Route::get(
    '/dashboard',
    [ApartamentoController::class, 'dashboard']
)->name('dashboard');
