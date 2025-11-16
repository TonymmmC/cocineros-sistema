<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SolicitudCocinero;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SolicitudCocineroController extends Controller
{
    /**
     * Crear nueva solicitud para convertirse en cocinero
     * POST /api/v1/solicitud-cocinero
     */
    public function store(Request $request): JsonResponse
    {
        // Validar que el usuario sea cliente
        if ($request->user()->role !== 'cliente') {
            return response()->json([
                'message' => 'Solo los clientes pueden solicitar ser cocineros',
            ], 403);
        }

        // Verificar si ya tiene una solicitud pendiente
        $solicitudExistente = SolicitudCocinero::where('user_id', $request->user()->id)
            ->whereIn('estado', ['pendiente', 'aprobado'])
            ->first();

        if ($solicitudExistente) {
            return response()->json([
                'message' => $solicitudExistente->estado === 'aprobado'
                    ? 'Ya eres cocinero'
                    : 'Ya tienes una solicitud pendiente',
                'solicitud' => $solicitudExistente,
            ], 409);
        }

        $validated = $request->validate([
            'ci' => 'required|string|max:20|unique:solicitudes_cocinero,ci',
            'documento_ci' => 'required|file|image|max:5120', // 5MB
            'nombre_completo' => 'required|string|max:150',
            'direccion' => 'required|string',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'especialidades' => 'required|array|min:1',
            'especialidades.*' => 'required|string|max:100',
            'certificaciones' => 'nullable|array',
            'certificaciones.*' => 'nullable|string|max:100',
            'bio' => 'required|string|min:50|max:1000',
            'radio_entrega_km' => 'required|numeric|min:0.5|max:50',
        ]);

        try {
            DB::beginTransaction();

            // Subir documento CI
            $documentoPath = $request->file('documento_ci')
                ->store('documentos-ci', 'public');

            // Crear solicitud
            $solicitud = SolicitudCocinero::create([
                'user_id' => $request->user()->id,
                'ci' => $validated['ci'],
                'documento_ci_path' => $documentoPath,
                'nombre_completo' => $validated['nombre_completo'],
                'direccion' => $validated['direccion'],
                'latitud' => $validated['latitud'] ?? null,
                'longitud' => $validated['longitud'] ?? null,
                'radio_entrega_km' => $validated['radio_entrega_km'],
                'especialidades' => $validated['especialidades'],
                'certificaciones' => $validated['certificaciones'] ?? null,
                'bio' => $validated['bio'],
                'estado' => 'pendiente',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Solicitud enviada correctamente. Te notificaremos cuando sea revisada.',
                'solicitud' => $solicitud,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            // Eliminar archivo si se subió
            if (isset($documentoPath)) {
                Storage::disk('public')->delete($documentoPath);
            }

            return response()->json([
                'message' => 'Error al crear la solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener el estado de mi solicitud
     * GET /api/v1/solicitud-cocinero/mi-solicitud
     */
    public function miSolicitud(Request $request): JsonResponse
    {
        $solicitud = SolicitudCocinero::where('user_id', $request->user()->id)
            ->with(['user', 'revisor'])
            ->latest()
            ->first();

        if (!$solicitud) {
            return response()->json([
                'message' => 'No tienes solicitudes registradas',
                'puede_solicitar' => $request->user()->role === 'cliente',
            ], 404);
        }

        return response()->json([
            'solicitud' => $solicitud,
            'puede_reenviar' => $solicitud->estado === 'rechazado',
        ]);
    }

    /**
     * Re-enviar solicitud rechazada (con correcciones)
     * PUT /api/v1/solicitud-cocinero/{id}/reenviar
     */
    public function reenviar(Request $request, SolicitudCocinero $solicitud): JsonResponse
    {
        // Verificar permisos
        if ($solicitud->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Solo se puede reenviar si fue rechazada
        if ($solicitud->estado !== 'rechazado') {
            return response()->json([
                'message' => 'Solo puedes reenviar solicitudes rechazadas',
            ], 400);
        }

        $validated = $request->validate([
            'documento_ci' => 'nullable|file|image|max:5120',
            'nombre_completo' => 'sometimes|string|max:150',
            'direccion' => 'sometimes|string',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'especialidades' => 'sometimes|array|min:1',
            'certificaciones' => 'nullable|array',
            'bio' => 'sometimes|string|min:50|max:1000',
            'radio_entrega_km' => 'sometimes|numeric|min:0.5|max:50',
        ]);

        try {
            // Si hay nuevo documento, eliminar el anterior
            if ($request->hasFile('documento_ci')) {
                Storage::disk('public')->delete($solicitud->documento_ci_path);
                $validated['documento_ci_path'] = $request->file('documento_ci')
                    ->store('documentos-ci', 'public');
            }

            // Actualizar y resetear estado
            $solicitud->update(array_merge($validated, [
                'estado' => 'pendiente',
                'razon_rechazo' => null,
                'revisado_en' => null,
                'revisado_por' => null,
            ]));

            return response()->json([
                'message' => 'Solicitud reenviada correctamente',
                'solicitud' => $solicitud->fresh(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al reenviar la solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
