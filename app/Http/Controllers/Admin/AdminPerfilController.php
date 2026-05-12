<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminPerfilController extends Controller
{
    public function show()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.perfil', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
            'nombre_admi'    => 'required|string|max:100',
            'apellidos_admi' => 'required|string|max:150',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($admin->foto) {
                Storage::disk('public')->delete($admin->foto);
            }
            $data['foto'] = $request->file('foto')->store('fotos-admins', 'public');
        }

        $admin->update($data);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function cambiarPassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'password_actual' => 'required|string',
            'nueva_password'  => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_actual, $admin->contraseña)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
        }

        $admin->update(['contraseña' => Hash::make($request->nueva_password)]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}
