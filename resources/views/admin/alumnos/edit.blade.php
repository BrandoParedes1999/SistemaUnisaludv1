@extends('layouts.admin')
@section('title', 'Editar Alumno')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.alumnos.show', $alumno->matricula_alum) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Editar: {{ $alumno->nombre_completo }}</h4>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.alumnos.update', $alumno->matricula_alum) }}">
            @csrf @method('PATCH')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-medium">Nombres *</label>
                    <input type="text" name="nombres_alum" class="form-control @error('nombres_alum') is-invalid @enderror"
                        value="{{ old('nombres_alum', $alumno->nombres_alum) }}" required>
                    @error('nombres_alum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-medium">Apellido Paterno *</label>
                    <input type="text" name="ape_paterno_alum" class="form-control @error('ape_paterno_alum') is-invalid @enderror"
                        value="{{ old('ape_paterno_alum', $alumno->ape_paterno_alum) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-medium">Apellido Materno</label>
                    <input type="text" name="ape_materno_alum" class="form-control"
                        value="{{ old('ape_materno_alum', $alumno->ape_materno_alum) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Sexo *</label>
                    <select name="sexo" class="form-select @error('sexo') is-invalid @enderror" required>
                        <option value="Masculino" {{ old('sexo', $alumno->sexo) === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="Femenino" {{ old('sexo', $alumno->sexo) === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option value="Otro" {{ old('sexo', $alumno->sexo) === 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Correo *</label>
                    <input type="email" name="correo_alum" class="form-control @error('correo_alum') is-invalid @enderror"
                        value="{{ old('correo_alum', $alumno->correo_alum) }}" required>
                    @error('correo_alum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Fecha Nacimiento</label>
                    <input type="date" name="fe_nacimiento_alum" class="form-control"
                        value="{{ old('fe_nacimiento_alum', $alumno->fe_nacimiento_alum?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Tipo de Sangre</label>
                    <select name="tipo_sangre" class="form-select">
                        <option value="">—</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $ts)
                            <option {{ old('tipo_sangre', $alumno->tipo_sangre) === $ts ? 'selected' : '' }}>{{ $ts }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium">Facultad *</label>
                    <select name="id_facultad" class="form-select @error('id_facultad') is-invalid @enderror" required>
                        @foreach($facultades as $f)
                            <option value="{{ $f->id_facultad }}" {{ old('id_facultad', $alumno->id_facultad) == $f->id_facultad ? 'selected' : '' }}>
                                {{ $f->nombre_facultad }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium">Carrera *</label>
                    <select name="id_carrera" class="form-select @error('id_carrera') is-invalid @enderror" required>
                        @foreach($carreras as $c)
                            <option value="{{ $c->id_carrera }}" {{ old('id_carrera', $alumno->id_carrera) == $c->id_carrera ? 'selected' : '' }}>
                                {{ $c->nombre_carrera }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-medium">NSS</label>
                    <input type="text" name="nss" class="form-control" value="{{ old('nss', $alumno->nss) }}" maxlength="20">
                </div>
                <div class="col-md-8">
                    <label class="form-label small fw-medium">Contacto de Emergencia</label>
                    <input type="text" name="emergencia" class="form-control" value="{{ old('emergencia', $alumno->emergencia) }}" maxlength="200">
                </div>
                <div class="col-12">
                    <label class="form-label small fw-medium">Enfermedades/Notas</label>
                    <textarea name="enfermedades" class="form-control" rows="2">{{ old('enfermedades', $alumno->enfermedades) }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('admin.alumnos.show', $alumno->matricula_alum) }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Reset password -->
<div class="card mt-4">
    <div class="card-header bg-white">
        <h6 class="fw-semibold mb-0"><i class="bi bi-key me-2"></i>Restablecer Contraseña</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.alumnos.reset-password', $alumno->matricula_alum) }}" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-4">
                <label class="form-label small">Nueva Contraseña</label>
                <input type="password" name="nueva_password" class="form-control form-control-sm" required minlength="8">
            </div>
            <div class="col-md-4">
                <label class="form-label small">Confirmar Contraseña</label>
                <input type="password" name="nueva_password_confirmation" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-warning btn-sm">
                    <i class="bi bi-key me-1"></i>Restablecer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Danger zone -->
<div class="card mt-4 border-danger">
    <div class="card-header text-danger bg-white">
        <h6 class="fw-semibold mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Zona de Peligro</h6>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">Eliminar al alumno borrará todos sus datos permanentemente (datos físicos, evaluaciones, historial).</p>
        <form method="POST" action="{{ route('admin.alumnos.destroy', $alumno->matricula_alum) }}"
            onsubmit="return confirm('¿Seguro que deseas eliminar a {{ $alumno->nombre_completo }}? Esta acción no se puede deshacer.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="bi bi-trash me-1"></i>Eliminar Alumno
            </button>
        </form>
    </div>
</div>
@endsection
