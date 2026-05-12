<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Facultad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlumnosController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumno::with(['carrera', 'facultad']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('matricula_alum', 'like', "%{$buscar}%")
                  ->orWhere('nombres_alum', 'like', "%{$buscar}%")
                  ->orWhere('ape_paterno_alum', 'like', "%{$buscar}%")
                  ->orWhere('correo_alum', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('facultad')) {
            $query->where('id_facultad', $request->facultad);
        }

        if ($request->filled('carrera')) {
            $query->where('id_carrera', $request->carrera);
        }

        $alumnos = $query->orderBy('ape_paterno_alum')->paginate(20)->withQueryString();
        $facultades = Facultad::orderBy('nombre_facultad')->get();
        $carreras = Carrera::orderBy('nombre_carrera')->get();

        return view('admin.alumnos.index', compact('alumnos', 'facultades', 'carreras'));
    }

    public function show(string $matricula)
    {
        $alumno = Alumno::with([
            'carrera', 'facultad',
            'ultimosDatosFisicos',
            'ultimaEvaluacionDass.depresion',
            'ultimaEvaluacionDass.ansiedad',
            'ultimaEvaluacionDass.estres',
            'ultimoEstiloDeVida',
            'historial',
            'patologias',
        ])->findOrFail($matricula);

        return view('admin.alumnos.show', compact('alumno'));
    }

    public function edit(string $matricula)
    {
        $alumno = Alumno::findOrFail($matricula);
        $facultades = Facultad::with('carreras')->get();
        $carreras = Carrera::all();
        return view('admin.alumnos.edit', compact('alumno', 'facultades', 'carreras'));
    }

    public function update(Request $request, string $matricula)
    {
        $alumno = Alumno::findOrFail($matricula);

        $data = $request->validate([
            'nombres_alum'      => 'required|string|max:100',
            'ape_paterno_alum'  => 'required|string|max:80',
            'ape_materno_alum'  => 'nullable|string|max:80',
            'sexo'              => 'required|in:Masculino,Femenino,Otro',
            'correo_alum'       => "required|email|max:150|unique:alumnos,correo_alum,{$matricula},matricula_alum",
            'fe_nacimiento_alum' => 'nullable|date',
            'id_carrera'        => 'required|exists:carrera,id_carrera',
            'id_facultad'       => 'required|exists:facultad,id_facultad',
            'tipo_sangre'       => 'nullable|string|max:5',
            'nss'               => 'nullable|string|max:20',
            'enfermedades'      => 'nullable|string',
            'emergencia'        => 'nullable|string|max:200',
        ]);

        $alumno->update($data);

        return redirect()->route('admin.alumnos.show', $matricula)
            ->with('success', 'Datos del alumno actualizados correctamente.');
    }

    public function destroy(string $matricula)
    {
        Alumno::findOrFail($matricula)->delete();
        return redirect()->route('admin.alumnos.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }

    public function resetPassword(Request $request, string $matricula)
    {
        $request->validate([
            'nueva_password' => 'required|string|min:8|confirmed',
        ]);

        Alumno::findOrFail($matricula)->update([
            'password' => Hash::make($request->nueva_password),
        ]);

        return back()->with('success', 'Contraseña restablecida correctamente.');
    }
}
