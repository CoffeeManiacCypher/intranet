<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $empleos = collect(range(1, 20))->map(function ($i) {
            return [
                'ID' => $i,
                'Puesto' => 'Puesto ' . $i,
                'Empresa' => 'Empresa ' . $i,
                'UbicaciÃ³n' => 'Ciudad ' . $i,
                'Salario' => '$' . (5000 + $i * 100),
                'Vacantes' => rand(1, 10),
                'Requisitos' => 'Requisito ' . $i,
            ];
        });

        return view('table', ['empleos' => $empleos]);
    }
}