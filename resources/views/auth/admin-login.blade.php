<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso Administrador — Sistema Integral de Salud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #1a3a5c 0%, #0d6efd 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.2); overflow: hidden; }
        .login-header { background: linear-gradient(135deg, #1a3a5c, #0d6efd); padding: 2rem; text-align: center; color: #fff; }
        .login-header img { height: 60px; margin-bottom: 1rem; }
        .form-control:focus { border-color: #1a3a5c; box-shadow: 0 0 0 .2rem rgba(26,58,92,.25); }
        .btn-login { background: linear-gradient(135deg, #1a3a5c, #0d6efd); border: none; padding: .75rem; font-weight: 600; }
        .btn-login:hover { opacity: .9; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="login-card">
                <div class="login-header">
                    <img src="{{ asset('images/delfines.png') }}" alt="Logo" onerror="this.style.display='none'">
                    <h5 class="fw-semibold mb-0">Sistema Integral de Salud</h5>
                    <small class="opacity-75">Acceso Administrador</small>
                </div>
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success small py-2">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium small">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror"
                                    placeholder="Ingrese usuario" value="{{ old('usuario') }}" required autofocus>
                            </div>
                            @error('usuario')
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
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="recordarme" id="recordarme">
                            <label class="form-check-label small" for="recordarme">Recordarme</label>
                        </div>

                        <button type="submit" class="btn btn-login btn-primary w-100 text-white">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar al Sistema
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('alumno.login') }}" class="text-muted small">
                            <i class="bi bi-arrow-left me-1"></i>Portal de Alumnos
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
