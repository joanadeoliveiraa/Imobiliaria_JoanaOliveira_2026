<?php

use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendaController;
use App\Models\Apartamento;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $alg011 = Apartamento::where('referencia', 'ALG011')->first();

    $alg012 = Apartamento::where('referencia', 'ALG012')->first();

    $alg013 = Apartamento::where('referencia', 'ALG013')->first();

    return view('welcome', compact(
        'alg011',
        'alg012',
        'alg013'
    ));

})->name('home');

Route::resource('apartamentos', ApartamentoController::class)
    ->only(['index', 'show']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('apartamentos', ApartamentoController::class)
        ->except(['index', 'show']);
    Route::resource('vendas', VendaController::class);

    Route::get('/clientes/{cliente}/reservas', [VendaController::class, 'historicoCliente'])
        ->name('clientes.reservas');

    Route::get('/dashboard', [ApartamentoController::class, 'dashboard'])
        ->name('dashboard');
});

// Rota Sobre nós
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
