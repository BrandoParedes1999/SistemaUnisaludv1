@extends('layouts.admin')
@section('title', 'Credenciales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="bi bi-card-heading me-2 text-info"></i>Credenciales de Alumnos</h4>
    <a href="{{ route('admin.credenciales.generar-todas') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-download me-1"></i>Generar Todas (PDF)
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Matrícula</th>
                        <th>Nombre</th>
                        <th>Carrera</th>
                        <th class="text-center">Credencial</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumnos as $alumno)
                        <tr>
                            <td class="ps-3 fw-semibold small">{{ $alumno->matricula_alum }}</td>
                            <td>{{ $alumno->nombre_completo }}</td>
                            <td class="small text-muted">{{ $alumno->carrera?->nombre_carrera ?? '—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.credenciales.generar', $alumno->matricula_alum) }}" class="btn btn-sm btn-outline-info" target="_blank">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>Generar PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No hay alumnos registrados</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($alumnos->hasPages())
        <div class="card-footer bg-white">
            {{ $alumnos->links() }}
        </div>
    @endif
</div>
@endsection
