<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte — {{ $alumno->matricula_alum }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 20px; }
        h1 { font-size: 16px; color: #1a3a5c; margin-bottom: 4px; }
        h2 { font-size: 13px; color: #1a3a5c; margin: 16px 0 6px; border-bottom: 1px solid #ddd; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td, th { padding: 5px 8px; border: 1px solid #ddd; }
        th { background: #1a3a5c; color: #fff; text-align: left; font-size: 10px; }
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 9px; }
        .badge-success { background: #28a745; color: #fff; }
        .badge-danger { background: #dc3545; color: #fff; }
        .badge-warning { background: #ffc107; color: #000; }
        .header { display: flex; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #1a3a5c; padding-bottom: 12px; }
        .section { margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>Sistema Integral de Salud</h1>
            <div style="color:#666;font-size:10px">Reporte Clínico del Estudiante — {{ now()->format('d/m/Y') }}</div>
        </div>
    </div>

    <h2>Datos Personales</h2>
    <table>
        <tr>
            <td><strong>Matrícula:</strong> {{ $alumno->matricula_alum }}</td>
            <td><strong>Nombre:</strong> {{ $alumno->nombre_completo }}</td>
        </tr>
        <tr>
            <td><strong>Carrera:</strong> {{ $alumno->carrera?->nombre_carrera }}</td>
            <td><strong>Facultad:</strong> {{ $alumno->facultad?->nombre_facultad }}</td>
        </tr>
        <tr>
            <td><strong>Sexo:</strong> {{ $alumno->sexo }}</td>
            <td><strong>Correo:</strong> {{ $alumno->correo_alum }}</td>
        </tr>
        <tr>
            <td><strong>Tipo Sangre:</strong> {{ $alumno->tipo_sangre ?? '—' }}</td>
            <td><strong>NSS:</strong> {{ $alumno->nss ?? '—' }}</td>
        </tr>
    </table>

    @if($alumno->datosFisicos->count())
        <h2>Datos Físicos (Último Registro)</h2>
        @php $df = $alumno->datosFisicos->first(); @endphp
        <table>
            <tr>
                <th>Fecha</th><th>Peso (kg)</th><th>Talla (m)</th><th>IMC</th><th>Clasificación</th><th>Glucosa</th><th>Colesterol</th>
            </tr>
            <tr>
                <td>{{ $df->fecha->format('d/m/Y') }}</td>
                <td>{{ $df->peso }}</td>
                <td>{{ $df->talla }}</td>
                <td>{{ $df->imc }}</td>
                <td>{{ $df->clasificacion_imc }}</td>
                <td>{{ $df->glucosa ?? '—' }}</td>
                <td>{{ $df->colesterol ?? '—' }}</td>
            </tr>
        </table>
    @endif

    @if($alumno->evaluacionesDass->count())
        <h2>Evaluaciones DASS-21</h2>
        <table>
            <tr><th>Fecha</th><th>Depresión</th><th>Severidad</th><th>Ansiedad</th><th>Severidad</th><th>Estrés</th><th>Severidad</th></tr>
            @foreach($alumno->evaluacionesDass->take(5) as $ev)
                <tr>
                    <td>{{ $ev->created_at->format('d/m/Y') }}</td>
                    <td>{{ $ev->total_depresion }}</td>
                    <td>{{ \App\Models\DassEvaluacion::severidadDepresion($ev->total_depresion) }}</td>
                    <td>{{ $ev->total_ansiedad }}</td>
                    <td>{{ \App\Models\DassEvaluacion::severidadAnsiedad($ev->total_ansiedad) }}</td>
                    <td>{{ $ev->total_estres }}</td>
                    <td>{{ \App\Models\DassEvaluacion::severidadEstres($ev->total_estres) }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    @if($alumno->estilosDeVida->count())
        <h2>Estilo de Vida (PEPS-I)</h2>
        <table>
            <tr><th>Fecha</th><th>Puntaje Total</th><th>Estado</th></tr>
            @foreach($alumno->estilosDeVida->take(5) as $ev)
                <tr>
                    <td>{{ $ev->fecha->format('d/m/Y') }}</td>
                    <td>{{ $ev->total }}</td>
                    <td>{{ $ev->estado_saludable ? 'Saludable' : 'No Saludable' }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <div style="margin-top:30px;font-size:9px;color:#999;text-align:center;border-top:1px solid #eee;padding-top:8px">
        Documento generado automáticamente — Sistema Integral de Salud — {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
