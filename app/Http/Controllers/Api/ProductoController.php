<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class ProductoController extends Controller
{
    /**
     * Listar productos disponibles con filtros opcionales
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Producto::with(['categoria', 'cocinero'])
            ->where('disponible', true);

        // Filtro por categoría
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        // Filtro por cocinero
        if ($request->filled('cocinero_id')) {
            $query->where('cocinero_id', $request->cocinero_id);
        }

        // Filtros dietéticos
        if ($request->boolean('vegetariano')) {
            $query->where('es_vegetariano', true);
        }
        if ($request->boolean('vegano')) {
            $query->where('es_vegano', true);
        }
        if ($request->boolean('sin_gluten')) {
            $query->where('es_sin_gluten', true);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = ['created_at', 'precio', 'nombre', 'vistas'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $productos = $query->paginate($request->get('per_page', 12));

        return ProductoResource::collection($productos);
    }

    /**
     * Obtener un producto específico (incrementa vistas)
     */
    public function show(int $id): JsonResponse
    {
        $producto = Producto::with(['categoria', 'cocinero'])
            ->findOrFail($id);

        $producto->incrementarVistas();

        return response()->json([
            'data' => new ProductoResource($producto),
        ], 200);
    }

    /**
     * Productos por categoría
     */
    public function byCategoria(int $categoriaId): AnonymousResourceCollection
    {
        $productos = Producto::with(['categoria', 'cocinero'])
            ->where('categoria_id', $categoriaId)
            ->where('disponible', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return ProductoResource::collection($productos);
    }

    /**
     * Búsqueda de productos
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $searchTerm = $request->get('q', '');

        $productos = Producto::with(['categoria', 'cocinero'])
            ->where('disponible', true)
            ->where(function ($query) use ($searchTerm) {
                $query->where('nombre', 'like', "%{$searchTerm}%")
                      ->orWhere('descripcion', 'like', "%{$searchTerm}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return ProductoResource::collection($productos);
    }

    /**
     * Crear nuevo producto (solo cocineros)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'tiempo_preparacion_min' => 'required|integer|min:1',
            'porciones' => 'required|integer|min:1',
            'stock_disponible' => 'nullable|integer|min:0',
            'ingredientes' => 'nullable|array',
            'alergenos' => 'nullable|array',
            'es_vegetariano' => 'boolean',
            'es_vegano' => 'boolean',
            'es_sin_gluten' => 'boolean',
            'disponible' => 'boolean',
        ]);

        $validated['cocinero_id'] = $request->user()->id;

        $producto = Producto::create($validated);
        $producto->load(['categoria', 'cocinero']);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'data' => new ProductoResource($producto),
        ], 201);
    }

    /**
     * Actualizar producto (solo dueño)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $producto = Producto::findOrFail($id);

        if ($producto->cocinero_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No tienes permiso para editar este producto',
            ], 403);
        }

        $validated = $request->validate([
            'categoria_id' => 'sometimes|exists:categorias,id',
            'nombre' => 'sometimes|string|max:150',
            'descripcion' => 'sometimes|string',
            'precio' => 'sometimes|numeric|min:0',
            'tiempo_preparacion_min' => 'sometimes|integer|min:1',
            'porciones' => 'sometimes|integer|min:1',
            'stock_disponible' => 'nullable|integer|min:0',
            'ingredientes' => 'nullable|array',
            'alergenos' => 'nullable|array',
            'es_vegetariano' => 'boolean',
            'es_vegano' => 'boolean',
            'es_sin_gluten' => 'boolean',
            'disponible' => 'boolean',
        ]);

        $producto->update($validated);
        $producto->load(['categoria', 'cocinero']);

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'data' => new ProductoResource($producto),
        ], 200);
    }

    /**
     * Eliminar producto (solo dueño)
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $producto = Producto::findOrFail($id);

        if ($producto->cocinero_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No tienes permiso para eliminar este producto',
            ], 403);
        }

        $producto->delete();

        return response()->json([
            'message' => 'Producto eliminado exitosamente',
        ], 200);
    }

    /**
     * Toggle disponibilidad de producto (solo dueño)
     */
    public function toggleDisponibilidad(Request $request, int $id): JsonResponse
    {
        $producto = Producto::findOrFail($id);

        if ($producto->cocinero_id !== $request->user()->id) {
            return response()->json([
                'message' => 'No tienes permiso para modificar este producto',
            ], 403);
        }

        $producto->update([
            'disponible' => !$producto->disponible,
        ]);

        return response()->json([
            'message' => 'Disponibilidad actualizada',
            'data' => new ProductoResource($producto),
        ], 200);
    }
}

// REFACTOR SUGGESTIONS:
// 1. Extraer validaciones a FormRequest classes
// 2. Usar Policy en lugar de chequeos manuales de ownership
// 3. Implementar full-text search en producción (MySQL/PostgreSQL)
// 4. Agregar upload de imágenes (actualmente solo JSON)
