<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro — Sistema Integral de Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f5f7fa; }
        .card { border: none; box-shadow: 0 4px 20px rgba(0,0,0,.08); border-radius: 12px; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <img src="{{ asset('images/delfines.png') }}" alt="Logo" style="height:50px" onerror="this.style.display='none'">
                <h4 class="fw-semibold mt-2">Registro de Estudiante</h4>
                <p class="text-muted">Sistema Integral de Salud</p>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('alumno.registro.post') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-medium small">Matrícula *</label>
                                <input type="text" name="matricula_alum" class="form-control @error('matricula_alum') is-invalid @enderror"
                                    value="{{ old('matricula_alum') }}" required maxlength="20">
                                @error('matricula_alum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-medium small">Nombres *</label>
                                <input type="text" name="nombres_alum" class="form-control @error('nombres_alum') is-invalid @enderror"
                                    value="{{ old('nombres_alum') }}" required>
                                @error('nombres_alum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Apellido Paterno *</label>
                                <input type="text" name="ape_paterno_alum" class="form-control @error('ape_paterno_alum') is-invalid @enderror"
                                    value="{{ old('ape_paterno_alum') }}" required>
                                @error('ape_paterno_alum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Apellido Materno</label>
                                <input type="text" name="ape_materno_alum" class="form-control @error('ape_materno_alum') is-invalid @enderror"
                                    value="{{ old('ape_materno_alum') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium small">Sexo *</label>
                                <select name="sexo" class="form-select @error('sexo') is-invalid @enderror" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Masculino" {{ old('sexo') === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ old('sexo') === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Otro" {{ old('sexo') === 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('sexo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium small">Fecha de Nacimiento *</label>
                                <input type="date" name="fe_nacimiento_alum" class="form-control @error('fe_nacimiento_alum') is-invalid @enderror"
                                    value="{{ old('fe_nacimiento_alum') }}" required>
                                @error('fe_nacimiento_alum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium small">Correo Electrónico *</label>
                                <input type="email" name="correo_alum" class="form-control @error('correo_alum') is-invalid @enderror"
                                    value="{{ old('correo_alum') }}" required>
                                @error('correo_alum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Facultad *</label>
                                <select name="id_facultad" id="selectFacultad" class="form-select @error('id_facultad') is-invalid @enderror" required>
                                    <option value="">Seleccionar facultad...</option>
                                    @foreach($facultades as $facultad)
                                        <option value="{{ $facultad->id_facultad }}" {{ old('id_facultad') == $facultad->id_facultad ? 'selected' : '' }}>
                                            {{ $facultad->nombre_facultad }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_facultad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Carrera *</label>
                                <select name="id_carrera" id="selectCarrera" class="form-select @error('id_carrera') is-invalid @enderror" required>
                                    <option value="">Seleccionar carrera...</option>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id_carrera }}"
                                            data-facultad="{{ $carrera->id_facultad }}"
                                            {{ old('id_carrera') == $carrera->id_carrera ? 'selected' : '' }}>
                                            {{ $carrera->nombre_carrera }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_carrera')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Contraseña *</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Mínimo 8 caracteres" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Confirmar Contraseña *</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repita la contraseña" required>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2 justify-content-end">
                            <a href="{{ route('alumno.login') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-check me-2"></i>Registrarme
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Filter careers by faculty
    document.getElementById('selectFacultad').addEventListener('change', function() {
        const facultadId = this.value;
        const carreraSelect = document.getElementById('selectCarrera');
        const options = carreraSelect.querySelectorAll('option[data-facultad]');
        options.forEach(opt => {
            opt.style.display = (!facultadId || opt.dataset.facultad === facultadId) ? '' : 'none';
        });
        carreraSelect.value = '';
    });
</script>
</body>
</html>
