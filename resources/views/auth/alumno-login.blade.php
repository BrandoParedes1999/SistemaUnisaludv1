<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Alumno — Sistema Integral de Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #0d6efd 0%, #198754 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.2); overflow: hidden; }
        .login-header { background: linear-gradient(135deg, #0d6efd, #198754); padding: 2rem; text-align: center; color: #fff; }
        .btn-login { background: linear-gradient(135deg, #0d6efd, #198754); border: none; padding: .75rem; font-weight: 600; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="login-card">
                <div class="login-header">
                    <img src="{{ asset('images/delfines.png') }}" alt="Logo" style="height:60px;margin-bottom:1rem" onerror="this.style.display='none'">
                    <h5 class="fw-semibold mb-0">Sistema Integral de Salud</h5>
                    <small class="opacity-75">Portal del Estudiante</small>
                </div>
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success small py-2">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('alumno.login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium small">Matrícula</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" name="matricula" class="form-control @error('matricula') is-invalid @enderror"
                                    placeholder="Ej: 20010001" value="{{ old('matricula') }}" required autofocus>
                            </div>
                            @error('matricula')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium small">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Ingrese contraseña" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login btn-primary w-100 text-white">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('alumno.registro') }}" class="small text-primary">
                            <i class="bi bi-person-plus me-1"></i>¿No tienes cuenta? Regístrate
                        </a>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('admin.login') }}" class="text-muted small">
                            <i class="bi bi-shield me-1"></i>Acceso Administrador
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }
</script>
</body>
</html>
