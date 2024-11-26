<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        // Filtrado de búsqueda por nombre
        $criterio = $request->input('criterio', 'nombre');
        $buscar = $request->input('buscar');
    
        $categorias = Categoria::query()
            ->when($buscar, function ($query) use ($criterio, $buscar) {
                return $query->where($criterio, 'like', "%$buscar%");
            })
            ->paginate(10);
    
        // Se pasa el mensaje de éxito junto con las categorías
        return Inertia::render('Categoria/Index', [
            'categorias' => $categorias,
            'success' => session('success'),  // Se pasa el mensaje de éxito desde la sesión
        ]);
    }
    
    public function create()
    {
        return Inertia::render('Categoria/Create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
    ]);

    Categoria::create($request->all());

    // Después de crear, redirige a la vista de index con el mensaje de éxito
    return redirect()->route('categoria.index')->with('success', 'Categoría registrada correctamente.');
}


    public function edit($codCategoria)
    {
        $categoria = Categoria::findOrFail($codCategoria);

        return Inertia::render('Categoria/Edit', [
            'categoria' => $categoria,
            'errors' => session('errors') ?: [],
        ]);
    }

    public function update(Request $request, $codCategoria)
{
    $request->validate([
        'nombre' => 'required|min:4|max:50',
    ]);

    $categoria = Categoria::findOrFail($codCategoria);
    $categoria->update($request->only('nombre'));

    // Después de actualizar, redirige con el mensaje de éxito
    return redirect()->route('categoria.index')->with('success', 'Categoría actualizada correctamente.');
}


    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categoria.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
