<?php

namespace App\Http\Controllers;

use App\Models\PrecioServicio;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrecioServicioController extends Controller
{
    public function index(Request $request)
    {
        $criterio = $request->input('criterio', 'tipo');
        $buscar = $request->input('buscar', '');

        $preciosServicio = PrecioServicio::with('servicio')
            ->when($criterio == 'tipo', function ($query) use ($buscar) {
                return $query->where('tipo', 'like', '%' . $buscar . '%');
            })
            ->when($criterio == 'precio', function ($query) use ($buscar) {
                return $query->where('precio', 'like', '%' . $buscar . '%');
            })
            ->paginate(10);

        return Inertia::render('PrecioServicio/Index', [
            'preciosServicio' => $preciosServicio,
            'criterio' => $criterio,
            'buscar' => $buscar,
        ]);
    }
    public function create()
    {
        $servicios = Servicio::all(); // Obtener todos los servicios
        $tiposRegistrados = PrecioServicio::groupBy('codServicio')->pluck('tipo', 'codServicio'); // Tipos registrados por servicio
        $tiposDisponibles = ['Diario', 'Mensual', 'Anual']; // Tipos de servicio disponibles

        return Inertia::render('PrecioServicio/Create', [
            'servicios' => $servicios,
            'tiposRegistrados' => $tiposRegistrados,
            'tiposDisponibles' => $tiposDisponibles,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'codServicio' => 'required|exists:servicio,codServicio', 
        ]);
        PrecioServicio::create([
            'tipo' => $request->tipo,
            'precio' => $request->precio,
            'codServicio' => $request->codServicio,
        ]);
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio registrado exitosamente.');
    }
    public function edit($id)
    {
        // Obtener el precio de servicio a editar
        $precioServicio = PrecioServicio::findOrFail($id);

        // Obtener la lista de servicios disponibles para asociar
        $servicios = Servicio::all();

        return Inertia::render('PrecioServicio/Edit', [
            'precioServicio' => $precioServicio,
            'servicios' => $servicios
        ]);
    }

    /**
     * Actualiza el precio de servicio existente.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'tipo' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'codServicio' => 'required|exists:servicios,codServicio',
        ]);

        // Obtener el precio de servicio y actualizarlo
        $precioServicio = PrecioServicio::findOrFail($id);
        $precioServicio->update([
            'tipo' => $request->tipo,
            'precio' => $request->precio,
            'codServicio' => $request->codServicio,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio actualizado exitosamente.');
    }

    /**
     * Elimina un precio de servicio.
     */
    public function destroy($id)
    {
        // Obtener el precio de servicio y eliminarlo
        $precioServicio = PrecioServicio::findOrFail($id);
        $precioServicio->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio eliminado exitosamente.');
    }
}
