<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => (float) $this->precio,
            'precio_formateado' => $this->precio_formateado,
            'tiempo_preparacion_min' => $this->tiempo_preparacion_min,
            'porciones' => $this->porciones,
            'stock_disponible' => $this->stock_disponible,
            'imagenes' => $this->imagenes ?? [],
            'primera_imagen' => $this->primera_imagen,
            'ingredientes' => $this->ingredientes ?? [],
            'alergenos' => $this->alergenos ?? [],
            'es_vegetariano' => $this->es_vegetariano,
            'es_vegano' => $this->es_vegano,
            'es_sin_gluten' => $this->es_sin_gluten,
            'disponible' => $this->disponible,
            'vistas' => $this->vistas,
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
            'cocinero' => $this->whenLoaded('cocinero', function () {
                return [
                    'id' => $this->cocinero->id,
                    'nombre_completo' => $this->cocinero->nombre_completo,
                    'foto_perfil' => $this->cocinero->foto_perfil,
                    'calificacion_promedio' => $this->cocinero->calificacion_promedio,
                    'esta_disponible' => $this->cocinero->esta_disponible,
                ];
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
