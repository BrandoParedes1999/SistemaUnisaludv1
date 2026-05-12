<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\RegistroIngreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario'  => 'required|string|max:50',
            'password' => 'required|string',
        ], [
            'usuario.required'  => 'Debe ingresar su usuario.',
            'password.required' => 'Debe ingresar su contraseña.',
        ]);

        $admin = Admin::where('usuario', $request->usuario)->first();

        if (!$admin) {
            return back()->withErrors(['usuario' => 'Usuario no encontrado.'])->withInput(['usuario' => $request->usuario]);
        }

        // Check permanent block
        $bloqueos = [120, 300, 1800, 3600, 86400];
        if ($admin->intentos_fallidos >= count($bloqueos) * 3) {
            return back()->withErrors(['usuario' => 'Su cuenta ha sido bloqueada permanentemente. Contacte al administrador.']);
        }

        // Check temporal block
        if ($admin->intentos_fallidos >= 3 && ($admin->intentos_fallidos % 3) === 0) {
            $indice = min((int) floor($admin->intentos_fallidos / 3) - 1, count($bloqueos) - 1);
            $tiempoEspera = $bloqueos[$indice];
            $segundosDesde = $admin->ultimo_intento ? now()->diffInSeconds($admin->ultimo_intento, false) * -1 : PHP_INT_MAX;

            if ($segundosDesde < $tiempoEspera) {
                $restante = gmdate('H:i:s', $tiempoEspera - $segundosDesde);
                return back()->withErrors(['usuario' => "Cuenta bloqueada. Intente en {$restante}."]);
            }
        }

        if (!Hash::check($request->password, $admin->contraseña)) {
            $intentos = $admin->intentos_fallidos + 1;
            $admin->update(['intentos_fallidos' => $intentos, 'ultimo_intento' => now()]);

            $restantes = 3 - ($intentos % 3);
            $msg = $restantes > 0
                ? "Contraseña incorrecta. Intentos restantes: {$restantes}."
                : 'Has agotado los intentos. Tu cuenta está bloqueada temporalmente.';

            return back()->withErrors(['password' => $msg])->withInput(['usuario' => $request->usuario]);
        }

        // Close previous open sessions
        RegistroIngreso::where('usuario', $admin->usuario)
            ->whereNull('fecha_salida')
            ->update(['fecha_salida' => now()]);

        // Register new login
        $registro = RegistroIngreso::create([
            'usuario'        => $admin->usuario,
            'nombre_completo' => $admin->nombre_completo,
            'rol'            => $admin->rol,
            'fecha_ingreso'  => now(),
        ]);

        // Reset failed attempts
        $admin->update(['intentos_fallidos' => 0, 'ultimo_intento' => now()]);

        Auth::guard('admin')->login($admin, $request->boolean('recordarme'));

        $request->session()->regenerate();
        $request->session()->put('registro_ingreso_id', $registro->id);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $registroId = $request->session()->get('registro_ingreso_id');
        if ($registroId) {
            RegistroIngreso::where('id', $registroId)->update(['fecha_salida' => now()]);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Sesión cerrada exitosamente.');
    }
}
