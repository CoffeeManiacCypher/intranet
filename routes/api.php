<?php
use App\Models\Servicio;

Route::get('/servicios', function () {
    return Servicio::select('id', 'nombre', 'precio')->get();
});
