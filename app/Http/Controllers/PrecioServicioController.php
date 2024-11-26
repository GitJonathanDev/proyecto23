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
            ->paginate(5);

        return Inertia::render('PrecioServicio/Index', [
            'preciosServicio' => $preciosServicio,
            'criterio' => $criterio,
            'buscar' => $buscar,
        ]);
    }
    public function create()
    {
        $servicios = Servicio::all();
        $tiposRegistrados = [];
        foreach ($servicios as $servicio) {
            $tiposRegistrados[$servicio->codServicio] = PrecioServicio::where('codServicioF', $servicio->codServicio)
                ->distinct('tipo')
                ->pluck('tipo')
                ->toArray();
        }
        $tiposDisponibles = ['Diario', 'Mensual', 'Anual'];
        return Inertia::render('PrecioServicio/Create', [
            'servicios' => $servicios,
            'tiposRegistrados' => $tiposRegistrados,  // Tipos registrados por servicio
            'tiposDisponibles' => $tiposDisponibles,  // Tipos disponibles globales
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'codServicioF' => 'required|exists:servicio,codServicio',  
            'tipo' => 'required|string|max:255',  
            'precio' => 'required|numeric|min:0',
        ]);
        $existingPrecioServicio = PrecioServicio::where('codServicioF', $request->codServicioF)
                                                 ->where('tipo', $request->tipo)
                                                 ->first();

        if ($existingPrecioServicio) {
            return redirect()->back()->withInput()->withErrors(['tipo' => 'Ya existe un precio de servicio con este tipo para el servicio seleccionado.']);
        }
        PrecioServicio::create([
            'codServicioF' => $request->codServicioF,
            'tipo' => $request->tipo,
            'precio' => $request->precio,
        ]);
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio registrado exitosamente.');
    }

    public function edit($codPrecioServicio)
    {
        $precioServicio = PrecioServicio::findOrFail($codPrecioServicio);
        $servicios = Servicio::all();

        $tiposRegistrados = PrecioServicio::where('codServicioF', $precioServicio->codServicioF)
                                           ->where('codPrecioServicio', '!=', $precioServicio->codPrecioServicio)
                                           ->distinct('tipo')
                                           ->pluck('tipo')
                                           ->toArray();

        $tiposDisponibles = ['Diario', 'Mensual', 'Anual'];
        $tiposDisponibles = array_diff($tiposDisponibles, $tiposRegistrados);

        return Inertia::render('PrecioServicio/Edit', [
            'precioServicio' => $precioServicio,
            'servicios' => $servicios,
            'tiposDisponibles' => $tiposDisponibles,
        ]);
    }
    public function update(Request $request, $codPrecioServicio)
    {
        $request->validate([
            'tipo' => 'required',
            'precio' => 'required|numeric',
        ]);

        $precioServicio = PrecioServicio::findOrFail($codPrecioServicio);

        if ($request->tipo !== $precioServicio->tipo) {
            $existingPrecioServicio = PrecioServicio::where('tipo', $request->tipo)
                                                    ->where('codServicioF', $request->codServicioF)
                                                    ->first();

            if ($existingPrecioServicio) {
                return redirect()->back()->withInput()->withErrors(['tipo' => 'Ya existe un precio de servicio con este tipo para el servicio seleccionado.']);
            }
        }

        $precioServicio->update([
            'tipo' => $request->tipo,
            'precio' => $request->precio,
            'codServicioF' => $request->codServicio,
        ]);
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio actualizado exitosamente.');
    }
    public function destroy($id)
    {
        $precioServicio = PrecioServicio::findOrFail($id);
        $precioServicio->delete();
        return redirect()->route('precioServicio.index')->with('success', 'Precio de servicio eliminado exitosamente.');
    }
}
