<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('welcome');
});


// ROTAS DOS CLIENTES
// CRUD completo de clientes:
// index, create, store, show, edit, update e destroy
Route::resource('clientes', ClienteController::class);
