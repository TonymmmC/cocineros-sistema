<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PedidoResource;
use App\Models\Cliente;
use App\Models\Cocinero;
use App\Models\DetallePedido;
use App\Models\DireccionCliente;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    /**
     * Crear un nuevo pedido (solo clientes)
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        // Verificar que el usuario es cliente
        if ($user->role !== 'cliente') {
            return response()->json([
                'message' => 'Solo los clientes pueden crear pedidos',
            ], 403);
        }

        $validated = $request->validate([
            'cocinero_id' => 'required|exists:cocineros,id',
            'direccion_id' => 'nullable|exists:direcciones_cliente,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1|max:99',
            'productos.*.notas' => 'nullable|string|max:255',
            'notas_cliente' => 'nullable|string|max:500',
            'metodo_pago' => ['required', Rule::in(['efectivo', 'tarjeta', 'transferencia', 'qr'])],
            'costo_entrega' => 'nullable|numeric|min:0',
        ]);

        // Obtener o crear cliente
        $cliente = Cliente::firstOrCreate(
            ['user_id' => $user->id],
            ['nombre_completo' => $user->name]
        );

        // Verificar que el cocinero existe y está disponible
        $cocinero = Cocinero::findOrFail($validated['cocinero_id']);
        if (!$cocinero->esta_disponible) {
            return response()->json([
                'message' => 'El cocinero no está disponible actualmente',
            ], 422);
        }

        // Verificar que todos los productos pertenecen al cocinero
        $productosIds = collect($validated['productos'])->pluck('producto_id');
        $productos = Producto::whereIn('id', $productosIds)
            ->where('cocinero_id', $cocinero->user_id)
            ->where('disponible', true)
            ->get()
            ->keyBy('id');

        if ($productos->count() !== $productosIds->count()) {
            return response()->json([
                'message' => 'Algunos productos no están disponibles o no pertenecen al cocinero seleccionado',
            ], 422);
        }

        // Verificar dirección si se proporciona
        if (!empty($validated['direccion_id'])) {
            $direccion = DireccionCliente::where('id', $validated['direccion_id'])
                ->where('cliente_id', $cliente->id)
                ->first();

            if (!$direccion) {
                return response()->json([
                    'message' => 'La dirección no pertenece al cliente',
                ], 422);
            }
        }

        DB::beginTransaction();
        try {
            // Crear pedido
            $pedido = Pedido::create([
                'cliente_id' => $cliente->id,
                'cocinero_id' => $cocinero->id,
                'direccion_id' => $validated['direccion_id'] ?? null,
                'estado' => 'pendiente',
                'metodo_pago' => $validated['metodo_pago'],
                'estado_pago' => 'pendiente',
                'notas_cliente' => $validated['notas_cliente'] ?? null,
                'costo_entrega' => $validated['costo_entrega'] ?? 0,
                'subtotal' => 0,
                'comision_plataforma' => 0,
                'total' => 0,
            ]);

            // Crear detalles del pedido
            $tiempoTotal = 0;
            foreach ($validated['productos'] as $item) {
                $producto = $productos->get($item['producto_id']);

                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'notas' => $item['notas'] ?? null,
                ]);

                $tiempoTotal += $producto->tiempo_preparacion_min * $item['cantidad'];
            }

            // Calcular totales
            $pedido->refresh();
            $pedido->calcularTotales();

            // Estimar tiempo
            $pedido->tiempo_estimado_min = min($tiempoTotal, 180); // Máximo 3 horas
            $pedido->save();

            DB::commit();

            $pedido->load(['detalles.producto', 'cocinero.user', 'cliente.user', 'direccion']);

            return response()->json([
                'message' => 'Pedido creado exitosamente',
                'data' => new PedidoResource($pedido),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear el pedido',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener mis pedidos como cliente
     */
    public function misPedidos(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'cliente') {
            return response()->json([
                'message' => 'Solo los clientes pueden ver sus pedidos',
            ], 403);
        }

        $cliente = Cliente::where('user_id', $user->id)->first();

        if (!$cliente) {
            return response()->json([
                'data' => [],
                'message' => 'No tienes pedidos registrados',
            ], 200);
        }

        $estado = $request->query('estado'); // pendiente, completado, cancelado, todos
        $query = $cliente->pedidos()
            ->with(['detalles.producto', 'cocinero.user', 'direccion'])
            ->orderBy('created_at', 'desc');

        if ($estado === 'pendientes') {
            $query->pendientes();
        } elseif ($estado === 'completados') {
            $query->completados();
        } elseif ($estado === 'cancelados') {
            $query->cancelados();
        }

        $pedidos = $query->paginate(10);

        return response()->json([
            'data' => PedidoResource::collection($pedidos),
            'meta' => [
                'current_page' => $pedidos->currentPage(),
                'last_page' => $pedidos->lastPage(),
                'per_page' => $pedidos->perPage(),
                'total' => $pedidos->total(),
            ],
        ], 200);
    }

    /**
     * Obtener pedidos recibidos como cocinero
     */
    public function pedidosRecibidos(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role !== 'cocinero') {
            return response()->json([
                'message' => 'Solo los cocineros pueden ver pedidos recibidos',
            ], 403);
        }

        $cocinero = Cocinero::where('user_id', $user->id)->first();

        if (!$cocinero) {
            return response()->json([
                'message' => 'No tienes perfil de cocinero',
            ], 404);
        }

        $estado = $request->query('estado');
        $query = Pedido::where('cocinero_id', $cocinero->id)
            ->with(['detalles.producto', 'cliente.user', 'direccion'])
            ->orderBy('created_at', 'desc');

        if ($estado === 'pendientes') {
            $query->pendientes();
        } elseif ($estado === 'completados') {
            $query->completados();
        } elseif ($estado === 'cancelados') {
            $query->cancelados();
        }

        $pedidos = $query->paginate(10);

        return response()->json([
            'data' => PedidoResource::collection($pedidos),
            'meta' => [
                'current_page' => $pedidos->currentPage(),
                'last_page' => $pedidos->lastPage(),
                'per_page' => $pedidos->perPage(),
                'total' => $pedidos->total(),
            ],
        ], 200);
    }

    /**
     * Ver detalle de un pedido específico
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $user = $request->user();
        $pedido = Pedido::with(['detalles.producto', 'cocinero.user', 'cliente.user', 'direccion'])
            ->findOrFail($id);

        // Verificar que el usuario tiene acceso al pedido
        $tieneAcceso = false;

        if ($user->role === 'cliente') {
            $cliente = Cliente::where('user_id', $user->id)->first();
            $tieneAcceso = $cliente && $pedido->cliente_id === $cliente->id;
        } elseif ($user->role === 'cocinero') {
            $cocinero = Cocinero::where('user_id', $user->id)->first();
            $tieneAcceso = $cocinero && $pedido->cocinero_id === $cocinero->id;
        } elseif (in_array($user->role, ['admin', 'superadmin'])) {
            $tieneAcceso = true;
        }

        if (!$tieneAcceso) {
            return response()->json([
                'message' => 'No tienes acceso a este pedido',
            ], 403);
        }

        return response()->json([
            'data' => new PedidoResource($pedido),
        ], 200);
    }

    /**
     * Cambiar estado del pedido (cocinero o admin)
     */
    public function cambiarEstado(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'estado' => ['required', Rule::in([
                'confirmado',
                'preparando',
                'listo',
                'en_camino',
                'entregado',
                'cancelado',
            ])],
            'motivo_cancelacion' => 'required_if:estado,cancelado|string|max:500',
        ]);

        $pedido = Pedido::findOrFail($id);

        // Verificar permisos
        $puedeModificar = false;

        if ($user->role === 'cocinero') {
            $cocinero = Cocinero::where('user_id', $user->id)->first();
            $puedeModificar = $cocinero && $pedido->cocinero_id === $cocinero->id;
        } elseif (in_array($user->role, ['admin', 'superadmin'])) {
            $puedeModificar = true;
        }

        if (!$puedeModificar) {
            return response()->json([
                'message' => 'No tienes permisos para modificar este pedido',
            ], 403);
        }

        // Validar transiciones de estado válidas
        $transicionesValidas = [
            'pendiente' => ['confirmado', 'cancelado'],
            'confirmado' => ['preparando', 'cancelado'],
            'preparando' => ['listo', 'cancelado'],
            'listo' => ['en_camino', 'entregado', 'cancelado'],
            'en_camino' => ['entregado', 'cancelado'],
            'entregado' => [], // Estado final
            'cancelado' => [], // Estado final
        ];

        $estadoActual = $pedido->estado;
        $nuevoEstado = $validated['estado'];

        if (!in_array($nuevoEstado, $transicionesValidas[$estadoActual] ?? [])) {
            return response()->json([
                'message' => "No se puede cambiar de '{$estadoActual}' a '{$nuevoEstado}'",
            ], 422);
        }

        // Aplicar cambio
        if ($nuevoEstado === 'cancelado') {
            $pedido->motivo_cancelacion = $validated['motivo_cancelacion'];
        }

        $pedido->cambiarEstado($nuevoEstado);

        $pedido->load(['detalles.producto', 'cocinero.user', 'cliente.user', 'direccion']);

        return response()->json([
            'message' => "Pedido actualizado a '{$nuevoEstado}'",
            'data' => new PedidoResource($pedido),
        ], 200);
    }

    /**
     * Cancelar pedido (cliente puede cancelar solo si está pendiente)
     */
    public function cancelar(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'motivo' => 'required|string|max:500',
        ]);

        $pedido = Pedido::findOrFail($id);

        // Solo el cliente dueño puede cancelar
        if ($user->role === 'cliente') {
            $cliente = Cliente::where('user_id', $user->id)->first();

            if (!$cliente || $pedido->cliente_id !== $cliente->id) {
                return response()->json([
                    'message' => 'No tienes acceso a este pedido',
                ], 403);
            }

            // Cliente solo puede cancelar si está pendiente
            if ($pedido->estado !== 'pendiente') {
                return response()->json([
                    'message' => 'Solo puedes cancelar pedidos pendientes. Contacta al cocinero.',
                ], 422);
            }
        } else {
            return response()->json([
                'message' => 'Solo el cliente puede cancelar su pedido desde aquí',
            ], 403);
        }

        $pedido->motivo_cancelacion = $validated['motivo'];
        $pedido->cambiarEstado('cancelado');

        $pedido->load(['detalles.producto', 'cocinero.user']);

        return response()->json([
            'message' => 'Pedido cancelado exitosamente',
            'data' => new PedidoResource($pedido),
        ], 200);
    }
}
