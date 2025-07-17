<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformacionController extends Controller
{
    public function quienesSomos()
    {
        return view('informacion.quienes_somos');
    }

    public function consejos()
    {
        return view('informacion.consejos');
    }
}