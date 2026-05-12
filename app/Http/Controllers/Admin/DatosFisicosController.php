<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\DatosFisicos;
use Illuminate\Http\Request;

class DatosFisicosController extends Controller
{
    public function create(string $matricula)
    {
        $alumno = Alumno::findOrFail($matricula);
        return view('admin.datos-fisicos.create', compact('alumno'));
    }

    public function store(Request $request, string $matricula)
    {
        $alumno = Alumno::findOrFail($matricula);

        $data = $request->validate([
            'fecha'        => 'required|date',
            'peso'         => 'required|numeric|min:1|max:300',
            'talla'        => 'required|numeric|min:0.5|max:2.5',
            'cintura'      => 'nullable|numeric|min:1|max:200',
            'cadera'       => 'nullable|numeric|min:1|max:200',
            'glucosa'      => 'nullable|numeric|min:1|max:600',
            'trigliceridos' => 'nullable|numeric|min:1|max:1000',
            'colesterol'   => 'nullable|numeric|min:1|max:600',
            'tension_arterial' => 'nullable|string|max:20',
            'porcentaje_masa_grasa' => 'nullable|numeric|min:0|max:100',
            'agua_total'   => 'nullable|numeric|min:0|max:100',
            'masa_muscular' => 'nullable|numeric|min:0|max:150',
            'masa_osea'    => 'nullable|numeric|min:0|max:10',
            'grasa_visceral' => 'nullable|numeric|min:0|max:50',
        ]);

        // Calculate derived values
        if ($data['peso'] && $data['talla']) {
            $data['imc'] = round($data['peso'] / ($data['talla'] ** 2), 2);
            $data['clasificacion_imc'] = DatosFisicos::clasificarIMC($data['imc']);
            $data['mb'] = round(10 * $data['peso'] + 6.25 * ($data['talla'] * 100) - 5 * ($alumno->edad_alum ?? 20) + ($alumno->sexo === 'Masculino' ? 5 : -161), 2);
        }

        if (!empty($data['cintura']) && !empty($data['cadera'])) {
            $data['icc'] = round($data['cintura'] / $data['cadera'], 4);
        }

        if (!empty($data['cintura']) && $data['talla']) {
            $data['ice'] = round($data['cintura'] / ($data['talla'] * 100), 4);
        }

        if (!empty($data['glucosa'])) {
            $data['clasificacion_glucosa'] = DatosFisicos::clasificarGlucosa($data['glucosa']);
        }

        if (!empty($data['colesterol'])) {
            $data['clasificacion_colesterol'] = DatosFisicos::clasificarColesterol($data['colesterol']);
        }

        if (!empty($data['trigliceridos'])) {
            $data['clasificacion_trigliceridos'] = DatosFisicos::clasificarTrigliceridos($data['trigliceridos']);
        }

        $data['matricula_alum'] = $matricula;

        DatosFisicos::create($data);

        return redirect()->route('admin.alumnos.show', $matricula)
            ->with('success', 'Datos físicos registrados correctamente.');
    }

    public function historial(string $matricula)
    {
        $alumno = Alumno::findOrFail($matricula);
        $registros = DatosFisicos::where('matricula_alum', $matricula)
            ->orderByDesc('fecha')
            ->paginate(15);

        return view('admin.datos-fisicos.historial', compact('alumno', 'registros'));
    }

    public function destroy(int $id)
    {
        $registro = DatosFisicos::findOrFail($id);
        $matricula = $registro->matricula_alum;
        $registro->delete();

        return redirect()->route('admin.datos-fisicos.historial', $matricula)
            ->with('success', 'Registro eliminado.');
    }
}
