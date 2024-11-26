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
use Illuminate\Support\Facades\Auth;

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
        $encargado = Encargado::where('carnetIdentidad', '12454859')->first();
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
    // Validación de los datos enviados
    $request->validate([
        'descripcion' => 'required|string',
        'codClienteF' => 'required|exists:cliente,carnetIdentidad',
        'servicios' => 'required|array|min:1', // Validación para el array de servicios
        'servicios.*.codServicio' => 'required|exists:servicio,codServicio', // Validación para cada servicio individual
        'servicios.*.tipoServicioF' => 'required|string',  // Asegurando que cada servicio tenga el tipo de servicio
        'servicios.*.fechaFin' => 'required|date', // Validación para la fecha de fin
        'servicios.*.subTotal' => 'required|numeric', // Validación para el subtotal
    ]);

    // Crear pago
    $montoTotal = $request->precioTotal;
    $pago = Pago::create([
        'monto' => $montoTotal,
        'fechaPago' => now()->toDateString(),
        'codClienteF' => $request->codClienteF,
    ]);

    // Crear membresía
    $codEncargadoF = 12454859;
    $membresia = Membresia::create([
        'descripcion' => $request->descripcion,
        'precioTotal' => $montoTotal,
        'codClienteF' => $request->codClienteF,
        'codEncargadoF' => $codEncargadoF,
        'codPagoF' => $pago->codPago,
    ]);

    // Crear detalles de membresía para cada servicio seleccionado
    foreach ($request->servicios as $servicio) {
        DetalleMembresia::create([
            'fechaInicio' => $servicio['fechaInicio'],
            'fechaFin' => $servicio['fechaFin'],
            'subTotal' => $servicio['subTotal'],
            'tipo' => $servicio['tipoServicioF'],
            'codMembresia' => $membresia->codMembresia,
            'codServicio' => $servicio['codServicio'],
        ]);
    }

    return redirect()->route('membresia.index', $membresia->codMembresia);
}

    private function calcularFechaFin($servicios)
    {
        $fechaFin = Carbon::now();

        foreach ($servicios as $servicio) {
            $fechaFinServicio = Carbon::parse($servicio['fechaFin']);
            if ($fechaFinServicio > $fechaFin) {
                $fechaFin = $fechaFinServicio;
            }
        }

        return $fechaFin->toDateString();
    }

    private function calcularTotalServicios($servicios)
    {
        $total = 0;
        foreach ($servicios as $servicio) {
            $total += $servicio['precio'];
        }

        return $total;
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
public function mostrarMembresias()
{
    // Obtener el cliente basado en el usuario autenticado
    $cliente = Cliente::where('codUsuarioF', Auth::id())->firstOrFail();

    // Obtener las membresías asociadas al cliente
    $membresias = Membresia::with([
        'detalles.servicio',
        'detalles.servicio.horario' // Obtener horario de servicio
    ])
    ->where('codClienteF', $cliente->carnetIdentidad)
    ->get();

    // Para cada detalle de membresía, calculamos el estado
    foreach ($membresias as $membresia) {
        foreach ($membresia->detalles as $detalle) {
            // Calculamos el estado
            $detalle->estado = $this->calcularEstado($detalle->fechaFin);
        }
    }

    // Redirigir a la ruta 'membresia-cliente' pasando las membresías
    return Inertia::render('VistaCliente/membresiacliente', [
        'membresias' => $membresias
    ]);
}

private function calcularEstado($fechaFin)
{
    // Fecha actual
    $fechaActual = Carbon::now();

    // Comprobar si está vencida, próxima a expirar o activa
    if ($fechaActual->gt($fechaFin)) {
        return 'Vencida';
    } elseif ($fechaActual->diffInDays($fechaFin) <= 3) {
        return 'Próximo a Expirar';
    } else {
        return 'Activo';
    }
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
