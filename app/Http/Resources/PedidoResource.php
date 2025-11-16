<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'codigo_pedido' => $this->codigo_pedido,
            'estado' => $this->estado,
            'estado_pago' => $this->estado_pago,

            // Montos
            'subtotal' => (float) $this->subtotal,
            'comision_plataforma' => (float) $this->comision_plataforma,
            'costo_entrega' => (float) $this->costo_entrega,
            'total' => (float) $this->total,

            // Información adicional
            'metodo_pago' => $this->metodo_pago,
            'notas_cliente' => $this->notas_cliente,
            'tiempo_estimado_min' => $this->tiempo_estimado_min,
            'motivo_cancelacion' => $this->motivo_cancelacion,

            // Fechas importantes
            'fecha_confirmacion' => $this->fecha_confirmacion?->toISOString(),
            'fecha_listo' => $this->fecha_listo?->toISOString(),
            'fecha_entrega' => $this->fecha_entrega?->toISOString(),
            'fecha_cancelacion' => $this->fecha_cancelacion?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),

            // Relaciones
            'cliente' => $this->whenLoaded('cliente', function () {
                return [
                    'id' => $this->cliente->id,
                    'nombre_completo' => $this->cliente->nombre_completo,
                    'user' => $this->cliente->user ? [
                        'id' => $this->cliente->user->id,
                        'name' => $this->cliente->user->name,
                        'email' => $this->cliente->user->email,
                        'phone' => $this->cliente->user->phone,
                    ] : null,
                ];
            }),

            'cocinero' => $this->whenLoaded('cocinero', function () {
                return [
                    'id' => $this->cocinero->id,
                    'nombre_completo' => $this->cocinero->nombre_completo,
                    'calificacion_promedio' => (float) $this->cocinero->calificacion_promedio,
                    'user' => $this->cocinero->user ? [
                        'id' => $this->cocinero->user->id,
                        'name' => $this->cocinero->user->name,
                        'email' => $this->cocinero->user->email,
                        'phone' => $this->cocinero->user->phone,
                    ] : null,
                ];
            }),

            'direccion' => $this->whenLoaded('direccion', function () {
                return $this->direccion ? [
                    'id' => $this->direccion->id,
                    'alias' => $this->direccion->alias,
                    'direccion_completa' => $this->direccion->direccion_completa,
                    'referencia' => $this->direccion->referencia,
                    'latitud' => $this->direccion->latitud ? (float) $this->direccion->latitud : null,
                    'longitud' => $this->direccion->longitud ? (float) $this->direccion->longitud : null,
                ] : null;
            }),

            'detalles' => $this->whenLoaded('detalles', function () {
                return $this->detalles->map(function ($detalle) {
                    return [
                        'id' => $detalle->id,
                        'cantidad' => $detalle->cantidad,
                        'precio_unitario' => (float) $detalle->precio_unitario,
                        'subtotal' => (float) $detalle->subtotal,
                        'notas' => $detalle->notas,
                        'producto' => $detalle->producto ? [
                            'id' => $detalle->producto->id,
                            'nombre' => $detalle->producto->nombre,
                            'descripcion' => $detalle->producto->descripcion,
                            'primera_imagen' => $detalle->producto->primera_imagen,
                        ] : null,
                    ];
                });
            }),

            // Helpers para el frontend
            'puede_cancelar' => $this->estado === 'pendiente',
            'esta_activo' => in_array($this->estado, ['pendiente', 'confirmado', 'preparando', 'listo', 'en_camino']),
            'esta_completado' => $this->estado === 'entregado',
            'esta_cancelado' => $this->estado === 'cancelado',
        ];
    }
}
