<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\DassEvaluacion;
use App\Models\EstiloDeVida;
use App\Models\DatosFisicos;
use App\Models\Facultad;
use App\Models\RegistroIngreso;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_alumnos'      => Alumno::count(),
            'alumnos_hombres'    => Alumno::where('sexo', 'Masculino')->count(),
            'alumnos_mujeres'    => Alumno::where('sexo', 'Femenino')->count(),
            'evaluaciones_dass'  => DassEvaluacion::count(),
            'estilos_vida'       => EstiloDeVida::count(),
            'datos_fisicos'      => DatosFisicos::count(),
            'sesiones_activas'   => RegistroIngreso::whereNull('fecha_salida')->count(),
        ];

        $facultades = Facultad::withCount('alumnos')->get();

        $ultimosIngresos = RegistroIngreso::latest('fecha_ingreso')->take(10)->get();

        return view('admin.dashboard', compact('stats', 'facultades', 'ultimosIngresos'));
    }
}
