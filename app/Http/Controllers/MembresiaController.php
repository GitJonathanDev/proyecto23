<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use App\Models\DetalleMembresia;
use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Encargado;
use App\Models\Pago;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator; 
use Carbon\Carbon;

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
        $membresia = Membresia::all();
        $encargado = Encargado::where('carnetIdentidad', '14623330')->first();
        $clientes = Cliente::all();
        $encargados = Encargado::all();
        $servicios = Servicio::with('precios', 'horario')->get();

        return Inertia::render('Membresia/Create', [
            'servicios' => $servicios,
            'clientes' => $clientes,
            'encargado' => $encargado, 
            'membresia' => $membresia,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'codClienteF' => 'required|exists:cliente,carnetIdentidad',
        ]);
        $montoTotal = 0;
        $detalles = [];
        $pago = Pago::create([
            'monto' => $montoTotal,
            'fechaPago' => now()->toDateString(),
            'codClienteF' => $request->codClienteF,
        ]);

        $codEncargadoF = 14623330; 
        $membresia = Membresia::create([
            'descripcion' => $request->descripcion,
            'precioTotal' => $montoTotal,
            'codClienteF' => $request->codClienteF,
            'codEncargadoF' => $codEncargadoF,
            'codPagoF' => $pago->codPago,
        ]);
        foreach ($request->subTotal as $index => $subtotal) {
            $montoTotal += (float)$subtotal;
            DetalleMembresia::create([
                'fechaInicio' => $request->fechaInicio,
                'fechaFin' => $request->fechaFin,
                'subTotal' => $subtotal,
                'tipo' => $request->tipoServicioF, 
                'codMembresia' => $membresia->codMembresia,
                'codServicio' => $request->codServiciosF,
            ]);
        }
        
        return redirect()->route('membresia.index', $membresia->codMembresia);
    }



    public function show($id)
{
    $detalleMembresia = DetalleMembresia::with('membresia', 'servicio', 'servicio.horario')
                                        ->where('codMembresia', $id)
                                        ->get();

    return Inertia::render('Membresia/Detalle', [
        'detalleMembresia' => $detalleMembresia
    ]);
}
    public function destroy(Membresia $membresia)
    {
        $membresia->delete();
        return redirect()->route('membresia.index')->with('delete', 'Membresía eliminada exitosamente.');
    }
    // public function buscarCliente(Request $request)
    // {
    //     // Obtener el valor de la búsqueda
    //     $query = $request->get('query');

    //     // Realizar la búsqueda de clientes
    //     $clientes = Cliente::where('nombre', 'like', "%$query%")
    //         ->orWhere('apellidoPaterno', 'like', "%$query%")
    //         ->orWhere('carnetIdentidad', 'like', "%$query%")
    //         ->orWhere('apellidoMaterno', 'like', "%$query%")
    //         ->orWhere('telefono', 'like', "%$query%")
    //         ->get(['nombre', 'apellidoPaterno', 'apellidoMaterno', 'telefono', 'carnetIdentidad']);

    //     // Retornar la vista de Inertia con los datos
    //     return Inertia::render('Membresia/Buscar', [
    //         'clientes' => $clientes
    //     ]);
    // }
}
