<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Inertia\Inertia;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $criterio = $request->input('criterio', 'nombre'); 
        $buscar = $request->input('buscar', '');
        $proveedores = Proveedor::where($criterio, 'like', '%' . $buscar . '%')
            ->paginate(10);

        return Inertia::render('Proveedor/Index', [
            'proveedores' => $proveedores
        ]);
    }
    public function create()
    {
        return Inertia::render('Proveedor/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codProveedor' => 'required',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
        ]);
        Proveedor::create($request->all());
        return redirect()->route('proveedor.index')->with('success', 'Proveedor registrado exitosamente.');
    }
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return Inertia::render('Proveedor/Edit', [
            'proveedor' => $proveedor
        ]);
    }

    /**
     * Actualiza un proveedor en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|max:10',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedor.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Elimina un proveedor de la base de datos.
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedor.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
