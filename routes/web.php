<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseTestController;
use App\Http\Controllers\TableController;

// Controlador de Inicio
use App\Http\Controllers\HomeController;

// Controlador de Pacientes
use App\Http\Controllers\PacientesController;

// Controlador de Reservas
use App\Http\Controllers\ReservaController;

// Controlador de Servicios
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CategoriaServicioController;

// Controlador de Valoraciones
use App\Http\Controllers\ValoracionesController;

// Controlador de Giftcard
use App\Http\Controllers\GiftcardController;

// Controlador de Giftcard
use App\Http\Controllers\FichaMedicaController;
// --------------------------------------------------------------------------------------------------------------------

// Ruta de HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// --------------------------------------------------------------------------------------------------------------------

// Rutas de Reservas
Route::prefix('reservas')->group(function () {
    Route::get('/', [ReservaController::class, 'index'])->name('reservas.index'); // Listar reservas
    Route::get('/crear', [ReservaController::class, 'create'])->name('reservas.create'); // Formulario para crear una reserva
    Route::post('/', [ReservaController::class, 'store'])->name('reservas.store'); // Guardar una reserva
    Route::get('/{reserva}/editar', [ReservaController::class, 'edit'])->name('reservas.edit'); // Formulario para editar una reserva
    Route::put('/{reserva}', [ReservaController::class, 'update'])->name('reservas.update'); // Actualizar una reserva
    Route::delete('/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy'); // Eliminar una reserva (soft delete)
    Route::post('/{reserva}/restaurar', [ReservaController::class, 'restore'])->name('reservas.restore'); // Restaurar una reserva
    Route::get('/createqr', [ReservaController::class, 'createqr'])->name('reservas.createqr');
});
Route::get('/reservas/paciente/{id}', [ReservaController::class, 'reservasPorPaciente'])->name('reservas.paciente');

// --------------------------------------------------------------------------------------------------------------------

