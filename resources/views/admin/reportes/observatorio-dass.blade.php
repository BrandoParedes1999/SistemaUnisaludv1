@extends('layouts.admin')
@section('title', 'Observatorio DASS-21')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-brain me-2 text-success"></i>Observatorio DASS-21</h4>

<div class="row g-3 mb-4">
    @php
        $colores = ['depresion' => 'success', 'ansiedad' => 'warning', 'estres' => 'danger'];
        $titulos = ['depresion' => 'Depresión', 'ansiedad' => 'Ansiedad', 'estres' => 'Estrés'];
    @endphp
    @foreach($stats as $clave => $distribucion)
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h6 class="fw-semibold mb-0 text-{{ $colores[$clave] }}">{{ $titulos[$clave] }}</h6>
                </div>
                <div class="card-body">
                    @foreach($distribucion as $nivel => $cantidad)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">{{ $nivel }}</span>
                            <span class="badge bg-{{ $colores[$clave] }}">{{ $cantidad }}</span>
                        </div>
                        @php $total = array_sum($distribucion); $pct = $total > 0 ? round($cantidad / $total * 100) : 0; @endphp
                        <div class="progress mb-2" style="height:5px">
                            <div class="progress-bar bg-{{ $colores[$clave] }}" style="width:{{ $pct }}%"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
