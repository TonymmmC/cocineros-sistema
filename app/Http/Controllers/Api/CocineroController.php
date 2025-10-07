<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CocineroResource;
use App\Http\Resources\ProductoResource;
use App\Models\Cocinero;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CocineroController extends Controller
{
    /**
     * Listar cocineros disponibles
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Cocinero::with('user')
            ->withCount('productos');

        // Filtro por disponibilidad
        if ($request->boolean('disponibles')) {
            $query->where('esta_disponible', true);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'calificacion_promedio');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = ['calificacion_promedio', 'total_pedidos', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $cocineros = $query->paginate($request->get('per_page', 10));

        return CocineroResource::collection($cocineros);
    }

    /**
     * Obtener un cocinero específico
     */
    public function show(int $id): JsonResponse
    {
        $cocinero = Cocinero::with('user')
            ->withCount('productos')
            ->findOrFail($id);

        return response()->json([
            'data' => new CocineroResource($cocinero),
        ], 200);
    }

    /**
     * Obtener productos de un cocinero
     */
    public function productos(int $id, Request $request): AnonymousResourceCollection
    {
        $cocinero = Cocinero::findOrFail($id);

        $productos = $cocinero->productos()
            ->with(['categoria', 'cocinero'])
            ->where('disponible', true)
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 12));

        return ProductoResource::collection($productos);
    }

    /**
     * Actualizar perfil de cocinero (solo el propio cocinero)
     */
    public function updatePerfil(Request $request): JsonResponse
    {
        $user = $request->user();

        $cocinero = Cocinero::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'nombre_completo' => 'sometimes|string|max:150',
            'bio' => 'nullable|string|max:500',
            'direccion' => 'sometimes|string',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'radio_entrega_km' => 'sometimes|numeric|min:0.5|max:50',
            'especialidades' => 'nullable|array',
            'certificaciones' => 'nullable|array',
        ]);

        $cocinero->update($validated);
        $cocinero->load('user');

        return response()->json([
            'message' => 'Perfil actualizado exitosamente',
            'data' => new CocineroResource($cocinero),
        ], 200);
    }

    /**
     * Toggle disponibilidad del cocinero
     */
    public function toggleDisponibilidad(Request $request): JsonResponse
    {
        $user = $request->user();

        $cocinero = Cocinero::where('user_id', $user->id)->firstOrFail();

        $cocinero->update([
            'esta_disponible' => !$cocinero->esta_disponible,
        ]);

        return response()->json([
            'message' => 'Disponibilidad actualizada',
            'data' => new CocineroResource($cocinero),
        ], 200);
    }
}

// REFACTOR SUGGESTIONS:
// 1. Agregar búsqueda geoespacial (cocineros cerca de cliente)
// 2. Implementar upload de foto_perfil
// 3. Agregar endpoint para estadísticas del cocinero (ventas, etc)
