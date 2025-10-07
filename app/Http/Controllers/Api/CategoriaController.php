<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriaController extends Controller
{
    /**
     * Listar todas las categorías activas
     */
    public function index(): AnonymousResourceCollection
    {
        $categorias = Categoria::active()
            ->ordered()
            ->withCount('productos')
            ->get();

        return CategoriaResource::collection($categorias);
    }

    /**
     * Obtener una categoría específica con sus productos
     */
    public function show(int $id): JsonResponse
    {
        $categoria = Categoria::with(['productos' => function ($query) {
            $query->where('disponible', true)
                  ->orderBy('created_at', 'desc');
        }])
        ->withCount('productos')
        ->findOrFail($id);

        return response()->json([
            'data' => new CategoriaResource($categoria),
        ], 200);
    }
}

// REFACTOR SUGGESTIONS:
// 1. Agregar paginación en productos relacionados
// 2. Implementar cache para categorías (cambian poco)
// 3. Agregar filtros opcionales (activas/inactivas para admin)
