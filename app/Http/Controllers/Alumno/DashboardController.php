<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $alumno = Auth::guard('alumno')->user()->load([
            'ultimosDatosFisicos',
            'ultimaEvaluacionDass',
            'ultimoEstiloDeVida',
            'carrera',
            'facultad',
        ]);

        return view('alumno.dashboard', compact('alumno'));
    }
}
