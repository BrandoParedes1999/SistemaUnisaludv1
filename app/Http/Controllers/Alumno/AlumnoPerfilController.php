<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AlumnoPerfilController extends Controller
{
    public function show()
    {
        $alumno = Auth::guard('alumno')->user()->load(['carrera', 'facultad']);
        return view('alumno.perfil', compact('alumno'));
    }

    public function update(Request $request)
    {
        $alumno = Auth::guard('alumno')->user();

        $data = $request->validate([
            'emergencia' => 'nullable|string|max:200',
            'enfermedades' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($alumno->foto) {
                Storage::disk('public')->delete($alumno->foto);
            }
            $data['foto'] = $request->file('foto')->store('fotos-alumnos', 'public');
        }

        $alumno->update($data);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function cambiarPassword(Request $request)
    {
        $alumno = Auth::guard('alumno')->user();

        $request->validate([
            'password_actual' => 'required|string',
            'nueva_password'  => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_actual, $alumno->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
        }

        $alumno->update(['password' => Hash::make($request->nueva_password)]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}
