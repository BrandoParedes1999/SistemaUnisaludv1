@extends('layouts.alumno')
@section('title', 'Mi Perfil')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-person-circle me-2 text-primary"></i>Mi Perfil</h4>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body pt-4">
                @if($alumno->foto)
                    <img src="{{ asset('storage/' . $alumno->foto) }}" class="rounded-circle mb-3" style="width:90px;height:90px;object-fit:cover">
                @else
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width:90px;height:90px">
                        <i class="bi bi-person fs-1 text-white"></i>
                    </div>
                @endif
                <h5 class="fw-semibold">{{ $alumno->nombre_completo }}</h5>
                <p class="text-muted small">{{ $alumno->matricula_alum }}</p>

                <form method="POST" action="{{ route('alumno.perfil.update') }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Contacto de Emergencia</label>
                        <input type="text" name="emergencia" class="form-control form-control-sm" value="{{ old('emergencia', $alumno->emergencia) }}" maxlength="200">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Enfermedades/Notas</label>
                        <textarea name="enfermedades" class="form-control form-control-sm" rows="3">{{ old('enfermedades', $alumno->enfermedades) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-save me-1"></i>Guardar Cambios
                    </button>
                </form>
            </div>
        </div>

        <!-- Cambiar contraseña -->
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h6 class="fw-semibold mb-0"><i class="bi bi-lock me-2"></i>Cambiar Contraseña</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('alumno.perfil.password') }}">
                    @csrf @method('PATCH')
                    <div class="mb-2">
                        <input type="password" name="password_actual" class="form-control form-control-sm @error('password_actual') is-invalid @enderror" placeholder="Contraseña actual" required>
                        @error('password_actual')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-2">
                        <input type="password" name="nueva_password" class="form-control form-control-sm" placeholder="Nueva contraseña" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="nueva_password_confirmation" class="form-control form-control-sm" placeholder="Confirmar nueva contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-sm w-100">
                        <i class="bi bi-key me-1"></i>Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Datos Académicos</h6>
                <dl class="row small">
                    <dt class="col-5 text-muted">Facultad</dt>
                    <dd class="col-7">{{ $alumno->facultad?->nombre_facultad ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Carrera</dt>
                    <dd class="col-7">{{ $alumno->carrera?->nombre_carrera ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Generación</dt>
                    <dd class="col-7">{{ $alumno->generacion ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Fecha Ingreso</dt>
                    <dd class="col-7">{{ $alumno->fecha_ingreso?->format('d/m/Y') ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Correo</dt>
                    <dd class="col-7">{{ $alumno->correo_alum }}</dd>
                    <dt class="col-5 text-muted">Tipo de Sangre</dt>
                    <dd class="col-7">{{ $alumno->tipo_sangre ?? '—' }}</dd>
                    <dt class="col-5 text-muted">NSS</dt>
                    <dd class="col-7">{{ $alumno->nss ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
