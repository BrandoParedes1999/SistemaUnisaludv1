<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\DatosFisicos;
use App\Models\DassEvaluacion;
use App\Models\EstiloDeVida;
use App\Models\Facultad;
use App\Models\Carrera;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index()
    {
        $facultades = Facultad::all();
        $carreras = Carrera::all();
        return view('admin.reportes.index', compact('facultades', 'carreras'));
    }

    public function observatorioDass(Request $request)
    {
        $query = DassEvaluacion::with('alumno');

        if ($request->filled('facultad')) {
            $query->whereHas('alumno', fn($q) => $q->where('id_facultad', $request->facultad));
        }
        if ($request->filled('carrera')) {
            $query->whereHas('alumno', fn($q) => $q->where('id_carrera', $request->carrera));
        }

        $evaluaciones = $query->get();

        $stats = [
            'depresion' => [
                'Normal'                  => $evaluaciones->filter(fn($e) => $e->total_depresion <= 9)->count(),
                'Leve'                    => $evaluaciones->filter(fn($e) => $e->total_depresion >= 10 && $e->total_depresion <= 13)->count(),
                'Moderada'                => $evaluaciones->filter(fn($e) => $e->total_depresion >= 14 && $e->total_depresion <= 20)->count(),
                'Severa'                  => $evaluaciones->filter(fn($e) => $e->total_depresion >= 21 && $e->total_depresion <= 27)->count(),
                'Extremadamente severa'   => $evaluaciones->filter(fn($e) => $e->total_depresion > 27)->count(),
            ],
            'ansiedad' => [
                'Normal'                  => $evaluaciones->filter(fn($e) => $e->total_ansiedad <= 7)->count(),
                'Leve'                    => $evaluaciones->filter(fn($e) => $e->total_ansiedad >= 8 && $e->total_ansiedad <= 9)->count(),
                'Moderada'                => $evaluaciones->filter(fn($e) => $e->total_ansiedad >= 10 && $e->total_ansiedad <= 14)->count(),
                'Severa'                  => $evaluaciones->filter(fn($e) => $e->total_ansiedad >= 15 && $e->total_ansiedad <= 19)->count(),
                'Extremadamente severa'   => $evaluaciones->filter(fn($e) => $e->total_ansiedad > 19)->count(),
            ],
            'estres' => [
                'Normal'                  => $evaluaciones->filter(fn($e) => $e->total_estres <= 14)->count(),
                'Leve'                    => $evaluaciones->filter(fn($e) => $e->total_estres >= 15 && $e->total_estres <= 18)->count(),
                'Moderado'                => $evaluaciones->filter(fn($e) => $e->total_estres >= 19 && $e->total_estres <= 25)->count(),
                'Severo'                  => $evaluaciones->filter(fn($e) => $e->total_estres >= 26 && $e->total_estres <= 33)->count(),
                'Extremadamente severo'   => $evaluaciones->filter(fn($e) => $e->total_estres > 33)->count(),
            ],
        ];

        $facultades = Facultad::all();
        $carreras = Carrera::all();

        return view('admin.reportes.observatorio-dass', compact('stats', 'evaluaciones', 'facultades', 'carreras'));
    }

    public function observatorioDatosFisicos(Request $request)
    {
        $query = DatosFisicos::with('alumno');

        if ($request->filled('facultad')) {
            $query->whereHas('alumno', fn($q) => $q->where('id_facultad', $request->facultad));
        }

        $registros = $query->get();

        $stats = [
            'imc' => $this->calcularDistribucion($registros, 'clasificacion_imc'),
            'glucosa' => $this->calcularDistribucion($registros, 'clasificacion_glucosa'),
            'colesterol' => $this->calcularDistribucion($registros, 'clasificacion_colesterol'),
            'trigliceridos' => $this->calcularDistribucion($registros, 'clasificacion_trigliceridos'),
        ];

        $facultades = Facultad::all();
        return view('admin.reportes.observatorio-datos-fisicos', compact('stats', 'facultades'));
    }

    public function observatorioEstiloVida(Request $request)
    {
        $query = EstiloDeVida::with('alumno');

        if ($request->filled('facultad')) {
            $query->whereHas('alumno', fn($q) => $q->where('id_facultad', $request->facultad));
        }

        $registros = $query->get();

        $stats = [
            'saludable' => $registros->where('estado_saludable', true)->count(),
            'no_saludable' => $registros->where('estado_saludable', false)->count(),
            'promedio_total' => $registros->avg('total') ? round($registros->avg('total'), 1) : 0,
        ];

        $facultades = Facultad::all();
        return view('admin.reportes.observatorio-estilo-vida', compact('stats', 'registros', 'facultades'));
    }

    public function pdfAlumno(string $matricula)
    {
        $alumno = Alumno::with([
            'carrera', 'facultad',
            'datosFisicos',
            'evaluacionesDass.depresion',
            'evaluacionesDass.ansiedad',
            'evaluacionesDass.estres',
            'estilosDeVida',
            'historial',
            'patologias',
        ])->findOrFail($matricula);

        $pdf = Pdf::loadView('admin.reportes.pdf-alumno', compact('alumno'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("reporte_{$matricula}.pdf");
    }

    public function exportarCSV(Request $request)
    {
        $alumnos = Alumno::with(['carrera', 'facultad', 'ultimosDatosFisicos'])->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="alumnos_' . now()->format('Ymd') . '.csv"',
        ];

        $callback = function () use ($alumnos) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

            fputcsv($handle, ['Matrícula', 'Nombre', 'Carrera', 'Facultad', 'Sexo', 'Edad', 'IMC', 'Clasificación IMC']);

            foreach ($alumnos as $alumno) {
                fputcsv($handle, [
                    $alumno->matricula_alum,
                    $alumno->nombre_completo,
                    $alumno->carrera?->nombre_carrera,
                    $alumno->facultad?->nombre_facultad,
                    $alumno->sexo,
                    $alumno->edad_alum,
                    $alumno->ultimosDatosFisicos?->imc,
                    $alumno->ultimosDatosFisicos?->clasificacion_imc,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function calcularDistribucion($collection, string $campo): array
    {
        return $collection->whereNotNull($campo)
            ->groupBy($campo)
            ->map(fn($grupo) => $grupo->count())
            ->toArray();
    }
}
