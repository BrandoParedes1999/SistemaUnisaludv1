<?php

use App\Http\Controllers\Admin\AdminPerfilController;
use App\Http\Controllers\Admin\AlumnosController;
use App\Http\Controllers\Admin\CredencialesController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DatosFisicosController;
use App\Http\Controllers\Admin\ReportesController;
use App\Http\Controllers\Alumno\AlumnoPerfilController;
use App\Http\Controllers\Alumno\DassController;
use App\Http\Controllers\Alumno\DashboardController as AlumnoDashboard;
use App\Http\Controllers\Alumno\EstiloVidaController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AlumnoLoginController;
use App\Http\Controllers\Auth\AlumnoRegistroController;
use Illuminate\Support\Facades\Route;

// Redirect root to admin login
Route::get('/', fn() => redirect()->route('admin.login'));

// ──────────────────────────────────────────────
// ADMIN AUTH
// ──────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('auth.admin')->group(function () {
        Route::get('dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Perfil
        Route::get('perfil', [AdminPerfilController::class, 'show'])->name('perfil');
        Route::patch('perfil', [AdminPerfilController::class, 'update'])->name('perfil.update');
        Route::patch('perfil/password', [AdminPerfilController::class, 'cambiarPassword'])->name('perfil.password');

        // Alumnos
        Route::get('alumnos', [AlumnosController::class, 'index'])->name('alumnos.index');
        Route::get('alumnos/{matricula}', [AlumnosController::class, 'show'])->name('alumnos.show');
        Route::get('alumnos/{matricula}/editar', [AlumnosController::class, 'edit'])->name('alumnos.edit');
        Route::patch('alumnos/{matricula}', [AlumnosController::class, 'update'])->name('alumnos.update');
        Route::delete('alumnos/{matricula}', [AlumnosController::class, 'destroy'])->name('alumnos.destroy');
        Route::post('alumnos/{matricula}/reset-password', [AlumnosController::class, 'resetPassword'])->name('alumnos.reset-password');

        // Datos Físicos
        Route::get('alumnos/{matricula}/datos-fisicos/nuevo', [DatosFisicosController::class, 'create'])->name('datos-fisicos.create');
        Route::post('alumnos/{matricula}/datos-fisicos', [DatosFisicosController::class, 'store'])->name('datos-fisicos.store');
        Route::get('alumnos/{matricula}/datos-fisicos', [DatosFisicosController::class, 'historial'])->name('datos-fisicos.historial');
        Route::delete('datos-fisicos/{id}', [DatosFisicosController::class, 'destroy'])->name('datos-fisicos.destroy');

        // Reportes / Observatorio
        Route::prefix('reportes')->name('reportes.')->group(function () {
            Route::get('/', [ReportesController::class, 'index'])->name('index');
            Route::get('observatorio/dass', [ReportesController::class, 'observatorioDass'])->name('dass');
            Route::get('observatorio/datos-fisicos', [ReportesController::class, 'observatorioDatosFisicos'])->name('datos-fisicos');
            Route::get('observatorio/estilo-vida', [ReportesController::class, 'observatorioEstiloVida'])->name('estilo-vida');
            Route::get('pdf/{matricula}', [ReportesController::class, 'pdfAlumno'])->name('pdf-alumno');
            Route::get('exportar-csv', [ReportesController::class, 'exportarCSV'])->name('exportar-csv');
        });

        // Credenciales
        Route::prefix('credenciales')->name('credenciales.')->group(function () {
            Route::get('/', [CredencialesController::class, 'index'])->name('index');
            Route::get('{matricula}/generar', [CredencialesController::class, 'generar'])->name('generar');
            Route::get('generar-todas', [CredencialesController::class, 'generarTodas'])->name('generar-todas');
        });
    });
});

// ──────────────────────────────────────────────
// ALUMNO AUTH
// ──────────────────────────────────────────────
Route::prefix('alumno')->name('alumno.')->group(function () {
    Route::get('login', [AlumnoLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AlumnoLoginController::class, 'login'])->name('login.post');
    Route::post('logout', [AlumnoLoginController::class, 'logout'])->name('logout');
    Route::get('registro', [AlumnoRegistroController::class, 'showRegistroForm'])->name('registro');
    Route::post('registro', [AlumnoRegistroController::class, 'registro'])->name('registro.post');

    // Protected alumno routes
    Route::middleware('auth.alumno')->group(function () {
        Route::get('dashboard', [AlumnoDashboard::class, 'index'])->name('dashboard');

        // Perfil
        Route::get('perfil', [AlumnoPerfilController::class, 'show'])->name('perfil');
        Route::patch('perfil', [AlumnoPerfilController::class, 'update'])->name('perfil.update');
        Route::patch('perfil/password', [AlumnoPerfilController::class, 'cambiarPassword'])->name('perfil.password');

        // DASS-21
        Route::get('dass-21', [DassController::class, 'show'])->name('dass.formulario');
        Route::post('dass-21', [DassController::class, 'store'])->name('dass.store');
        Route::get('dass-21/resultados', [DassController::class, 'resultados'])->name('dass.resultados');

        // Estilo de vida (PEPS-I)
        Route::get('estilo-vida', [EstiloVidaController::class, 'show'])->name('estilo-vida.formulario');
        Route::post('estilo-vida', [EstiloVidaController::class, 'store'])->name('estilo-vida.store');
        Route::get('estilo-vida/resultados', [EstiloVidaController::class, 'resultados'])->name('estilo-vida.resultados');
    });
});
