@extends('layouts.alumno')
@section('title', 'Mi Dashboard')

@section('content')
<h4 class="fw-bold mb-4">Bienvenido, {{ $alumno->nombres_alum }}</h4>

<div class="row g-4">
    <!-- Tarjeta de perfil -->
    <div class="col-lg-4">
        <div class="card text-center h-100">
            <div class="card-body pt-4">
                @if($alumno->foto)
                    <img src="{{ asset('storage/' . $alumno->foto) }}" class="rounded-circle mb-3" style="width:80px;height:80px;object-fit:cover" alt="Foto">
                @else
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px">
                        <i class="bi bi-person fs-1 text-white"></i>
                    </div>
                @endif
                <h5 class="fw-semibold">{{ $alumno->nombre_completo }}</h5>
                <p class="text-muted small">{{ $alumno->matricula_alum }}</p>
                <p class="small text-muted mb-1">{{ $alumno->carrera?->nombre_carrera ?? 'Sin carrera' }}</p>
                <p class="small text-muted">{{ $alumno->facultad?->nombre_facultad ?? '' }}</p>
                <a href="{{ route('alumno.perfil') }}" class="btn btn-sm btn-outline-primary mt-2">
                    <i class="bi bi-person-gear me-1"></i>Ver Perfil
                </a>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="col-lg-8">
        <div class="row g-3">
            <!-- DASS-21 -->
            <div class="col-md-6">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #e8fdf3, #d4f9e8)">
                    <div class="card-body">
                        <i class="bi bi-brain fs-2 text-success mb-2 d-block"></i>
                        <h6 class="fw-semibold">Evaluación DASS-21</h6>
                        <p class="text-muted small mb-3">Evaluación de depresión, ansiedad y estrés.</p>
                        @if($alumno->ultimaEvaluacionDass)
                            <div class="mb-2 small">
                                <span class="badge bg-success me-1">Dep: {{ $alumno->ultimaEvaluacionDass->total_depresion }}</span>
                                <span class="badge bg-warning text-dark me-1">Ans: {{ $alumno->ultimaEvaluacionDass->total_ansiedad }}</span>
                                <span class="badge bg-danger">Est: {{ $alumno->ultimaEvaluacionDass->total_estres }}</span>
                            </div>
                        @endif
                        <div class="d-flex gap-2">
                            <a href="{{ route('alumno.dass.formulario') }}" class="btn btn-success btn-sm flex-fill">
                                <i class="bi bi-clipboard-plus me-1"></i>Iniciar
                            </a>
                            <a href="{{ route('alumno.dass.resultados') }}" class="btn btn-outline-success btn-sm flex-fill">
                                Resultados
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PEPS-I / Estilo de vida -->
            <div class="col-md-6">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #fde8ef, #ffd6e0)">
                    <div class="card-body">
                        <i class="bi bi-heart-pulse fs-2 text-danger mb-2 d-block"></i>
                        <h6 class="fw-semibold">Estilo de Vida (PEPS-I)</h6>
                        <p class="text-muted small mb-3">Evaluación de hábitos y estilo de vida saludable.</p>
                        @if($alumno->ultimoEstiloDeVida)
                            <div class="mb-2">
                                <span class="badge {{ $alumno->ultimoEstiloDeVida->estado_saludable ? 'bg-success' : 'bg-danger' }}">
                                    {{ $alumno->ultimoEstiloDeVida->estado_saludable ? 'Saludable' : 'No Saludable' }}
                                    — {{ $alumno->ultimoEstiloDeVida->total }} pts
                                </span>
                            </div>
                        @endif
                        <div class="d-flex gap-2">
                            <a href="{{ route('alumno.estilo-vida.formulario') }}" class="btn btn-danger btn-sm flex-fill">
                                <i class="bi bi-clipboard-plus me-1"></i>Iniciar
                            </a>
                            <a href="{{ route('alumno.estilo-vida.resultados') }}" class="btn btn-outline-danger btn-sm flex-fill">
                                Resultados
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos físicos -->
            <div class="col-md-6">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #e8f4fd, #d0eafb)">
                    <div class="card-body">
                        <i class="bi bi-activity fs-2 text-primary mb-2 d-block"></i>
                        <h6 class="fw-semibold">Mis Datos Físicos</h6>
                        <p class="text-muted small mb-3">Consulta tu historial de medidas y análisis.</p>
                        @if($alumno->ultimosDatosFisicos)
                            <div class="mb-2 small">
                                <span class="badge bg-primary me-1">IMC: {{ $alumno->ultimosDatosFisicos->imc }}</span>
                                @if($alumno->ultimosDatosFisicos->clasificacion_imc)
                                    <span class="badge bg-secondary">{{ $alumno->ultimosDatosFisicos->clasificacion_imc }}</span>
                                @endif
                            </div>
                        @endif
                        <a href="{{ route('alumno.perfil') }}" class="btn btn-primary btn-sm w-100">
                            Ver Historial
                        </a>
                    </div>
                </div>
            </div>

            <!-- Perfil de salud -->
            <div class="col-md-6">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #fff3e0, #ffe0b2)">
                    <div class="card-body">
                        <i class="bi bi-clipboard-heart fs-2 text-warning mb-2 d-block"></i>
                        <h6 class="fw-semibold">Historial Clínico</h6>
                        <p class="text-muted small mb-3">Tu historial médico y antecedentes.</p>
                        <a href="{{ route('alumno.perfil') }}" class="btn btn-warning btn-sm w-100">
                            <i class="bi bi-file-medical me-1"></i>Ver Historial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
