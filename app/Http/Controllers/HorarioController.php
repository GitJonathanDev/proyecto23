<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HorarioController extends Controller
{
    /**
     * Mostrar una lista de los horarios.
     */
    public function index(Request $request)
    {
        // Lógica de búsqueda
        $buscar = $request->input('buscar');
        $criterio = $request->input('criterio', 'horaInicio'); 

        $horarios = Horario::when($buscar, function ($query) use ($buscar, $criterio) {
            return $query->where($criterio, 'like', '%' . $buscar . '%');
        })->paginate(10); 

        return Inertia::render('Horario/Index', [
            'horarios' => $horarios,
        ]);
    }
    public function create()
    {
        return Inertia::render('Horario/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i|after:horaInicio',
        ]);
        Horario::create($validated);
        return redirect()->route('horario.index')->with('success', 'Horario creado correctamente.');
    }

    /**
     * Mostrar el formulario para editar un horario.
     */
    public function edit($id)
    {
        // Obtener el horario para editar
        $horario = Horario::findOrFail($id);

        // Retornar la vista con el horario
        return Inertia::render('Horario/Edit', [
            'horario' => $horario,
        ]);
    }

    /**
     * Actualizar un horario.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'horaInicio' => 'required',
            'horaFin' => 'required',
        ]);
        $horario = Horario::findOrFail($id);
        $horario->update($validated);
        return redirect()->route('horario.index')->with('success', 'Horario actualizado correctamente.');
    }
    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();
        return redirect()->route('horario.index')->with('success', 'Horario eliminado correctamente.');
    }
}
