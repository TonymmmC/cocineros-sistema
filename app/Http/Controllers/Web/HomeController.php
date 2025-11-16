<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cocinero;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $productos = Producto::with(['categoria', 'cocinero'])
            ->where('disponible', true)
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        $cocineros = Cocinero::with('user')
            ->where('esta_disponible', true)
            ->orderBy('calificacion_promedio', 'desc')
            ->take(6)
            ->get();

        $categorias = Categoria::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('web.home', compact('productos', 'cocineros', 'categorias'));
    }

    public function productos(Request $request): View
    {
        $query = Producto::with(['categoria', 'cocinero'])
            ->where('disponible', true);

        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'ilike', "%{$buscar}%")
                    ->orWhere('descripcion', 'ilike', "%{$buscar}%");
            });
        }

        $productos = $query->orderBy('created_at', 'desc')->paginate(12);
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();

        return view('web.productos', compact('productos', 'categorias'));
    }

    public function productoDetalle(int $id): View
    {
        $producto = Producto::with(['categoria', 'cocinero'])
            ->findOrFail($id);

        $producto->incrementarVistas();

        $relacionados = Producto::with(['categoria', 'cocinero'])
            ->where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->where('disponible', true)
            ->take(4)
            ->get();

        return view('web.producto-detalle', compact('producto', 'relacionados'));
    }

    public function cocineros(): View
    {
        $cocineros = Cocinero::with('user')
            ->withCount('productos')
            ->where('esta_disponible', true)
            ->orderBy('calificacion_promedio', 'desc')
            ->paginate(12);

        return view('web.cocineros', compact('cocineros'));
    }

    public function cocineroDetalle(int $id): View
    {
        $cocinero = Cocinero::with('user')
            ->withCount('productos')
            ->findOrFail($id);

        $productos = $cocinero->productos()
            ->with('categoria')
            ->where('disponible', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('web.cocinero-detalle', compact('cocinero', 'productos'));
    }
}
