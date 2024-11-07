<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Inertia\Inertia;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $criterio = $request->input('criterio', 'nombre'); // Por defecto buscar por 'nombre'
        $buscar = $request->input('buscar', '');

        // Obtener proveedores con paginación y filtro de búsqueda
        $proveedores = Proveedor::where($criterio, 'like', '%' . $buscar . '%')
            ->paginate(10);

        return Inertia::render('Proveedor/Index', [
            'proveedores' => $proveedores
        ]);
    }
}
