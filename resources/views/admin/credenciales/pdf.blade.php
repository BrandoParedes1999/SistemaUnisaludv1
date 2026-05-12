<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Credencial — {{ $alumno->matricula_alum }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; width: 85.6mm; height: 54mm; padding: 6px; background: #fff; }
        .card-body { border: 2px solid #1a3a5c; border-radius: 6px; padding: 8px; height: 100%; display: flex; flex-direction: column; justify-content: space-between; }
        .header { background: #1a3a5c; color: #fff; padding: 4px 8px; border-radius: 4px; text-align: center; font-size: 8px; font-weight: bold; margin-bottom: 6px; }
        .content { display: flex; gap: 8px; }
        .info { flex: 1; font-size: 8px; }
        .info .nombre { font-size: 10px; font-weight: bold; color: #1a3a5c; margin-bottom: 3px; }
        .info .row { margin-bottom: 2px; }
        .info .label { color: #666; }
        .qr { width: 60px; height: 60px; }
        .qr img { width: 100%; height: 100%; }
        .footer { font-size: 7px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 4px; }
    </style>
</head>
<body>
    <div class="card-body">
        <div class="header">SISTEMA INTEGRAL DE SALUD — UNACAR</div>
        <div class="content">
            <div class="info">
                <div class="nombre">{{ $alumno->nombre_completo }}</div>
                <div class="row"><span class="label">Matrícula: </span>{{ $alumno->matricula_alum }}</div>
                <div class="row"><span class="label">Carrera: </span>{{ $alumno->carrera?->nombre_carrera ?? '—' }}</div>
                <div class="row"><span class="label">Facultad: </span>{{ $alumno->facultad?->nombre_facultad ?? '—' }}</div>
                <div class="row"><span class="label">Sangre: </span>{{ $alumno->tipo_sangre ?? '—' }}</div>
                <div class="row"><span class="label">Emergencia: </span>{{ $alumno->emergencia ?? '—' }}</div>
            </div>
            <div class="qr">
                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR">
            </div>
        </div>
        <div class="footer">Credencial válida para servicios de salud universitaria — {{ now()->year }}</div>
    </div>
</body>
</html>