// Rutas de Pacientes
Route::prefix('pacientes')->name('pacientes.')->group(function () {
    Route::get('/', [PacientesController::class, 'index'])->name('index');
    Route::get('/create', [PacientesController::class, 'create'])->name('create');
    Route::post('/', [PacientesController::class, 'store'])->name('store');
    Route::post('/validar', [PacientesController::class, 'validarDatos'])->name('validar');
    Route::get('/{id}', [PacientesController::class, 'show'])->name('show');
    Route::put('/{id}', [PacientesController::class, 'update'])->name('update');
    Route::delete('/{id}', [PacientesController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/restore', [PacientesController::class, 'restore'])->name('restore');
    Route::post('/actualizar-estado', [PacientesController::class, 'actualizarEstadoPacientes'])->name('actualizarEstado');
});
Route::get('/pacientes/{id}/resumen', [PacientesController::class, 'apiResumenPaciente'])->name('pacientes.resumen');

// --------------------------------------------------------------------------------------------------------------------

// Servicios
Route::prefix('servicios')->name('servicios.')->group(function () {
    Route::get('/', [ServicioController::class, 'index'])->name('index'); // Listar servicios
    Route::post('/', [ServicioController::class, 'store'])->name('store'); // Crear un nuevo servicio
    Route::delete('/{servicio}', [ServicioController::class, 'destroy'])->name('destroy'); // Eliminar servicio
    Route::post('/{id}/restore', [ServicioController::class, 'restore'])->name('restore'); // Restaurar servicio
    Route::get('/create', [ServicioController::class, 'create'])->name('create'); // Mostrar formulario de creación
    Route::get('/{id}/edit', [ServicioController::class, 'edit'])->name('edit'); // Editar servicio (¡Falta agregar esta!)
    Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');
    Route::get('/servicios/create', [ServicioController::class, 'create'])->name('servicios.create');
    Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit'])->name('servicios.edit');

});

// --------------------------------------------------------------------------------------------------------------------

// Categorías de Servicios
Route::prefix('categoria-servicios')->name('categoria_servicios')->group(function () {
    Route::get('/', [CategoriaServicioController::class, 'index'])->name('index');
    Route::post('/', [CategoriaServicioController::class, 'store'])->name('store');
    Route::delete('/{id}', [CategoriaServicioController::class, 'destroy'])->name('destroy');
});
// --------------------------------------------------------------------------------------------------------------------


Route::prefix('api/servicios')->name('api.servicios.')->group(function () {
    Route::get('/', [ServicioController::class, 'apiGetServicios'])->name('list');
    Route::get('/{id}', [ServicioController::class, 'apiGetServicio'])->name('detail');
    Route::post('/orden', [ServicioController::class, 'apiCrearOrden'])->name('create_order'); // Opcional si deseas manejar órdenes desde el backend
});

// Giftcard
Route::prefix('giftcard')->group(function () {
    
    Route::get('/', [GiftcardController::class, 'index'])->name('giftcard.index');
    Route::get('/create', [GiftcardController::class, 'create'])->name('giftcard.create');
    Route::post('/', [GiftcardController::class, 'store'])->name('giftcard.store');
    Route::get('/{giftcard}/edit', [GiftcardController::class, 'edit'])->name('giftcard.edit');
    Route::put('/{giftcard}', [GiftcardController::class, 'update'])->name('giftcard.update');
    Route::delete('/{giftcard}', [GiftcardController::class, 'destroy'])->name('giftcard.destroy');
    Route::post('/{id}/restore', [GiftcardController::class, 'restore'])->name('giftcard.restore');
    Route::get('/trashed', [GiftcardController::class, 'trashed'])->name('giftcard.trashed');
    Route::post('/cobrar/{id}', [GiftcardController::class, 'cobrar'])->name('giftcard.cobrar');
});

// Rutas del Giftcard API
Route::prefix('giftcard/api')->group(function () {
    Route::get('/pacientes', [GiftcardController::class, 'apiPacientes'])->name('giftcard.api.pacientes');
    Route::get('/promociones', [GiftcardController::class, 'apiPromociones'])->name('giftcard.api.promociones');
    Route::get('/personal', [GiftcardController::class, 'apiPersonal'])->name('giftcard.api.personal');
});

// Ruta para obtener las Giftcards de un paciente
Route::get('/giftcards/paciente/{id}', [GiftcardController::class, 'giftcardsPorPaciente'])->name('giftcards.paciente');

// -------------------------------------------------------------------------------------------------------
// Ruta para obtener las FICHAS MEDICAS de un paciente
Route::prefix('fichas')->name('fichas.')->group(function () {
    Route::get('/create', [FichaMedicaController::class, 'create'])->name('create'); // Formulario
    Route::get('/', [FichaMedicaController::class, 'index'])->name('index'); // Listar fichas médicas
    Route::post('/store', [FichaMedicaController::class, 'store'])->name('store'); // Subir ficha médica
    Route::get('/descargar/{id}', [FichaMedicaController::class, 'descargar'])->name('descargar'); // Descargar ficha médica
    Route::delete('/{id}', [FichaMedicaController::class, 'destroy'])->name('destroy'); // Eliminar ficha médica
    Route::get('/api', [FichaMedicaController::class, 'apiFichasMedicas'])->name('api');
});

Route::prefix('fichas/api')->name('fichas.api.')->group(function () {
    Route::get('/pacientes', [FichaMedicaController::class, 'apiPacientes'])->name('pacientes');
    Route::get('/servicios', [FichaMedicaController::class, 'apiServicios'])->name('servicios');
    Route::get('/trabajadores', [FichaMedicaController::class, 'apiTrabajadores'])->name('trabajadores');
});

// --------------------------------------------------------------------------------------------------------------------

// Valoraciones
Route::get('/valoraciones', [ValoracionesController::class, 'index'])->name('valoraciones.index');




// Rutas de prueba
Route::get('/table', [TableController::class, 'index'])->name('table.index');


Route::get('/test-db', [DatabaseTestController::class, 'index']);

Route::get('/laravel', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/prueba-componentes', function () {
    return view('prueba_componentes');
<<<<<<< HEAD
});
=======
});
>>>>>>> f54984645166dd5ed8a43c1a794037308fcf7b95
