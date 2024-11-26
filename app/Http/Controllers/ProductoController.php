<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


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
            ->paginate(10);

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

        // Subir la imagen si está presente
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
        // Buscar el producto
        $producto = Producto::findOrFail($id);
    
        // Manejo de la imagen
        $newImageUrl = $producto->imagen_url; // Mantener la imagen actual por defecto
    
        if ($request->hasFile('imagen')) {
            // Subir la nueva imagen
            $file = $request->file('imagen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/uploads'), $fileName);
            $newImageUrl = $fileName;
    
            // Eliminar la imagen antigua si existe
            $oldImagePath = public_path('storage/uploads/' . $producto->imagen_url);
            if ($producto->imagen_url && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
    
        // Actualizar el producto
        $producto->update([
            'codProducto' => $request->codProducto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion ?? $producto->descripcion,
            'precio' => $request->precio,
            'codCategoriaF' => $request->codCategoriaF,
            'imagen_url' => $newImageUrl, // Actualizar con la nueva imagen si aplica
        ]);
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto actualizado con éxito.');
    }
    


public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        try {
            DB::beginTransaction(); // Inicia una transacción

            // Eliminar el producto primero
            $producto->delete();

            // Eliminar la imagen si existe
            if ($producto->imagen_url) {
                $imagePath = public_path('storage/uploads/' . $producto->imagen_url);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            DB::commit(); // Confirma la transacción
        } catch (\Exception $e) {
            DB::rollBack(); // Revierte la transacción en caso de error
            return redirect()->route('producto.index')
                             ->with('error', 'Hubo un problema al eliminar el producto. Por favor, inténtelo de nuevo.');
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto eliminado con éxito.');
    }


}
