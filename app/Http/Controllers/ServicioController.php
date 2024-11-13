<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use \Models\PrecioServicio;
use App\Models\Horario;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        // Definir los criterios de búsqueda
        $criterio = $request->input('criterio', 'nombre'); // Predeterminado 'nombre'
        $buscar = $request->input('buscar');

        // Filtrar los servicios según el criterio de búsqueda
        $query = Servicio::query();

        if ($buscar) {
            if ($criterio === 'nombre') {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            } elseif ($criterio === 'descripcion') {
                $query->where('descripcion', 'like', '%' . $buscar . '%');
            }
        }

        // Obtener los servicios con paginación (10 por página)
        $servicios = $query->paginate(10);

        // Retornar la vista con los servicios
        return Inertia::render('Servicio/Index', [
            'servicios' => $servicios,
        ]);
    }
    public function create()
    {
        // Obtener la lista de horarios disponibles
        $horarios = Horario::all(); // O lo que sea apropiado para obtener los horarios

        // Retornar la vista con la lista de horarios
        return Inertia::render('Servicio/Create', [
            'horarios' => $horarios,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
        ]);

        // Crear un nuevo servicio
        Servicio::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'codHorarioF' => $request->input('codHorarioF'),
        ]);

        return redirect()->route('servicio.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        $horarios = Horario::all();
        return Inertia::render('Servicio/Edit', [
            'servicio' => $servicio,
            'horarios' => $horarios,
            'errors' => session('errors') ?? [], 
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|min:3|max:150',
            'descripcion' => 'required|string',
            'codHorarioF' => 'required|exists:horario,codHorario',
        ]);
        $servicio = Servicio::findOrFail($id);
        $servicio->update([
            'nombre' => $validatedData['nombre'],
            'descripcion' => $validatedData['descripcion'],
            'codHorarioF' => $validatedData['codHorarioF'],
        ]);
        return Redirect()->route('servicio.index')->with('success', 'El servicio fue actualizado correctamente.');
    }
    public function destroy(Servicio $servicio)
    {
        // Eliminar el servicio
        $servicio->delete();

        return redirect()->route('servicio.index')->with('success', 'Servicio eliminado exitosamente.');
    }
    public function buscar(Request $request)
    {
        $searchTerm = $request->query('search');
        
        $servicios = Servicio::with('precios', 'horario') // Asegúrate de incluir las relaciones de precios y horario
                            ->where('nombre', 'like', '%' . $searchTerm . '%')
                            ->orWhere('descripcion', 'like', '%' . $searchTerm . '%')
                            ->get();
        
        return response()->json($servicios);
    }
    public function servicios()
    {
        try {
            $servicios = Servicio::with(['precios', 'horario'])->get();
            return response()->json($servicios);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => 'Error al cargar los servicios: ' . $e->getMessage()], 500);
        }
    }

}
