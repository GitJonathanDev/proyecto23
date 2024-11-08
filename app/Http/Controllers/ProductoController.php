<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los parámetros de búsqueda y filtro
        $criterio = $request->get('criterio', 'nombre'); // Por defecto, se usa 'nombre' para la búsqueda
        $buscar = $request->get('buscar', '');

        // Filtramos los productos por el criterio y la búsqueda
        $productos = Producto::query()
            ->when($buscar, function ($query) use ($criterio, $buscar) {
                return $query->where($criterio, 'like', "%{$buscar}%");
            })
            ->with('categoria') // Eager load para la categoría relacionada
            ->paginate(10) // Paginamos 10 productos por página
            ->withQueryString(); // Mantiene los parámetros de la búsqueda en la URL

        // Retornar la respuesta Inertia con los datos de productos
        return Inertia::render('Producto/Index', [
            'productos' => $productos,
            'categorias' => Categoria::all(), // Enviamos todas las categorías para el formulario de creación
        ]);
    }

    public function create()
    {
        return Inertia::render('Producto/Create', [
            'categorias' => Categoria::all(),
        ]);
    }

    public function store(Request $request)
    {

        $imageUrl = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/uploads'), $fileName);
            $imageUrl = $fileName;
        }
        Producto::create([
            'codProducto' => $request->codProducto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => 0,
            'codCategoriaF' => $request->codCategoriaF,
            'imagen_url' => $imageUrl,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto creado con éxito.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return Inertia::render('Producto/Edit', [
            'producto' => $producto,
            'categorias' => Categoria::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        if ($request->hasFile('imagen')) {
            if ($producto->imagen_url) {
                $path = public_path('storage/uploads/' . $producto->imagen_url);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
    
            $file = $request->file('imagen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/uploads'), $fileName);
            $producto->imagen_url = $fileName;
        }
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'codCategoriaF' => $request->codCategoriaF,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->imagen_url) {
            \Storage::delete('app/public/uploads//' . $producto->imagen_url);
        }
        $producto->delete();
        return redirect()->route('producto.index')->with('success', 'Producto eliminado con éxito.');
    }
}
