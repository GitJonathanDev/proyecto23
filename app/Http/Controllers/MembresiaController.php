<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use App\Models\Cliente;
use App\Models\Encargado;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MembresiaController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('buscar', '');
        $criterio = $request->input('criterio', 'descripcion');
        $membresias = Membresia::with('cliente', 'encargado')
            ->where($criterio, 'like', '%' . $searchQuery . '%')
            ->paginate(5);

        return Inertia::render('Membresia/Index', [
            'membresias' => $membresias
        ]);
    }
    public function create()
    {
        $clientes = Cliente::all();
        $encargados = Encargado::all();

        return Inertia::render('Membresia/Create', [
            'clientes' => $clientes,
            'encargados' => $encargados
        ]);
    }
    public function show(Membresia $membresia)
    {
        $membresia->load('cliente', 'encargado');
        return Inertia::render('Membresias/Show', [
            'membresia' => $membresia
        ]);
    }
    public function destroy(Membresia $membresia)
    {
        $membresia->delete();
        return redirect()->route('membresia.index')->with('delete', 'Membresía eliminada exitosamente.');
    }
}
