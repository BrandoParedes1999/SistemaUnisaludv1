<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CredencialesController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::with(['carrera', 'facultad'])
            ->orderBy('ape_paterno_alum')
            ->paginate(30);

        return view('admin.credenciales.index', compact('alumnos'));
    }

    public function generar(string $matricula)
    {
        $alumno = Alumno::with(['carrera', 'facultad'])->findOrFail($matricula);

        $qrCode = base64_encode(
            QrCode::format('png')->size(120)->generate($alumno->matricula_alum)
        );

        $pdf = Pdf::loadView('admin.credenciales.pdf', compact('alumno', 'qrCode'))
            ->setPaper([0, 0, 241.89, 153.07]); // Tamaño credencial 85.6x54mm

        return $pdf->download("credencial_{$matricula}.pdf");
    }

    public function generarTodas()
    {
        $alumnos = Alumno::with(['carrera', 'facultad'])->get();

        $alumnosConQr = $alumnos->map(function ($alumno) {
            $alumno->qrCode = base64_encode(
                QrCode::format('png')->size(120)->generate($alumno->matricula_alum)
            );
            return $alumno;
        });

        $pdf = Pdf::loadView('admin.credenciales.pdf-masivo', compact('alumnosConQr'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('credenciales_' . now()->format('Ymd') . '.pdf');
    }
}
