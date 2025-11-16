@extends('layouts.app')

@section('title', 'Mis Pedidos - Cocineros')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mis Pedidos</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Historial y seguimiento de tus pedidos</p>
    </div>

    @if($pedidos->count() > 0)
        <div class="space-y-4">
            @foreach($pedidos as $pedido)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Pedido #{{ $pedido->codigo_pedido }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $pedido->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                @php
                                    $estadoClases = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'confirmado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        'preparando' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                        'listo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400',
                                        'en_camino' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-400',
                                        'entregado' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                    ];
                                    $estadoNombres = [
                                        'pending' => 'Pendiente',
                                        'confirmado' => 'Confirmado',
                                        'preparando' => 'Preparando',
                                        'listo' => 'Listo',
                                        'en_camino' => 'En Camino',
                                        'entregado' => 'Entregado',
                                        'cancelado' => 'Cancelado',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $estadoClases[$pedido->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $estadoNombres[$pedido->estado] ?? $pedido->estado }}
                                </span>
                            </div>
                        </div>

                        @if($pedido->cocinero)
                            <div class="flex items-center mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center">
                                    <span class="text-primary-600 dark:text-primary-400 font-semibold">
                                        {{ strtoupper(substr($pedido->cocinero->nombre_completo, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $pedido->cocinero->nombre_completo }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Cocinero</p>
                                </div>
                            </div>
                        @endif

                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Subtotal</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">${{ number_format($pedido->subtotal, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Envío</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">${{ number_format($pedido->costo_entrega, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Comisión</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">${{ number_format($pedido->comision, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Total</p>
                                    <p class="font-bold text-primary-600 dark:text-primary-400 text-lg">${{ number_format($pedido->total, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($pedidos->hasPages())
            <div class="mt-8">
                {{ $pedidos->links() }}
            </div>
        @endif
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No tienes pedidos</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Explora nuestros productos y realiza tu primer pedido</p>
            <a href="{{ route('productos') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors">
                Explorar Productos
            </a>
        </div>
    @endif
</div>
@endsection
