<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\TipoUsuario;
use Inertia\Inertia;
use App\Models\User;

class TipoUsuarioController extends Controller
{
    public function index(Request $request)
    {
        {
            // Obtener el valor de búsqueda si existe
            $buscar = $request->input('buscar', '');
            $criterio = $request->input('criterio', 'descripcion');
            
            // Filtrar los tipos de usuario según el criterio y la búsqueda
            $tipoUsuarios = TipoUsuario::when($buscar, function($query) use ($buscar, $criterio) {
                return $query->where($criterio, 'like', '%' . $buscar . '%');
            })->paginate(10); // Pagina los resultados
    
            // Pasar los datos a la vista con Inertia
            return Inertia::render('TipoUsuario/index', [
                'tipoUsuarios' => $tipoUsuarios,
                'criterio' => $criterio,
                'buscar' => $buscar,
            ]);
        }
    }

    public function create() {
        return Inertia::render('TipoUsuario/create');
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|min:3|max:255',
        ]);
        if ($validator->fails()) {
            return Inertia::render('TipoUsuario/create', [
                'errors' => $validator->errors(), 
                'descripcion' => $request->descripcion, 
            ]);
        }
        TipoUsuario::create($request->only('descripcion'));

        return redirect()->route('tipoUsuario.index')->with('success', 'Tipo de usuario registrado con éxito');
    }
    public function edit($codTipoUsuario)
    {
        // Recuperamos el tipo de usuario desde la base de datos
        $tipoUsuario = TipoUsuario::findOrFail($codTipoUsuario);

        // Retornamos a la vista de edición con los datos del tipo de usuario
        return Inertia::render('TipoUsuario/edit', [
            'tipoUsuario' => $tipoUsuario,
            'errors' => session('errors') ? session('errors')->getMessages() : [],
        ]);
    }
    public function update(Request $request, $codTipoUsuario)
    {
        // Validación de los datos
        $validated = $request->validate([
            'descripcion' => 'required|string|min:3|max:20',
        ]);

        // Recuperamos el tipo de usuario a actualizar
        $tipoUsuario = TipoUsuario::findOrFail($codTipoUsuario);

        // Actualizamos el tipo de usuario con los nuevos valores
        $tipoUsuario->update([
            'descripcion' => $validated['descripcion'],
        ]);

        // Retornamos la respuesta a Vue con un mensaje de éxito
        return redirect()->route('tipoUsuario.index', $tipoUsuario->codTipoUsuario)
                         ->with('success', 'Tipo de usuario actualizado con éxito.');
    }
    public function destroy($codTipoUsuario)
    {
        try {
            // Buscar el tipo de usuario por su código
            $tipoUsuario = TipoUsuario::findOrFail($codTipoUsuario);

            // Eliminar el tipo de usuario
            $tipoUsuario->delete();

            // Agregar el mensaje flash a la sesión
            session()->flash('success', 'Tipo de usuario eliminado con éxito.');

            // Redirigir usando Inertia para que maneje la respuesta correctamente
            return Inertia::location(route('tipoUsuario.index'));

        } catch (QueryException $e) {
            // Agregar mensaje de error en caso de relaciones
            session()->flash('error', 'No se puede eliminar el tipo de usuario porque tiene registros relacionados.');

            // Redirigir con Inertia también
            return Inertia::location(route('tipoUsuario.index'));
        }
    }
}
