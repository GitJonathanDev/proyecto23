<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EncargadoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\PrecioServicioController;

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

    Route::prefix('categoria')->group(function () {
        Route::get('index', [CategoriaController::class, 'index'])->name('categoria.index');
        Route::get('index2', [CategoriaController::class, 'index2'])->name('categoria.index2');
        Route::get('create', [CategoriaController::class, 'create'])->name('categoria.create');
        Route::post('store', [CategoriaController::class, 'store'])->name('categoria.store');
        Route::get('edit/{codCategoria}', [CategoriaController::class, 'edit'])->name('categoria.edit');
        Route::put('update/{codCategoria}', [CategoriaController::class, 'update'])->name('categoria.update');
        Route::delete('eliminar/{codCategoria}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');
    });

    Route::prefix('proveedor')->group(function () {
        Route::get('index', [ProveedorController::class, 'index'])->name('proveedor.index');
        Route::get('create', [ProveedorController::class, 'create'])->name('proveedor.create');
        Route::post('store', [ProveedorController::class, 'store'])->name('proveedor.store');
        Route::get('edit/{codProveedor}', [ProveedorController::class, 'edit'])->name('proveedor.edit');
        Route::put('update/{codProveedor}', [ProveedorController::class, 'update'])->name('proveedor.update');
        Route::delete('eliminar/{codProveedor}', [ProveedorController::class, 'destroy'])->name('proveedor.destroy');
    });
    Route::prefix('producto')->group(function () {
        Route::get('index', [ProductoController::class, 'index'])->name('producto.index');
        Route::get('create', [ProductoController::class, 'create'])->name('producto.create');
        Route::post('store', [ProductoController::class, 'store'])->name('producto.store');
        Route::get('edit/{codProducto}', [ProductoController::class, 'edit'])->name('producto.edit');
        Route::put('update/{codProducto}', [ProductoController::class, 'update'])->name('producto.update');
        Route::delete('eliminar/{codProducto}', [ProductoController::class, 'destroy'])->name('producto.destroy');
        Route::get('buscar', [ProductoController::class, 'buscar'])->name('producto.buscar');
    });

    Route::prefix('horario')->group(function () {
        Route::get('index', [HorarioController::class, 'index'])->name('horario.index');
        Route::get('create', [HorarioController::class, 'create'])->name('horario.create');
        Route::post('store', [HorarioController::class, 'store'])->name('horario.store');
        Route::get('edit/{codHorario}', [HorarioController::class, 'edit'])->name('horario.edit');
        Route::put('update/{codHorario}', [HorarioController::class, 'update'])->name('horario.update');
        Route::delete('eliminar/{codHorario}', [HorarioController::class, 'destroy'])->name('horario.destroy');
    });

    // Gestionar servicio
    Route::prefix('servicio')->group(function () {
        Route::get('index', [ServicioController::class, 'index'])->name('servicio.index');
        Route::get('create', [ServicioController::class, 'create'])->name('servicio.create');
        Route::post('store', [ServicioController::class, 'store'])->name('servicio.store');
        Route::get('edit/{codServicio}', [ServicioController::class, 'edit'])->name('servicio.edit');
        Route::put('update/{codServicio}', [ServicioController::class, 'update'])->name('servicio.update');
        Route::delete('eliminar/{codServicio}', [ServicioController::class, 'destroy'])->name('servicio.destroy');
    });
    Route::prefix('precioServicio')->group(function () {
        Route::get('index', [PrecioServicioController::class, 'index'])->name('precioServicio.index');
        Route::get('create', [PrecioServicioController::class, 'create'])->name('precioServicio.create');
        Route::post('store', [PrecioServicioController::class, 'store'])->name('precioServicio.store');
        Route::get('edit/{codPrecioServicio}', [PrecioServicioController::class, 'edit'])->name('precioServicio.edit');
        Route::put('update/{codPrecioServicio}', [PrecioServicioController::class, 'update'])->name('precioServicio.update');
        Route::delete('eliminar/{codPrecioServicio}', [PrecioServicioController::class, 'destroy'])->name('precioServicio.destroy');
    });
    