@extends('layouts.admin')
@section('title', 'Observatorio Datos Físicos')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-activity me-2 text-warning"></i>Observatorio Datos Físicos</h4>

<div class="row g-3">
    @foreach($stats as $indicador => $distribucion)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="fw-semibold mb-0">{{ ucfirst($indicador) }}</h6>
                </div>
                <div class="card-body">
                    @if(empty($distribucion))
                        <p class="text-muted small text-center">Sin datos</p>
                    @else
                        @foreach($distribucion as $clasificacion => $cantidad)
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small">{{ $clasificacion }}</span>
                                <span class="badge bg-primary">{{ $cantidad }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
