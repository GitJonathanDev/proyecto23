<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TipoUsuario;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
    $usuarios = User::with('tipoUsuario') // Asegúrate de que el usuario tiene relación con el tipo de usuario
        ->when($request->criterio && $request->buscar, function ($query) use ($request) {
            return $query->where($request->criterio, 'like', '%' . $request->buscar . '%');
        })
        ->paginate(10);

    return Inertia::render('Usuario/index', [
        'usuarios' => $usuarios,
    ]);
    }
    public function create()
    {
        // Obtener todos los tipos de usuario disponibles
        $tiposUsuario = TipoUsuario::all();

        // Retornar la vista con los tipos de usuario
        return Inertia::render('Usuario/create', [
            'tiposUsuario' => $tiposUsuario
        ]);
    }

    // Almacena el nuevo usuario
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'nombreUsuario' => 'required|string|min:4|max:255|unique:usuarios,nombreUsuario',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'codTipoUsuarioF' => 'required|exists:tipos_usuarios,codTipoUsuario',
        ]);

        // Si la validación falla, retornamos los errores con Inertia
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        // Crear el nuevo usuario
        $usuario = Usuario::create([
            'nombreUsuario' => $request->nombreUsuario,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptamos la contraseña
            'codTipoUsuarioF' => $request->codTipoUsuarioF, // Asociamos el tipo de usuario
        ]);

        // Redirigir al listado de usuarios con un mensaje de éxito
        return redirect()->route('usuario.index')->with('success', 'Usuario registrado exitosamente.');
    }
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $tiposUsuario = TipoUsuario::all();  // Obtener todos los tipos de usuario

        return Inertia::render('Usuario/edit', [
            'usuario' => $usuario,
            'tiposUsuario' => $tiposUsuario,
            'errors' => session('errors') ?? [],
        ]);
    }

    /**
     * Actualizar un usuario en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'nombreUsuario' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'password' => 'nullable|string|min:8',
            'codTipoUsuarioF' => 'required|exists:tipoUsuario,codTipoUsuario',
        ]);

        // Buscar al usuario que se va a actualizar
        $usuario = Usuario::findOrFail($id);

        // Si se proporciona una nueva contraseña, la hasheamos antes de actualizarla
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        // Actualizamos el usuario con los datos validados
        $usuario->update($validated);

        // Retornamos una respuesta JSON de éxito (para Vue con Inertia)
        return redirect()->route('usuario.index')->with('success', 'Usuario actualizado correctamente');
    }
    public function destroy($id)
    {
        // Buscar el usuario por ID
        $usuario = Usuario::findOrFail($id);

        // Eliminar el usuario
        $usuario->delete();

        // Retornar respuesta de éxito
        return redirect()->route('usuario.index')->with('success', 'Usuario eliminado correctamente.');
    }
}


