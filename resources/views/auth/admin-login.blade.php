<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<body>
    <div class="container">
        <div class="header-bar">
            <h4>Sistema Integral De Salud</h4>
        </div>
        <img src="{{ asset('images/delfines.png') }}" alt="Logo" class="delfin-logo">

        @if(session('success'))
            <p style="color:green; font-size:14px;">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="input-container">
                <label>Ingrese Usuario:</label>
                <input type="text" placeholder="Usuario" name="usuario"
                    value="{{ old('usuario') }}" required>
                @error('usuario')
                    <p class="error-msg" id="usuarioError">{{ $message }}</p>
                @enderror
            </div>

            <div class="password-container">
                <label>Contraseña:</label>
                <input type="password" name="password" placeholder="Ingrese contraseña"
                    id="password" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
                @error('password')
                    <p class="error-msg" id="contraError">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">Ingresar al Sistema</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        }

        function hideErrorMessages() {
            var usuarioError = document.getElementById('usuarioError');
            var contraError = document.getElementById('contraError');
            var inputContainer = document.querySelector('.input-container');
            var passwordContainer = document.querySelector('.password-container');

            if (usuarioError) {
                inputContainer.classList.add('error-active');
                usuarioError.style.display = 'block';
                setTimeout(function () {
                    usuarioError.style.display = 'none';
                    inputContainer.classList.remove('error-active');
                }, 7000);
            }

            if (contraError) {
                passwordContainer.classList.add('error-active');
                contraError.style.display = 'block';
                setTimeout(function () {
                    contraError.style.display = 'none';
                    passwordContainer.classList.remove('error-active');
                }, 7000);
            }
        }

        window.onload = hideErrorMessages;
    </script>
</body>

</html>
