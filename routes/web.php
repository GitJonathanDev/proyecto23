<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EncargadoController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::prefix('tipoUsuario')->group(function () {
    Route::get('index', [TipoUsuarioController::class, 'index'])->name('tipoUsuario.index');
    Route::get('create', [TipoUsuarioController::class, 'create'])->name('tipoUsuario.create');
    Route::post('store', [TipoUsuarioController::class, 'store'])->name('tipoUsuario.store');
    Route::get('edit/{codTipoUsuario}', [TipoUsuarioController::class, 'edit'])->name('tipoUsuario.edit');
    Route::put('update/{codTipoUsuario}', [TipoUsuarioController::class, 'update'])->name('tipoUsuario.update');
    Route::delete('eliminar/{codTipoUsuario}', [TipoUsuarioController::class, 'destroy'])->name('tipoUsuario.destroy');
    Route::get('buscar', [TipoUsuarioController::class, 'buscarClientes'])->name('tipoUsuario.buscar');
});

Route::prefix('usuario')->group(function () {
        Route::get('index', [UsuarioController::class, 'index'])->name('usuario.index');
        Route::get('create', [UsuarioController::class, 'create'])->name('usuario.create');
        Route::post('store', [UsuarioController::class, 'store'])->name('usuario.store');
        Route::get('edit/{codUsuario}', [UsuarioController::class, 'edit'])->name('usuario.edit');
        Route::put('update/{codUsuario}', [UsuarioController::class, 'update'])->name('usuario.update');
        Route::delete('eliminar/{codUsuario}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');
        Route::get('buscar', [UsuarioController::class, 'buscarClientes'])->name('usuario.buscar');
        Route::post('email-ya-existe', [UsuarioController::class, 'emailYaExiste'])->name('email-ya-existe');
    });
    Route::prefix('cliente')->group(function () {
        Route::get('index', [ClienteController::class, 'index'])->name('cliente.index');
        Route::get('create', [ClienteController::class, 'create'])->name('cliente.create');
        Route::post('store', [ClienteController::class, 'store'])->name('cliente.store');
        Route::get('edit/{carnetIdentidad}', [ClienteController::class, 'edit'])->name('cliente.edit');
        Route::put('update/{carnetIdentidad}', [ClienteController::class, 'update'])->name('cliente.update');
        Route::delete('eliminar/{carnetIdentidad}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
        Route::post('ci-ya-existe', [ClienteController::class, 'ciYaExiste'])->name('ci-ya-existe');
        Route::get('buscar', [ClienteController::class, 'index'])->name('clientes.buscar'); 
        Route::get('seleccionCliente/{carnetIdentidad}', [MembresiaController::class, 'seleccionCliente'])->name('cliente.seleccion');
    });

    Route::prefix('encargado')->group(function () {
        Route::get('index', [EncargadoController::class, 'index'])->name('encargado.index');
        Route::get('create', [EncargadoController::class, 'create'])->name('encargado.create');
        Route::post('store', [EncargadoController::class, 'store'])->name('encargado.store');
        Route::get('edit/{carnetIdentidad}', [EncargadoController::class, 'edit'])->name('encargado.edit');
        Route::put('update/{carnetIdentidad}', [EncargadoController::class, 'update'])->name('encargado.update');
        Route::delete('eliminar/{carnetIdentidad}', [EncargadoController::class, 'destroy'])->name('encargado.destroy');
        Route::post('ci-ya-existe', [EncargadoController::class, 'ciYaExiste'])->name('ci-ya-existes');
    });