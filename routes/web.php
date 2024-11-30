<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseTestController;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\PacientesController;

Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
Route::get('/pacientes/create', [PacientesController::class, 'create'])->name('pacientes.create');
Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
Route::post('/pacientes/importar', [PacienteController::class, 'importar'])->name('pacientes.importar');
Route::get('/pacientes/exportar/{formato}', [PacienteController::class, 'exportar'])->name('pacientes.exportar');



// Rutas
Route::get('/test-db', [DatabaseTestController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/prueba-componentes', function () {
    return view('prueba_componentes');
});


// Ruta de HOME
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Ruta de giftcard
Route::get('/giftcards', [GiftcardController::class, 'index'])->name('giftcards.index');

// Ruta de pago QR
Route::get('/pagoqr', [PagoQRController::class, 'index'])->name('pagoqr.index');

// Ruta de valoraciones
Route::get('/valoraciones', [ValoracionesController::class, 'index'])->name('valoraciones.index');

// Ruta de servicios
Route::get('/servicios', [ValoracionesController::class, 'index'])->name('servicios.index');
