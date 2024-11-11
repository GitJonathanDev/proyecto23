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

        $servicios = Servicio::all();
        $tiposRegistrados = PrecioServicio::select('codServicioF', 'tipo')
            ->get()
            ->groupBy('codServicioF');

        $tiposDisponibles = ['Diario', 'Mensual', 'Anual']; 
        return Inertia::render('PrecioServicio/Create', [
            'servicios' => $servicios,
            'tiposRegistrados' => $tiposRegistrados,
            'tiposDisponibles' => $tiposDisponibles,
            'errors' => session('errors') ?? [],
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'codServicioF' => 'required|exists:servicio,codServicio', 
        ]);
        PrecioServicio::create([
            'tipo' => $request->tipo,
            'precio' => $request->precio,
            'codServicioF' => $request->codServicioF,
        ]);
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio registrado exitosamente.');
    }
    public function edit($id)
    {
        $precioServicio = PrecioServicio::findOrFail($id);
        $servicios = Servicio::all(); 
        $tiposDisponibles = ['Diario', 'Mensual', 'Anual']; 
        return inertia('PrecioServicio/Edit', [
            'precioServicio' => $precioServicio,
            'servicios' => $servicios,
            'tiposDisponibles' => $tiposDisponibles,
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
            'codServicio' => 'required|exists:servicio,codServicio',
        ]);

        // Obtener el precio de servicio y actualizarlo
        $precioServicio = PrecioServicio::findOrFail($id);
        $precioServicio->update([
            'tipo' => $request->tipo,
            'precio' => $request->precio,
            'codServicioF' => $request->codServicio,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio actualizado exitosamente.');
    }
    public function destroy($id)
    {
        // Obtener el precio de servicio y eliminarlo
        $precioServicio = PrecioServicio::findOrFail($id);
        $precioServicio->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio eliminado exitosamente.');
    }
}
