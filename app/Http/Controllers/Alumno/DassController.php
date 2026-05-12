<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\DassEvaluacion;
use App\Models\DassDepresion;
use App\Models\DassAnsiedad;
use App\Models\DassEstres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DassController extends Controller
{
    // DASS-21 questions mapped to subscales
    private const DEPRESION_PREGUNTAS = [3, 5, 10, 13, 16, 17, 21];
    private const ANSIEDAD_PREGUNTAS  = [2, 4, 7, 9, 15, 19, 20];
    private const ESTRES_PREGUNTAS    = [1, 6, 8, 11, 12, 14, 18];

    public function show()
    {
        $alumno = Auth::guard('alumno')->user();
        $ultimaEvaluacion = $alumno->ultimaEvaluacionDass;

        return view('alumno.dass.formulario', compact('alumno', 'ultimaEvaluacion'));
    }

    public function store(Request $request)
    {
        $reglas = [];
        for ($i = 1; $i <= 21; $i++) {
            $reglas["p{$i}"] = 'required|integer|min:0|max:3';
        }

        $datos = $request->validate($reglas);
        $alumno = Auth::guard('alumno')->user();

        DB::transaction(function () use ($datos, $alumno) {
            // Calculate subscale totals (multiplied by 2 as per DASS-21 scoring)
            $totalDep = array_sum(array_map(fn($p) => $datos["p{$p}"], self::DEPRESION_PREGUNTAS)) * 2;
            $totalAns = array_sum(array_map(fn($p) => $datos["p{$p}"], self::ANSIEDAD_PREGUNTAS)) * 2;
            $totalEst = array_sum(array_map(fn($p) => $datos["p{$p}"], self::ESTRES_PREGUNTAS)) * 2;
            $totalGen = $totalDep + $totalAns + $totalEst;

            $evaluacion = DassEvaluacion::create([
                'matricula_alum'  => $alumno->matricula_alum,
                'total_depresion' => $totalDep,
                'total_ansiedad'  => $totalAns,
                'total_estres'    => $totalEst,
                'total_general'   => $totalGen,
            ]);

            DassDepresion::create([
                'id_cuestionario' => $evaluacion->id,
                'p3'  => $datos['p3'],  'p5'  => $datos['p5'],
                'p10' => $datos['p10'], 'p13' => $datos['p13'],
                'p16' => $datos['p16'], 'p17' => $datos['p17'],
                'p21' => $datos['p21'],
                'total_depresion' => $totalDep,
                'severidad' => DassEvaluacion::severidadDepresion($totalDep),
            ]);

            DassAnsiedad::create([
                'id_cuestionario' => $evaluacion->id,
                'p2'  => $datos['p2'],  'p4'  => $datos['p4'],
                'p7'  => $datos['p7'],  'p9'  => $datos['p9'],
                'p15' => $datos['p15'], 'p19' => $datos['p19'],
                'p20' => $datos['p20'],
                'total_ansiedad' => $totalAns,
                'severidad' => DassEvaluacion::severidadAnsiedad($totalAns),
            ]);

            DassEstres::create([
                'id_cuestionario' => $evaluacion->id,
                'p1'  => $datos['p1'],  'p6'  => $datos['p6'],
                'p8'  => $datos['p8'],  'p11' => $datos['p11'],
                'p12' => $datos['p12'], 'p14' => $datos['p14'],
                'p18' => $datos['p18'],
                'total_estres' => $totalEst,
                'severidad' => DassEvaluacion::severidadEstres($totalEst),
            ]);
        });

        return redirect()->route('alumno.dass.resultados')
            ->with('success', 'Evaluación DASS-21 registrada correctamente.');
    }

    public function resultados()
    {
        $alumno = Auth::guard('alumno')->user();
        $evaluaciones = $alumno->evaluacionesDass()
            ->with(['depresion', 'ansiedad', 'estres'])
            ->paginate(10);

        return view('alumno.dass.resultados', compact('alumno', 'evaluaciones'));
    }
}
