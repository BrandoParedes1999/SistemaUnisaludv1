@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Panel de Control</h4>
    <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i>{{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e8f4fd">
                    <i class="bi bi-people-fill fs-3 text-primary"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-primary">{{ $stats['total_alumnos'] }}</div>
                    <div class="text-muted small">Total Alumnos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#e8fdf3">
                    <i class="bi bi-brain fs-3 text-success"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-success">{{ $stats['evaluaciones_dass'] }}</div>
                    <div class="text-muted small">Evaluaciones DASS-21</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#fdf6e8">
                    <i class="bi bi-activity fs-3 text-warning"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-warning">{{ $stats['datos_fisicos'] }}</div>
                    <div class="text-muted small">Datos Físicos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3" style="background:#fde8ef">
                    <i class="bi bi-heart-pulse fs-3 text-danger"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-danger">{{ $stats['estilos_vida'] }}</div>
                    <div class="text-muted small">Estilos de Vida</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Alumnos por facultad -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0">
                <h6 class="fw-semibold mb-0"><i class="bi bi-building me-2 text-primary"></i>Alumnos por Facultad</h6>
            </div>
            <div class="card-body">
                @foreach($facultades as $facultad)
                    @php $pct = $stats['total_alumnos'] > 0 ? round($facultad->alumnos_count / $stats['total_alumnos'] * 100) : 0; @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-truncate" style="max-width:60%">{{ $facultad->nombre_facultad }}</span>
                            <span class="fw-semibold">{{ $facultad->alumnos_count }} ({{ $pct }}%)</span>
                        </div>
                        <div class="progress" style="height:6px">
                            <div class="progress-bar" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
                @if($facultades->isEmpty())
                    <p class="text-muted small text-center py-3">No hay facultades registradas</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Últimos ingresos -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between">
                <h6 class="fw-semibold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Últimos Ingresos</h6>
                <span class="badge bg-success">{{ $stats['sesiones_activas'] }} activas</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Usuario</th>
                                <th>Rol</th>
                                <th>Ingreso</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosIngresos as $ingreso)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-medium small">{{ $ingreso->usuario }}</div>
                                        <div class="text-muted" style="font-size:.7rem">{{ $ingreso->nombre_completo }}</div>
                                    </td>
                                    <td><span class="badge bg-primary">{{ $ingreso->rol }}</span></td>
                                    <td class="small text-muted">{{ $ingreso->fecha_ingreso->format('d/m H:i') }}</td>
                                    <td>
                                        @if($ingreso->fecha_salida)
                                            <span class="badge bg-secondary">Cerrada</span>
                                        @else
                                            <span class="badge bg-success">Activa</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3 small">Sin registros</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Acciones Rápidas</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.alumnos.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-people me-1"></i>Ver Alumnos
                    </a>
                    <a href="{{ route('admin.reportes.dass') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-brain me-1"></i>Observatorio DASS
                    </a>
                    <a href="{{ route('admin.reportes.datos-fisicos') }}" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-activity me-1"></i>Datos Físicos
                    </a>
                    <a href="{{ route('admin.credenciales.index') }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-card-heading me-1"></i>Credenciales
                    </a>
                    <a href="{{ route('admin.reportes.exportar-csv') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-download me-1"></i>Exportar CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
