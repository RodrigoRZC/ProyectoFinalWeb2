<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Usuario;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function cliente()
    {
        return view('dashboards.cliente');
    }

    public function gerente()
    {
        return view('dashboards.gerente');
    }

    public function administrador()
    {
        Gate::authorize('es-administrador');

        // Total usuarios
        $totalUsuarios    = Usuario::count();
        $totalVendedores  = Usuario::totalVendedores();
        $totalCompradores = Usuario::totalCompradores();

        // Productos por categoría
        $categorias = Categoria::withCount('productos')->get();

        // Producto más vendido
        $productoMasVendido = Venta::productoMasVendido();

        // Comprador más frecuente global
        $compradorMasFrecuente = Venta::compradorMasFrecuente();

        // Comprador más frecuente POR categoría usando Eloquent
        $compradorPorCategoria = Categoria::with([
            'productos.ventas.cliente'
        ])->get()->map(function ($categoria) {
            $compradores = $categoria->productos
                ->flatMap(fn($p) => $p->ventas)
                ->groupBy('cliente_id')
                ->map(fn($ventas) => [
                    'cliente'      => $ventas->first()->cliente,
                    'total_compras'=> $ventas->count(),
                ])
                ->sortByDesc('total_compras')
                ->first();

            return [
                'categoria' => $categoria->nombre,
                'comprador' => $compradores,
            ];
        });

        // hasManyThrough — categorías por vendedor
        $vendedores = Usuario::where('rol', 'gerente')
            ->with(['productos.categorias'])
            ->get();

        return view('dashboards.administrador', compact(
            'totalUsuarios',
            'totalVendedores',
            'totalCompradores',
            'categorias',
            'productoMasVendido',
            'compradorMasFrecuente',
            'compradorPorCategoria',
            'vendedores'
        ));
    }
}
