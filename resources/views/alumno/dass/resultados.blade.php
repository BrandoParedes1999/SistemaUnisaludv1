@extends('layouts.alumno')
@section('title', 'Resultados DASS-21')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-brain me-2 text-success"></i>Mis Resultados DASS-21</h4>
    <a href="{{ route('alumno.dass.formulario') }}" class="btn btn-success btn-sm">
        <i class="bi bi-clipboard-plus me-1"></i>Nueva Evaluación
    </a>
</div>

@forelse($evaluaciones as $ev)
    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-medium small"><i class="bi bi-calendar3 me-2 text-muted"></i>{{ $ev->created_at->format('d/m/Y H:i') }}</span>
            <span class="badge bg-secondary">Total: {{ $ev->total_general }}</span>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @php
                    $categorias = [
                        ['titulo' => 'Depresión', 'total' => $ev->total_depresion, 'severidad' => \App\Models\DassEvaluacion::severidadDepresion($ev->total_depresion), 'color' => 'success'],
                        ['titulo' => 'Ansiedad', 'total' => $ev->total_ansiedad, 'severidad' => \App\Models\DassEvaluacion::severidadAnsiedad($ev->total_ansiedad), 'color' => 'warning'],
                        ['titulo' => 'Estrés', 'total' => $ev->total_estres, 'severidad' => \App\Models\DassEvaluacion::severidadEstres($ev->total_estres), 'color' => 'danger'],
                    ];
                @endphp
                @foreach($categorias as $cat)
                    <div class="col-md-4 text-center">
                        <div class="p-3 rounded-3 bg-light">
                            <div class="fs-2 fw-bold text-{{ $cat['color'] }}">{{ $cat['total'] }}</div>
                            <div class="fw-medium">{{ $cat['titulo'] }}</div>
                            <span class="badge bg-{{ $cat['color'] }} mt-1">{{ $cat['severidad'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-clipboard fs-1 d-block mb-3 opacity-25"></i>
        <h5>Sin evaluaciones registradas</h5>
        <a href="{{ route('alumno.dass.formulario') }}" class="btn btn-success mt-2">
            <i class="bi bi-clipboard-plus me-2"></i>Hacer mi primera evaluación
        </a>
    </div>
@endforelse

{{ $evaluaciones->links() }}
@endsection
