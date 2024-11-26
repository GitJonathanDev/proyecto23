<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TipoUsuario;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Hash;  


class UsuarioController extends Controller
{
    public function index(Request $request)
    {
    $usuarios = User::with('TipoUsuario')
        ->when($request->criterio && $request->buscar, function ($query) use ($request) {
            return $query->where($request->criterio, 'like', '%' . $request->buscar . '%');
        })
        ->paginate(4);

    return Inertia::render('Usuario/index', [
        'usuarios' => $usuarios,
    ]);
    }
    public function create()
    {
        $tiposUsuario = TipoUsuario::all();
        return Inertia::render('Usuario/create', [
            'tiposUsuario' => $tiposUsuario
        ]);
    }

    // Almacena el nuevo usuario
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreUsuario' => 'required|string|min:4|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'codTipoUsuarioF' => 'required|exists:TipoUsuario,codTipoUsuario',
        ]);

        // Si la validación falla, retornamos los errores con Inertia
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $usuario = User::create([
            'name' => $request->nombreUsuario,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'codTipoUsuarioF' => $request->codTipoUsuarioF, 
        ]);
        return redirect()->route('usuario.index')->with('success', 'Usuario registrado exitosamente.');
    }
    public function edit($codUsuario)
    {
        // Buscar el usuario con codUsuario en lugar de id
        $usuario = User::findOrFail($codUsuario);

        $tiposUsuario = TipoUsuario::all(); // Obtener todos los tipos de usuario

        return Inertia::render('Usuario/edit', [
            'usuario' => $usuario,
            'tiposUsuario' => $tiposUsuario,
            'errors' => session('errors') ?? [],
        ]);
    }

    public function update(Request $request, $codUsuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email', 
            'password' => 'nullable|string|min:8',
            'codTipoUsuarioF' => 'required|exists:TipoUsuario,codTipoUsuario',
        ]);

        // Aquí obtenemos el usuario usando 'codUsuario' en vez de 'id'
        $usuario = User::findOrFail($codUsuario);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        // Actualizamos el usuario
        $usuario->update($validated);

        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($codUsuario)
    {
        $usuario = User::findOrFail($codUsuario);
        $usuario->delete();
        return redirect()->route('usuario.index')->with('success', 'Usuario eliminado correctamente.');
    }
}


