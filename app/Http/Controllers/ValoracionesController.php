<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValoracionesController extends Controller
{
    public function index()
    {
        return view('valoraciones.index');
    }
}
