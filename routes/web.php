<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\VendaController;


Route::get('/', function () { 
    return view('welcome');
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




