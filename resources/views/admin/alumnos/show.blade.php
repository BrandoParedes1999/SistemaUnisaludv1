@extends('layouts.admin')
@section('title', 'Detalle Alumno')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.alumnos.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Expediente: {{ $alumno->matricula_alum }}</h4>
</div>

<div class="row g-4">
    <!-- Datos personales -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center pt-4">
                @if($alumno->foto)
                    <img src="{{ asset('storage/' . $alumno->foto) }}" class="rounded-circle mb-3" style="width:90px;height:90px;object-fit:cover" alt="Foto">
                @else
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width:90px;height:90px">
                        <i class="bi bi-person fs-1 text-white"></i>
                    </div>
                @endif
                <h5 class="fw-bold">{{ $alumno->nombre_completo }}</h5>
                <p class="text-muted small mb-1">{{ $alumno->matricula_alum }}</p>
                <p class="text-muted small">{{ $alumno->correo_alum }}</p>
                <span class="badge bg-primary">{{ $alumno->carrera?->nombre_carrera ?? 'Sin carrera' }}</span>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">Facultad</dt>
                    <dd class="col-7">{{ $alumno->facultad?->nombre_facultad ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Sexo</dt>
                    <dd class="col-7">{{ $alumno->sexo ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Nacimiento</dt>
                    <dd class="col-7">{{ $alumno->fe_nacimiento_alum?->format('d/m/Y') ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Tipo Sangre</dt>
                    <dd class="col-7">{{ $alumno->tipo_sangre ?? '—' }}</dd>
                    <dt class="col-5 text-muted">NSS</dt>
                    <dd class="col-7">{{ $alumno->nss ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Emergencia</dt>
                    <dd class="col-7">{{ $alumno->emergencia ?? '—' }}</dd>
                </dl>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('admin.alumnos.edit', $alumno->matricula_alum) }}" class="btn btn-sm btn-outline-warning flex-fill">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
                <a href="{{ route('admin.reportes.pdf-alumno', $alumno->matricula_alum) }}" class="btn btn-sm btn-outline-danger flex-fill" target="_blank">
                    <i class="bi bi-file-pdf me-1"></i>PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Datos clínicos -->
    <div class="col-lg-8">
        <!-- Últimos datos físicos -->
        <div class="card mb-4">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-semibold mb-0"><i class="bi bi-activity me-2 text-warning"></i>Últimos Datos Físicos</h6>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.datos-fisicos.create', $alumno->matricula_alum) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus me-1"></i>Nuevo
                    </a>
                    <a href="{{ route('admin.datos-fisicos.historial', $alumno->matricula_alum) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-clock-history me-1"></i>Historial
                    </a>
                </div>
            </div>
            @if($alumno->ultimosDatosFisicos)
                @php $df = $alumno->ultimosDatosFisicos; @endphp
                <div class="card-body">
                    <div class="row g-3 text-center">
                        @php
                            $indicadores = [
                                ['label' => 'IMC', 'valor' => $df->imc, 'clasificacion' => $df->clasificacion_imc, 'icono' => 'bi-speedometer'],
                                ['label' => 'Glucosa', 'valor' => $df->glucosa, 'clasificacion' => $df->clasificacion_glucosa, 'icono' => 'bi-droplet'],
                                ['label' => 'Colesterol', 'valor' => $df->colesterol, 'clasificacion' => $df->clasificacion_colesterol, 'icono' => 'bi-heart'],
                                ['label' => 'Triglicéridos', 'valor' => $df->trigliceridos, 'clasificacion' => $df->clasificacion_trigliceridos, 'icono' => 'bi-graph-up'],
                            ];
                        @endphp
                        @foreach($indicadores as $ind)
                            <div class="col-6 col-md-3">
                                <div class="p-2 rounded-3 bg-light">
                                    <i class="bi {{ $ind['icono'] }} text-primary mb-1 d-block"></i>
                                    <div class="fw-bold">{{ $ind['valor'] ?? '—' }}</div>
                                    <div class="text-muted" style="font-size:.7rem">{{ $ind['label'] }}</div>
                                    @if($ind['clasificacion'])
                                        <span class="badge bg-secondary mt-1" style="font-size:.65rem">{{ $ind['clasificacion'] }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-muted small mt-2 text-end">
                        <i class="bi bi-calendar me-1"></i>{{ $df->fecha->format('d/m/Y') }}
                    </div>
                </div>
            @else
                <div class="card-body text-center text-muted py-4">
                    <i class="bi bi-clipboard-plus d-block fs-2 mb-2 opacity-25"></i>
                    <small>Sin datos físicos registrados</small>
                </div>
            @endif
        </div>

        <!-- DASS-21 -->
        <div class="card mb-4">
            <div class="card-header bg-white border-0">
                <h6 class="fw-semibold mb-0"><i class="bi bi-brain me-2 text-success"></i>Última Evaluación DASS-21</h6>
            </div>
            @if($alumno->ultimaEvaluacionDass)
                @php $dass = $alumno->ultimaEvaluacionDass; @endphp
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <div class="p-2 rounded-3" style="background:#e8fdf3">
                                <div class="fs-4 fw-bold text-success">{{ $dass->total_depresion }}</div>
                                <div class="small text-muted">Depresión</div>
                                <span class="badge bg-success mt-1" style="font-size:.65rem">{{ \App\Models\DassEvaluacion::severidadDepresion($dass->total_depresion) }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded-3" style="background:#fff3e0">
                                <div class="fs-4 fw-bold text-warning">{{ $dass->total_ansiedad }}</div>
                                <div class="small text-muted">Ansiedad</div>
                                <span class="badge bg-warning text-dark mt-1" style="font-size:.65rem">{{ \App\Models\DassEvaluacion::severidadAnsiedad($dass->total_ansiedad) }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded-3" style="background:#fde8ef">
                                <div class="fs-4 fw-bold text-danger">{{ $dass->total_estres }}</div>
                                <div class="small text-muted">Estrés</div>
                                <span class="badge bg-danger mt-1" style="font-size:.65rem">{{ \App\Models\DassEvaluacion::severidadEstres($dass->total_estres) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card-body text-center text-muted py-3">
                    <small>Sin evaluaciones DASS-21</small>
                </div>
            @endif
        </div>

        <!-- Estilo de vida -->
        <div class="card">
            <div class="card-header bg-white border-0">
                <h6 class="fw-semibold mb-0"><i class="bi bi-heart-pulse me-2 text-danger"></i>Último Estilo de Vida (PEPS-I)</h6>
            </div>
            @if($alumno->ultimoEstiloDeVida)
                @php $ev = $alumno->ultimoEstiloDeVida; @endphp
                <div class="card-body d-flex align-items-center gap-4">
                    <div class="text-center">
                        <div class="fs-1 fw-bold {{ $ev->estado_saludable ? 'text-success' : 'text-danger' }}">{{ $ev->total }}</div>
                        <div class="small text-muted">Puntaje Total</div>
                    </div>
                    <div>
                        <span class="badge {{ $ev->estado_saludable ? 'bg-success' : 'bg-danger' }} fs-6 mb-1">
                            {{ $ev->estado_saludable ? 'Estilo Saludable' : 'No Saludable' }}
                        </span>
                        <div class="text-muted small">Evaluado: {{ $ev->fecha->format('d/m/Y') }}</div>
                    </div>
                </div>
            @else
                <div class="card-body text-center text-muted py-3">
                    <small>Sin evaluaciones de estilo de vida</small>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
