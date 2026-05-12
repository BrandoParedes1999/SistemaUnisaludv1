<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\EstiloDeVida;
use App\Models\Nutricion;
use App\Models\Ejercicio;
use App\Models\Salud;
use App\Models\SoporteInterpersonal;
use App\Models\ManejoEstres;
use App\Models\Autoactualizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstiloVidaController extends Controller
{
    // PEPS-I subscale questions
    private const NUTRICION_Q    = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35];
    private const EJERCICIO_Q    = [4, 8, 11, 13, 15, 22, 30, 38];
    private const SALUD_Q        = [2, 7, 12, 17, 20, 23, 28, 32, 42, 46];
    private const SOPORTE_Q      = [10, 14, 18, 24, 25, 33, 36, 40, 47];
    private const MANEJO_Q       = [6, 9, 16, 21, 26, 29, 35, 39, 41, 45];
    private const AUTOACT_Q      = [3, 5, 19, 27, 31, 34, 37, 43, 44, 48];

    private const PUNTAJE_SALUDABLE = 121; // Score threshold for "saludable"

    public function show()
    {
        $alumno = Auth::guard('alumno')->user();
        $ultimoEstilo = $alumno->ultimoEstiloDeVida;
        return view('alumno.estilo-vida.formulario', compact('alumno', 'ultimoEstilo'));
    }

    public function store(Request $request)
    {
        $reglas = [];
        for ($i = 1; $i <= 48; $i++) {
            $reglas["p{$i}"] = 'required|integer|min:1|max:4';
        }

        $datos = $request->validate($reglas);
        $alumno = Auth::guard('alumno')->user();

        DB::transaction(function () use ($datos, $alumno) {
            $totalNutri  = $this->sumarPreguntas($datos, self::NUTRICION_Q);
            $totalEjerc  = $this->sumarPreguntas($datos, self::EJERCICIO_Q);
            $totalSalud  = $this->sumarPreguntas($datos, self::SALUD_Q);
            $totalSoport = $this->sumarPreguntas($datos, self::SOPORTE_Q);
            $totalManejo = $this->sumarPreguntas($datos, self::MANEJO_Q);
            $totalAutoac = $this->sumarPreguntas($datos, self::AUTOACT_Q);
            $totalGeneral = $totalNutri + $totalEjerc + $totalSalud + $totalSoport + $totalManejo + $totalAutoac;

            $estilo = EstiloDeVida::create([
                'matricula_alum'  => $alumno->matricula_alum,
                'total'           => $totalGeneral,
                'fecha'           => now()->toDateString(),
                'estado_saludable' => $totalGeneral >= self::PUNTAJE_SALUDABLE,
            ]);

            Nutricion::create(array_merge(
                ['id_cuestionario' => $estilo->id, 'total_nutricion' => $totalNutri, 'saludable' => $totalNutri >= 35],
                $this->extractarPreguntas($datos, self::NUTRICION_Q)
            ));

            Ejercicio::create(array_merge(
                ['id_cuestionario' => $estilo->id, 'total_ejercicio' => $totalEjerc, 'saludable_ejercicio' => $totalEjerc >= 16],
                $this->extractarPreguntas($datos, self::EJERCICIO_Q)
            ));

            Salud::create(array_merge(
                ['id_cuestionario' => $estilo->id, 'total_salud' => $totalSalud, 'saludable_salud' => $totalSalud >= 20],
                $this->extractarPreguntas($datos, self::SALUD_Q)
            ));

            SoporteInterpersonal::create(array_merge(
                ['id_cuestionario' => $estilo->id, 'total_soporte' => $totalSoport, 'saludable_soporte' => $totalSoport >= 18],
                $this->extractarPreguntas($datos, self::SOPORTE_Q)
            ));

            ManejoEstres::create(array_merge(
                ['id_cuestionario' => $estilo->id, 'total_manejoestres' => $totalManejo, 'saludable_manejo' => $totalManejo >= 20],
                $this->extractarPreguntas($datos, self::MANEJO_Q)
            ));

            Autoactualizacion::create(array_merge(
                ['id_cuestionario' => $estilo->id, 'total_autoactualizacion' => $totalAutoac, 'saludable_autoactualizacion' => $totalAutoac >= 20],
                $this->extractarPreguntas($datos, self::AUTOACT_Q)
            ));
        });

        return redirect()->route('alumno.estilo-vida.resultados')
            ->with('success', 'Evaluación de estilo de vida registrada correctamente.');
    }

    public function resultados()
    {
        $alumno = Auth::guard('alumno')->user();
        $evaluaciones = $alumno->estilosDeVida()
            ->with(['nutricion', 'ejercicio', 'salud', 'soporteInterpersonal', 'manejoEstres', 'autoactualizacion'])
            ->paginate(10);

        return view('alumno.estilo-vida.resultados', compact('alumno', 'evaluaciones'));
    }

    private function sumarPreguntas(array $datos, array $preguntas): int
    {
        return array_sum(array_map(fn($p) => (int) ($datos["p{$p}"] ?? 0), $preguntas));
    }

    private function extractarPreguntas(array $datos, array $preguntas): array
    {
        $resultado = [];
        foreach ($preguntas as $p) {
            $resultado["p{$p}"] = $datos["p{$p}"] ?? 0;
        }
        return $resultado;
    }
}
