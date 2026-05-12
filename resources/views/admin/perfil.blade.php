@extends('layouts.admin')
@section('title', 'Mi Perfil')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-person-circle me-2"></i>Mi Perfil</h4>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body pt-4">
                @if($admin->foto)
                    <img src="{{ asset('storage/' . $admin->foto) }}" class="rounded-circle mb-3" style="width:90px;height:90px;object-fit:cover">
                @else
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width:90px;height:90px">
                        <i class="bi bi-person fs-1 text-white"></i>
                    </div>
                @endif
                <h5 class="fw-semibold">{{ $admin->nombre_completo }}</h5>
                <span class="badge bg-primary">{{ $admin->rol }}</span>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.perfil.update') }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Nombre(s)</label>
                        <input type="text" name="nombre_admi" class="form-control form-control-sm"
                            value="{{ old('nombre_admi', $admin->nombre_admi) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Apellidos</label>
                        <input type="text" name="apellidos_admi" class="form-control form-control-sm"
                            value="{{ old('apellidos_admi', $admin->apellidos_admi) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-medium">Foto de Perfil</label>
                        <input type="file" name="foto" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-save me-1"></i>Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="fw-semibold mb-0"><i class="bi bi-lock me-2"></i>Cambiar Contraseña</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.perfil.password') }}" class="row g-3">
                    @csrf @method('PATCH')
                    <div class="col-md-4">
                        <label class="form-label small fw-medium">Contraseña Actual</label>
                        <input type="password" name="password_actual"
                            class="form-control @error('password_actual') is-invalid @enderror" required>
                        @error('password_actual')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-medium">Nueva Contraseña</label>
                        <input type="password" name="nueva_password" class="form-control" required minlength="8">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-medium">Confirmar Nueva Contraseña</label>
                        <input type="password" name="nueva_password_confirmation" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-key me-1"></i>Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
