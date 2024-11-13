<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Compra;
use App\Models\Membresia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EstadisticasController extends Controller
{
    public function index()
    {
        // Contar total de miembros
        $totalMembers = Membresia::count();
        
        // Contar miembros activos
        $activeMembers = Membresia::whereHas('detalles', function($query) {
            $query->where('fechaFin', '>=', Carbon::today());
        })->count();
        
        // Contar ventas y compras
        $totalSales = Venta::count();
        $totalPurchases = Compra::count();
        
        // Contar ventas y compras mensuales
        $monthlySales = Venta::whereMonth('fechaVenta', Carbon::now()->month)->count();
        $monthlyPurchases = Compra::whereMonth('fechaCompra', Carbon::now()->month)->count();
        
        // Obtener los 5 productos más vendidos
        $topSellingProducts = DetalleVenta::select('codProducto', DB::raw('count(*) as count'))
            ->groupBy('codProducto')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        
        // Retornar la vista con los datos
        return Inertia::render('encargado', [
            'stats' => [
                'totalMembers' => $totalMembers,
                'activeMembers' => $activeMembers,
                'totalSales' => $totalSales,
                'totalPurchases' => $totalPurchases,
                'monthlySales' => $monthlySales,
                'monthlyPurchases' => $monthlyPurchases,
                'topSellingProducts' => $topSellingProducts, // Pasar productos más vendidos
            ],
        ]);
    }
}
