@extends('layouts.admin')
@section('title', 'Historial Datos Físicos')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.alumnos.show', $alumno->matricula_alum) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Historial Datos Físicos — {{ $alumno->nombre_completo }}</h4>
    <a href="{{ route('admin.datos-fisicos.create', $alumno->matricula_alum) }}" class="btn btn-primary btn-sm ms-auto">
        <i class="bi bi-plus me-1"></i>Nuevo Registro
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Fecha</th>
                        <th>Peso</th><th>Talla</th><th>IMC</th><th>Clasificación IMC</th>
                        <th>Glucosa</th><th>Colesterol</th><th>Triglicéridos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registros as $r)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $r->fecha->format('d/m/Y') }}</td>
                            <td>{{ $r->peso ?? '—' }} kg</td>
                            <td>{{ $r->talla ?? '—' }} m</td>
                            <td class="fw-semibold">{{ $r->imc ?? '—' }}</td>
                            <td>
                                @if($r->clasificacion_imc)
                                    @php
                                        $color = match($r->clasificacion_imc) {
                                            'Normal' => 'success',
                                            'Bajo peso' => 'info',
                                            'Sobrepeso' => 'warning',
                                            default => 'danger',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $r->clasificacion_imc }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $r->glucosa ?? '—' }}</td>
                            <td>{{ $r->colesterol ?? '—' }}</td>
                            <td>{{ $r->trigliceridos ?? '—' }}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('admin.datos-fisicos.destroy', $r->id) }}"
                                    onsubmit="return confirm('¿Eliminar este registro?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">Sin registros</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($registros->hasPages())
        <div class="card-footer bg-white">{{ $registros->links() }}</div>
    @endif
</div>
@endsection
