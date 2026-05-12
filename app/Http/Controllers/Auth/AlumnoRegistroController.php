<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Facultad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AlumnoRegistroController extends Controller
{
    public function showRegistroForm()
    {
        $facultades = Facultad::with('carreras')->get();
        $carreras = Carrera::all();
        return view('auth.alumno-registro', compact('facultades', 'carreras'));
    }

    public function registro(Request $request)
    {
        $request->validate([
            'matricula_alum'    => 'required|string|max:20|unique:alumnos,matricula_alum',
            'nombres_alum'      => 'required|string|max:100',
            'ape_paterno_alum'  => 'required|string|max:80',
            'ape_materno_alum'  => 'nullable|string|max:80',
            'sexo'              => 'required|in:Masculino,Femenino,Otro',
            'correo_alum'       => 'required|email|max:150|unique:alumnos,correo_alum',
            'fe_nacimiento_alum' => 'required|date|before:today',
            'id_carrera'        => 'required|exists:carrera,id_carrera',
            'id_facultad'       => 'required|exists:facultad,id_facultad',
            'password'          => ['required', 'confirmed', Password::min(8)],
        ], [
            'matricula_alum.unique' => 'Esta matrícula ya está registrada.',
            'correo_alum.unique'    => 'Este correo ya está registrado.',
        ]);

        Alumno::create([
            'matricula_alum'    => $request->matricula_alum,
            'nombres_alum'      => $request->nombres_alum,
            'ape_paterno_alum'  => $request->ape_paterno_alum,
            'ape_materno_alum'  => $request->ape_materno_alum,
            'sexo'              => $request->sexo,
            'correo_alum'       => $request->correo_alum,
            'fe_nacimiento_alum' => $request->fe_nacimiento_alum,
            'id_carrera'        => $request->id_carrera,
            'id_facultad'       => $request->id_facultad,
            'fecha_ingreso'     => now()->toDateString(),
            'password'          => Hash::make($request->password),
        ]);

        return redirect()->route('alumno.login')
            ->with('success', 'Registro exitoso. Ya puede iniciar sesión.');
    }
}
