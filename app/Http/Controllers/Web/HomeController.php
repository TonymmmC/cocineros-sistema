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

        $categorias = Categoria::where('is_active', true)
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

        // Filtro por rango de precio
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Filtros de características dietéticas
        if ($request->boolean('vegetariano')) {
            $query->where('es_vegetariano', true);
        }
        if ($request->boolean('vegano')) {
            $query->where('es_vegano', true);
        }
        if ($request->boolean('sin_gluten')) {
            $query->where('es_sin_gluten', true);
        }

        // Filtro por tiempo de preparación máximo
        if ($request->filled('tiempo_max')) {
            $query->where('tiempo_preparacion_min', '<=', $request->tiempo_max);
        }

        // Ordenamiento
        $ordenar = $request->get('ordenar', 'recientes');
        switch ($ordenar) {
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'popular':
                $query->orderBy('vistas', 'desc');
                break;
            case 'nombre':
                $query->orderBy('nombre', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $productos = $query->paginate(12);
        $categorias = Categoria::where('is_active', true)->orderBy('nombre')->get();

        // Obtener rangos para filtros
        $precioMin = Producto::where('disponible', true)->min('precio') ?? 0;
        $precioMax = Producto::where('disponible', true)->max('precio') ?? 1000;

        return view('web.productos', compact('productos', 'categorias', 'precioMin', 'precioMax'));
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

    public function cocineros(Request $request): View
    {
        $query = Cocinero::with('user')
            ->withCount('productos')
            ->where('esta_disponible', true);

        // Búsqueda por nombre
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('user', function ($q) use ($buscar) {
                $q->where('name', 'ilike', "%{$buscar}%");
            })->orWhere('bio', 'ilike', "%{$buscar}%");
        }

        // Filtro por calificación mínima
        if ($request->filled('calificacion_min')) {
            $query->where('calificacion_promedio', '>=', $request->calificacion_min);
        }

        // Filtro por especialidad
        if ($request->filled('especialidad')) {
            $especialidad = $request->especialidad;
            $query->whereRaw("? = ANY(especialidades)", [$especialidad]);
        }

        // Filtro por radio de entrega mínimo
        if ($request->filled('radio_min')) {
            $query->where('radio_entrega_km', '>=', $request->radio_min);
        }

        // Ordenamiento
        $ordenar = $request->get('ordenar', 'calificacion');
        switch ($ordenar) {
            case 'pedidos':
                $query->orderBy('total_pedidos', 'desc');
                break;
            case 'productos':
                $query->orderBy('productos_count', 'desc');
                break;
            case 'recientes':
                $query->orderBy('created_at', 'desc');
                break;
            case 'nombre':
                $query->orderByRaw('(SELECT name FROM users WHERE users.id = cocineros.user_id) ASC');
                break;
            default:
                $query->orderBy('calificacion_promedio', 'desc');
        }

        $cocineros = $query->paginate(12);

        // Obtener especialidades únicas para el filtro
        $especialidades = Cocinero::where('esta_disponible', true)
            ->whereNotNull('especialidades')
            ->pluck('especialidades')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('web.cocineros', compact('cocineros', 'especialidades'));
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
