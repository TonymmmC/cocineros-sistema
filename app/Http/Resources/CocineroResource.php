<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CocineroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'nombre_completo' => $this->nombre_completo,
            'ci' => $this->ci,
            'foto_perfil' => $this->foto_perfil,
            'bio' => $this->bio,
            'especialidades' => $this->especialidades ?? [],
            'certificaciones' => $this->certificaciones ?? [],
            'direccion' => $this->direccion,
            'latitud' => $this->latitud ? (float) $this->latitud : null,
            'longitud' => $this->longitud ? (float) $this->longitud : null,
            'radio_entrega_km' => (float) $this->radio_entrega_km,
            'esta_disponible' => $this->esta_disponible,
            'calificacion_promedio' => (float) $this->calificacion_promedio,
            'total_pedidos' => $this->total_pedidos,
            'productos_count' => $this->whenCounted('productos'),
            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
                'phone' => $this->user?->phone,
            ],
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
