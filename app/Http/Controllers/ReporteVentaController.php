<?php

// app/Http/Controllers/ReporteVentaController.php
namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Compra;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;

class ReporteVentaController extends Controller
{
    public function index(Request $request)
    {
        $inicio = $request->input('inicio');
        $fin = $request->input('fin');
        $ventas = Venta::query()
            ->when($inicio, function ($query) use ($inicio) {
                return $query->where('fechaVenta', '>=', $inicio);
            })
            ->when($fin, function ($query) use ($fin) {
                return $query->where('fechaVenta', '<=', $fin);
            })
            ->with('encargado', 'cliente', 'detalleVenta.producto') 
            ->paginate(10); 
        return inertia('Reportes/Ventas', [
            'ventas' => $ventas
        ]);
    }
    public function indexCompras(Request $request)
    {
        $inicio = $request->input('inicio');
        $fin = $request->input('fin');
        $compras = Compra::query()
            ->when($inicio, function($query) use ($inicio) {
                return $query->where('fechaCompra', '>=', $inicio);
            })
            ->when($fin, function($query) use ($fin) {
                return $query->where('fechaCompra', '<=', $fin);
            })
            ->with('proveedor', 'encargado') 
            ->paginate(10);
        return inertia('Reportes/Compras', [
            'compras' => $compras
        ]);
    }
}

