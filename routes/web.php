<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VentaController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ── Rutas públicas ─────────────────────────────────────────
Route::get('/', fn() => view('public.inicio'))->name('inicio');
Route::get('/quienes-somos', fn() => view('public.quienes-somos'))->name('quienes-somos');
Route::get('/mision-vision', fn() => view('public.mision-vision'))->name('mision-vision');
Route::get('/contacto', fn() => view('public.contacto'))->name('contacto');

// ── Autenticación manual ───────────────────────────────────
Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');


// ── 2FA ───────────────────────────────────────────────────
Route::get('/2fa',  [LoginController::class, 'show2fa'])->name('2fa.show');
Route::post('/2fa', [LoginController::class, 'verify2fa'])->name('2fa.verify');


// ── Rutas protegidas ───────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboards
    Route::get('/dashboard/cliente',       [DashboardController::class, 'cliente'])
        ->name('cliente.dashboard');
    Route::get('/dashboard/gerente',       [DashboardController::class, 'gerente'])
        ->name('gerente.dashboard');
    Route::get('/dashboard/administrador', [DashboardController::class, 'administrador'])
        ->name('admin.dashboard');
    Route::get('/ventas/{venta}/ticket', [VentaController::class, 'ticket'])
        ->name('ventas.ticket');

    Route::patch('/ventas/{venta}/validar', [VentaController::class, 'validar'])
        ->name('ventas.validar');

    // CRUD usuarios
    Route::resource('usuarios', UserController::class);

    // CRUD productos, categorias, ventas
    Route::resource('productos',  ProductoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('ventas',     VentaController::class);
});
