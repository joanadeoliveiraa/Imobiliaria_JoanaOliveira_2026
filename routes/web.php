<?php

use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendaController;
use App\Models\Apartamento;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $referenciasDestaque = ['ALG011', 'ALG012', 'ALG013'];
    $propriedadesDestaque = Apartamento::whereIn('referencia', $referenciasDestaque)
        ->get()
        ->sortBy(fn (Apartamento $apartamento) => array_search($apartamento->referencia, $referenciasDestaque, true))
        ->values();

    if ($propriedadesDestaque->count() < 3) {
        $complementares = Apartamento::where('estado', Apartamento::ESTADO_DISPONIVEL)
            ->whereNotIn('id', $propriedadesDestaque->pluck('id'))
            ->latest()
            ->limit(3 - $propriedadesDestaque->count())
            ->get();

        $propriedadesDestaque = $propriedadesDestaque->concat($complementares);
    }

    return view('welcome', compact('propriedadesDestaque'));
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
