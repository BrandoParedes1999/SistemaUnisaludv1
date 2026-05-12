<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Credenciales Masivas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 8px; }
        .credencial { border: 2px solid #1a3a5c; border-radius: 4px; padding: 6px; margin-bottom: 8px; width: 200px; display: inline-block; vertical-align: top; margin-right: 8px; }
        .header { background: #1a3a5c; color: #fff; padding: 2px 4px; font-size: 6px; font-weight: bold; margin-bottom: 4px; text-align: center; }
        .nombre { font-weight: bold; font-size: 8px; color: #1a3a5c; margin-bottom: 2px; }
        .contenido { display: flex; gap: 4px; }
        .info { flex: 1; }
        .info .row { margin-bottom: 1px; }
        .info .label { color: #888; }
        .qr img { width: 50px; height: 50px; }
    </style>
</head>
<body>
    @foreach($alumnosConQr as $alumno)
    <div class="credencial">
        <div class="header">SISTEMA INTEGRAL DE SALUD</div>
        <div class="nombre">{{ $alumno->nombre_completo }}</div>
        <div class="contenido">
            <div class="info">
                <div class="row"><span class="label">Mat:</span> {{ $alumno->matricula_alum }}</div>
                <div class="row">{{ $alumno->carrera?->nombre_carrera ?? '—' }}</div>
                <div class="row"><span class="label">Sangre:</span> {{ $alumno->tipo_sangre ?? '—' }}</div>
            </div>
            <div class="qr">
                <img src="data:image/png;base64,{{ $alumno->qrCode }}" alt="QR">
            </div>
        </div>
    </div>
    @endforeach
</body>
</html>
