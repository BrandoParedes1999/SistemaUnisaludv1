<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AlumnoLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('alumno')->check()) {
            return redirect()->route('alumno.dashboard');
        }
        return view('auth.alumno-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'matricula' => 'required|string|max:20',
            'password'  => 'required|string',
        ], [
            'matricula.required' => 'Ingrese su matrícula.',
            'password.required'  => 'Ingrese su contraseña.',
        ]);

        $alumno = Alumno::find($request->matricula);

        if (!$alumno || !Hash::check($request->password, $alumno->password)) {
            return back()->withErrors(['matricula' => 'Matrícula o contraseña incorrecta.'])
                ->withInput(['matricula' => $request->matricula]);
        }

        Auth::guard('alumno')->login($alumno, $request->boolean('recordarme'));
        $request->session()->regenerate();

        return redirect()->intended(route('alumno.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('alumno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('alumno.login')->with('success', 'Sesión cerrada exitosamente.');
    }
}
