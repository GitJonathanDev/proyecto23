<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class EncargadoController extends Controller
{
    public function index(Request $request)
   {
    $vendedores = Encargado::query();

    if ($request->filled('buscar')) {
        $vendedores->where('nombre', 'like', '%' . $request->buscar . '%');
    }
    $vendedores = $vendedores->paginate(10); 
    return Inertia::render('Encargado/Index', [
        'vendedores' => $vendedores
    ]);
    }
    public function create()
    {
        return Inertia::render('Encargado/Create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'carnetIdentidad' => 'required|digits_between:8,10',
            'nombre' => 'required|string|min:3|max:30',
            'apellidoPaterno' => 'required|string|min:3|max:30',
            'apellidoMaterno' => 'required|string|min:3|max:30',
            'sexo' => 'required|string',
            'edad' => 'required|integer|min:8|max:100',
            'telefono' => 'required|digits_between:8,10',
            'nombreUsuario' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Create the Vendedor
        Vendedor::create($validated);

        return redirect()->route('vendedor.index')->with('success', 'Vendedor registrado correctamente');
    }
    public function edit(Vendedor $vendedor)
    {
        return Inertia::render('Encargado/Edit', [
            'vendedor' => $vendedor,
        ]);
    }
    public function update(Request $request, Vendedor $vendedor)
    {
        // Validación de los datos
        $validated = $request->validate([
            'carnetIdentidad' => 'required|string|max:10|min:8|unique:vendedores,carnet_identidad,' . $vendedor->id,
            'nombre' => 'required|string|max:255|min:3',
            'apellidoPaterno' => 'required|string|max:255|min:3',
            'apellidoMaterno' => 'required|string|max:255|min:3',
            'sexo' => 'required|string',
            'edad' => 'required|integer|min:8|max:100',
            'telefono' => 'required|string|max:10|min:8',
            'nombreUsuario' => 'required|string|min:3|unique:vendedores,nombre_usuario,' . $vendedor->id,
            'email' => 'required|email|unique:vendedores,email,' . $vendedor->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Actualizar los datos del vendedor
        $vendedor->update([
            'carnet_identidad' => $validated['carnetIdentidad'],
            'nombre' => $validated['nombre'],
            'apellido_paterno' => $validated['apellidoPaterno'],
            'apellido_materno' => $validated['apellidoMaterno'],
            'sexo' => $validated['sexo'],
            'edad' => $validated['edad'],
            'telefono' => $validated['telefono'],
            'nombre_usuario' => $validated['nombreUsuario'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $vendedor->password, // Solo actualizar si es proporcionada
        ]);

        return Inertia::render('Encargado/Edit', [
            'vendedor' => $vendedor,
            'sessionSuccess' => 'Vendedor actualizado correctamente.',
        ]);
    }
}
