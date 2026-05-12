@extends('layouts.admin')
@section('title', 'Registrar Datos Físicos')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.alumnos.show', $alumno->matricula_alum) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Datos Físicos — {{ $alumno->nombre_completo }}</h4>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.datos-fisicos.store', $alumno->matricula_alum) }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Fecha *</label>
                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                        value="{{ old('fecha', now()->toDateString()) }}" required>
                    @error('fecha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Peso (kg) *</label>
                    <input type="number" name="peso" step="0.01" class="form-control @error('peso') is-invalid @enderror"
                        value="{{ old('peso') }}" required min="1" max="300">
                    @error('peso')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Talla (m) *</label>
                    <input type="number" name="talla" step="0.01" class="form-control @error('talla') is-invalid @enderror"
                        value="{{ old('talla') }}" required min="0.5" max="2.5" placeholder="Ej: 1.70">
                    @error('talla')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Cintura (cm)</label>
                    <input type="number" name="cintura" step="0.1" class="form-control" value="{{ old('cintura') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Cadera (cm)</label>
                    <input type="number" name="cadera" step="0.1" class="form-control" value="{{ old('cadera') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Glucosa (mg/dL)</label>
                    <input type="number" name="glucosa" step="0.1" class="form-control" value="{{ old('glucosa') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Triglicéridos (mg/dL)</label>
                    <input type="number" name="trigliceridos" step="0.1" class="form-control" value="{{ old('trigliceridos') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Colesterol (mg/dL)</label>
                    <input type="number" name="colesterol" step="0.1" class="form-control" value="{{ old('colesterol') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Tensión Arterial</label>
                    <input type="text" name="tension_arterial" class="form-control" value="{{ old('tension_arterial') }}" placeholder="Ej: 120/80">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">% Masa Grasa</label>
                    <input type="number" name="porcentaje_masa_grasa" step="0.1" class="form-control" value="{{ old('porcentaje_masa_grasa') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Agua Total (%)</label>
                    <input type="number" name="agua_total" step="0.1" class="form-control" value="{{ old('agua_total') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Masa Muscular (kg)</label>
                    <input type="number" name="masa_muscular" step="0.1" class="form-control" value="{{ old('masa_muscular') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Masa Ósea (kg)</label>
                    <input type="number" name="masa_osea" step="0.01" class="form-control" value="{{ old('masa_osea') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Grasa Visceral</label>
                    <input type="number" name="grasa_visceral" step="0.1" class="form-control" value="{{ old('grasa_visceral') }}">
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('admin.alumnos.show', $alumno->matricula_alum) }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Guardar Datos
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
