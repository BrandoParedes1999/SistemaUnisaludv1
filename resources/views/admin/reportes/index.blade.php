@extends('layouts.admin')
@section('title', 'Reportes')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-bar-chart me-2 text-primary"></i>Reportes y Observatorio</h4>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body pt-4">
                <i class="bi bi-brain fs-1 text-success mb-3 d-block"></i>
                <h6 class="fw-semibold">Observatorio DASS-21</h6>
                <p class="text-muted small">Distribución de niveles de depresión, ansiedad y estrés.</p>
                <a href="{{ route('admin.reportes.dass') }}" class="btn btn-success btn-sm">Ver Reporte</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body pt-4">
                <i class="bi bi-activity fs-1 text-warning mb-3 d-block"></i>
                <h6 class="fw-semibold">Observatorio Datos Físicos</h6>
                <p class="text-muted small">IMC, glucosa, colesterol y triglicéridos de la población.</p>
                <a href="{{ route('admin.reportes.datos-fisicos') }}" class="btn btn-warning btn-sm">Ver Reporte</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body pt-4">
                <i class="bi bi-heart-pulse fs-1 text-danger mb-3 d-block"></i>
                <h6 class="fw-semibold">Observatorio Estilo de Vida</h6>
                <p class="text-muted small">Análisis de hábitos y estilos de vida (PEPS-I).</p>
                <a href="{{ route('admin.reportes.estilo-vida') }}" class="btn btn-danger btn-sm">Ver Reporte</a>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <h6 class="fw-semibold mb-3">Exportar Datos</h6>
        <a href="{{ route('admin.reportes.exportar-csv') }}" class="btn btn-outline-secondary">
            <i class="bi bi-file-earmark-spreadsheet me-2"></i>Exportar CSV de Alumnos
        </a>
    </div>
</div>
@endsection
