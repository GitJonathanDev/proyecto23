<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EncargadoController extends Controller
{
    public function index(Request $request)
    {
        $vendedores = Encargado::query();

        if ($request->filled('buscar')) {
            $vendedores->where('nombre', 'like', '%' . $request->buscar . '%');
        }
        $vendedores = $vendedores->with('usuario')->paginate(10); 
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
            'carnetIdentidad' => 'required',
            'nombre' => 'required|string|min:3|max:30',
            'apellidoPaterno' => 'required|string|min:3|max:30',
            'apellidoMaterno' => 'required|string|min:3|max:30',
            'sexo' => 'required|string',
            'edad' => 'required|integer|min:8|max:70',
            'telefono' => 'required|min:8|max:10',
            'nombreUsuario' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        $tipoUsuario = 2;
        $user = User::create([
            'name' => $validated['nombreUsuario'], 
            'email' => $validated['email'],     
            'password' => bcrypt($validated['password']), 
            'codTipoUsuarioF' => $tipoUsuario,
        ]);
        $encargado = Encargado::create([
            'carnetIdentidad' => $validated['carnetIdentidad'],
            'nombre' => $validated['nombre'],
            'apellidoPaterno' => $validated['apellidoPaterno'],
            'apellidoMaterno' => $validated['apellidoMaterno'],
            'sexo' => $validated['sexo'],
            'edad' => $validated['edad'],
            'telefono' => $validated['telefono'],
            'codUsuarioF' => $user->codUsuario,
        ]);
        return redirect()->route('encargado.index')->with('success', 'Encargado registrado correctamente');
    }
    public function edit($id)
    {
        $vendedor = Encargado::findOrFail($id);
        return Inertia::render('Encargado/Edit', [
            'vendedor' => $vendedor,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos
        $validated = $request->validate([
            'carnetIdentidad' => 'required',
            'nombre' => 'required|string|max:255|min:3',
            'apellidoPaterno' => 'required|string|max:255|min:3',
            'apellidoMaterno' => 'required|string|max:255|min:3',
            'sexo' => 'required|string',
            'edad' => 'required|integer|min:8|max:100',
            'telefono' => 'required|max:10|min:8',
        ]);

        // Obtener el encargado por el ID
        $encargado = Encargado::findOrFail($id);

        // Actualizar los datos del encargado
        $encargado->update([
            'carnetIdentidad' => $validated['carnetIdentidad'],
            'nombre' => $validated['nombre'],
            'apellidoPaterno' => $validated['apellidoPaterno'],
            'apellidoMaterno' => $validated['apellidoMaterno'],
            'sexo' => $validated['sexo'],
            'edad' => $validated['edad'],
            'telefono' => $validated['telefono'],
        ]);

        // Redirigir con mensaje de éxito
        return Inertia::render('Encargado/Edit', [
            'vendedor' => $encargado,
            'sessionSuccess' => 'Encargado actualizado correctamente.',
        ]);
    }
    public function destroy($carnetIdentidad)
    {
        $vendedor = Encargado::where('carnetIdentidad', $carnetIdentidad)->first();
        if ($vendedor) {
            $vendedor->delete();
            return redirect()->route('encargado.index')->with('success', 'Encargado eliminado correctamente.');
        }
        return redirect()->route('encargado.index')->with('error', 'Encargado no encontrado.');
    }
}
