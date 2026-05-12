@extends('layouts.admin')
@section('title', 'Observatorio Estilo de Vida')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-heart-pulse me-2 text-danger"></i>Observatorio Estilo de Vida (PEPS-I)</h4>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="fs-1 fw-bold text-success">{{ $stats['saludable'] }}</div>
                <p class="text-muted small">Estilo Saludable</p>
                @php $total = $stats['saludable'] + $stats['no_saludable']; @endphp
                <div class="progress" style="height:8px">
                    <div class="progress-bar bg-success" style="width:{{ $total > 0 ? round($stats['saludable']/$total*100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="fs-1 fw-bold text-danger">{{ $stats['no_saludable'] }}</div>
                <p class="text-muted small">No Saludable</p>
                <div class="progress" style="height:8px">
                    <div class="progress-bar bg-danger" style="width:{{ $total > 0 ? round($stats['no_saludable']/$total*100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="fs-1 fw-bold text-primary">{{ $stats['promedio_total'] }}</div>
                <p class="text-muted small">Puntaje Promedio</p>
                <div class="progress" style="height:8px">
                    <div class="progress-bar" style="width:{{ min(round($stats['promedio_total']/192*100), 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
