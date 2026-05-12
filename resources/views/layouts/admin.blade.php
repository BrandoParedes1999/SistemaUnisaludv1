<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Sistema Integral de Salud</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('ico/logo_pequeno.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f8; }
        .sidebar { width: 260px; min-height: 100vh; background: linear-gradient(180deg, #1a3a5c 0%, #0d2340 100%); position: fixed; left: 0; top: 0; z-index: 1000; transition: all .3s; }
        .sidebar .nav-link { color: rgba(255,255,255,.75); padding: .65rem 1.25rem; border-radius: 8px; margin: 2px 10px; transition: all .2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.15); }
        .sidebar .nav-link i { width: 20px; }
        .main-content { margin-left: 260px; padding: 0; }
        .topbar { background: #fff; border-bottom: 1px solid #e0e7ef; padding: .75rem 1.5rem; position: sticky; top: 0; z-index: 900; }
        .sidebar-brand { padding: 1.25rem 1.25rem .75rem; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar-brand img { height: 40px; }
        .nav-section-title { font-size: .7rem; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,.4); padding: 1rem 1.25rem .25rem; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="sidebar-brand d-flex align-items-center gap-2">
        <img src="{{ asset('images/delfines.png') }}" alt="Logo" onerror="this.style.display='none'">
        <div>
            <div class="text-white fw-semibold small">Sistema Integral</div>
            <div class="text-white-50" style="font-size:.7rem">de Salud</div>
        </div>
    </div>

    <div class="pt-2 pb-3">
        <div class="nav-section-title">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <div class="nav-section-title">Alumnos</div>
        <a href="{{ route('admin.alumnos.index') }}" class="nav-link {{ request()->routeIs('admin.alumnos.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill me-2"></i> Lista de Alumnos
        </a>
        <a href="{{ route('admin.credenciales.index') }}" class="nav-link {{ request()->routeIs('admin.credenciales.*') ? 'active' : '' }}">
            <i class="bi bi-card-heading me-2"></i> Credenciales
        </a>

        <div class="nav-section-title">Observatorio</div>
        <a href="{{ route('admin.reportes.dass') }}" class="nav-link {{ request()->routeIs('admin.reportes.dass') ? 'active' : '' }}">
            <i class="bi bi-brain me-2"></i> DASS-21
        </a>
        <a href="{{ route('admin.reportes.datos-fisicos') }}" class="nav-link {{ request()->routeIs('admin.reportes.datos-fisicos') ? 'active' : '' }}">
            <i class="bi bi-activity me-2"></i> Datos Físicos
        </a>
        <a href="{{ route('admin.reportes.estilo-vida') }}" class="nav-link {{ request()->routeIs('admin.reportes.estilo-vida') ? 'active' : '' }}">
            <i class="bi bi-heart-pulse me-2"></i> Estilo de Vida
        </a>

        <div class="nav-section-title">Reportes</div>
        <a href="{{ route('admin.reportes.exportar-csv') }}" class="nav-link">
            <i class="bi bi-file-earmark-spreadsheet me-2"></i> Exportar CSV
        </a>

        <div class="nav-section-title">Cuenta</div>
        <a href="{{ route('admin.perfil') }}" class="nav-link {{ request()->routeIs('admin.perfil') ? 'active' : '' }}">
            <i class="bi bi-person-circle me-2"></i> Mi Perfil
        </a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link w-100 text-start border-0 p-0" style="color:rgba(255,255,255,.75)">
                <i class="bi bi-box-arrow-left me-2"></i> Cerrar Sesión
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar d-flex align-items-center justify-content-between">
        <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="d-flex align-items-center gap-3 ms-auto">
            <span class="text-muted small">
                <i class="bi bi-person me-1"></i>
                {{ Auth::guard('admin')->user()->nombre_completo }}
                <span class="badge bg-primary ms-1">{{ Auth::guard('admin')->user()->rol }}</span>
            </span>
        </div>
    </div>

    <div class="p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
