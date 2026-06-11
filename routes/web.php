<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ApartamentoController;

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


