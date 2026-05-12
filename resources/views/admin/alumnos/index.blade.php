@extends('layouts.admin')
@section('title', 'Alumnos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Lista de Alumnos</h4>
    <span class="badge bg-primary fs-6">{{ $alumnos->total() }} registros</span>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.alumnos.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-medium">Buscar</label>
                <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Matrícula, nombre, correo..."
                    value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-medium">Facultad</label>
                <select name="facultad" class="form-select form-select-sm">
                    <option value="">Todas</option>
                    @foreach($facultades as $f)
                        <option value="{{ $f->id_facultad }}" {{ request('facultad') == $f->id_facultad ? 'selected' : '' }}>
                            {{ $f->nombre_facultad }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-medium">Carrera</label>
                <select name="carrera" class="form-select form-select-sm">
                    <option value="">Todas</option>
                    @foreach($carreras as $c)
                        <option value="{{ $c->id_carrera }}" {{ request('carrera') == $c->id_carrera ? 'selected' : '' }}>
                            {{ $c->nombre_carrera }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-search"></i>
                </button>
                <a href="{{ route('admin.alumnos.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                    <i class="bi bi-x"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Matrícula</th>
                        <th>Nombre Completo</th>
                        <th>Carrera</th>
                        <th>Sexo</th>
                        <th>Correo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumnos as $alumno)
                        <tr>
                            <td class="ps-3 fw-semibold small">{{ $alumno->matricula_alum }}</td>
                            <td>
                                <div class="fw-medium">{{ $alumno->nombre_completo }}</div>
                            </td>
                            <td class="small text-muted">{{ $alumno->carrera?->nombre_carrera ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $alumno->sexo === 'Masculino' ? 'bg-info' : 'bg-pink' }}" style="{{ $alumno->sexo === 'Femenino' ? 'background:#e83e8c!important' : '' }}">
                                    {{ $alumno->sexo ?? '—' }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $alumno->correo_alum }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.alumnos.show', $alumno->matricula_alum) }}" class="btn btn-outline-primary" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.alumnos.edit', $alumno->matricula_alum) }}" class="btn btn-outline-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.reportes.pdf-alumno', $alumno->matricula_alum) }}" class="btn btn-outline-danger" title="PDF" target="_blank">
                                        <i class="bi bi-file-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                No se encontraron alumnos
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($alumnos->hasPages())
        <div class="card-footer bg-white border-top">
            {{ $alumnos->links() }}
        </div>
    @endif
</div>
@endsection
