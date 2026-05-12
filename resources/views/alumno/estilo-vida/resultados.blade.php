@extends('layouts.alumno')
@section('title', 'Resultados Estilo de Vida')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-heart-pulse me-2 text-danger"></i>Mis Resultados PEPS-I</h4>
    <a href="{{ route('alumno.estilo-vida.formulario') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-clipboard-plus me-1"></i>Nueva Evaluación
    </a>
</div>

@forelse($evaluaciones as $ev)
    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between">
            <span class="fw-medium small"><i class="bi bi-calendar3 me-2 text-muted"></i>{{ $ev->fecha->format('d/m/Y') }}</span>
            <span class="badge {{ $ev->estado_saludable ? 'bg-success' : 'bg-danger' }}">
                {{ $ev->estado_saludable ? 'Saludable' : 'No Saludable' }}
            </span>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3 text-center">
                    <div class="fs-1 fw-bold text-{{ $ev->estado_saludable ? 'success' : 'danger' }}">{{ $ev->total }}</div>
                    <div class="small text-muted">Puntaje Total</div>
                    <div class="small text-muted">de 192 máx</div>
                </div>
                @if($ev->nutricion)
                    <div class="col-md-3 text-center">
                        <div class="fs-3 fw-bold text-primary">{{ $ev->nutricion->total_nutricion }}</div>
                        <div class="small">Nutrición</div>
                        <span class="badge {{ $ev->nutricion->saludable ? 'bg-success' : 'bg-warning text-dark' }}">{{ $ev->nutricion->saludable ? 'Saludable' : 'Mejorable' }}</span>
                    </div>
                @endif
                @if($ev->ejercicio)
                    <div class="col-md-3 text-center">
                        <div class="fs-3 fw-bold text-info">{{ $ev->ejercicio->total_ejercicio }}</div>
                        <div class="small">Ejercicio</div>
                        <span class="badge {{ $ev->ejercicio->saludable_ejercicio ? 'bg-success' : 'bg-warning text-dark' }}">{{ $ev->ejercicio->saludable_ejercicio ? 'Saludable' : 'Mejorable' }}</span>
                    </div>
                @endif
                @if($ev->manejoEstres)
                    <div class="col-md-3 text-center">
                        <div class="fs-3 fw-bold text-warning">{{ $ev->manejoEstres->total_manejoestres }}</div>
                        <div class="small">Manejo Estrés</div>
                        <span class="badge {{ $ev->manejoEstres->saludable_manejo ? 'bg-success' : 'bg-warning text-dark' }}">{{ $ev->manejoEstres->saludable_manejo ? 'Saludable' : 'Mejorable' }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-heart fs-1 d-block mb-3 opacity-25"></i>
        <h5>Sin evaluaciones registradas</h5>
        <a href="{{ route('alumno.estilo-vida.formulario') }}" class="btn btn-danger mt-2">
            <i class="bi bi-clipboard-plus me-2"></i>Hacer mi primera evaluación
        </a>
    </div>
@endforelse

{{ $evaluaciones->links() }}
@endsection
