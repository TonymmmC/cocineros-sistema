@extends('layouts.app')

@section('title', $producto->nombre . ' - Cocineros')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('home') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Inicio</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </li>
            <li>
                <a href="{{ route('productos') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Productos</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </li>
            <li>
                <span class="text-gray-900 dark:text-white font-medium">{{ Str::limit($producto->nombre, 30) }}</span>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Imágenes -->
        <div>
            <div class="relative bg-gray-100 dark:bg-gray-800 rounded-2xl overflow-hidden h-[450px] shadow-sm">
                <img src="{{ $producto->imagen_url }}"
                     alt="{{ $producto->nombre }}"
                     class="w-full h-full object-cover">

                <!-- Badges -->
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    @if($producto->es_vegano)
                        <span class="bg-green-500 text-white text-sm font-medium px-3 py-1 rounded-full shadow-sm">
                            Vegano
                        </span>
                    @elseif($producto->es_vegetariano)
                        <span class="bg-green-500 text-white text-sm font-medium px-3 py-1 rounded-full shadow-sm">
                            Vegetariano
                        </span>
                    @endif
                    @if($producto->es_sin_gluten)
                        <span class="bg-blue-500 text-white text-sm font-medium px-3 py-1 rounded-full shadow-sm">
                            Sin Gluten
                        </span>
                    @endif
                </div>
            </div>

            @if($producto->imagenes && count($producto->imagenes) > 1)
                <div class="grid grid-cols-4 gap-3 mt-4">
                    @foreach($producto->imagenes as $imagen)
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl h-24 overflow-hidden shadow-sm hover:ring-2 hover:ring-primary-500 transition-all cursor-pointer">
                            <img src="{{ asset('storage/' . $imagen) }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Información -->
        <div>
            <div class="mb-4">
                <span class="inline-block text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-3 py-1 rounded-full">
                    {{ $producto->categoria->nombre }}
                </span>
            </div>

            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $producto->nombre }}</h1>

            <div class="flex items-center gap-4 mb-6">
                <span class="text-4xl font-bold text-primary-600 dark:text-primary-400">{{ $producto->precio_formateado }}</span>
                <span class="text-gray-500 dark:text-gray-400 text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ $producto->vistas }} vistas
                </span>
            </div>

            <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed mb-8">{{ $producto->descripcion }}</p>

            <!-- Detalles rápidos -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 text-center border border-gray-100 dark:border-gray-700">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="font-bold text-gray-900 dark:text-white">{{ $producto->tiempo_preparacion_min }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">minutos</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 text-center border border-gray-100 dark:border-gray-700">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <div class="font-bold text-gray-900 dark:text-white">{{ $producto->porciones }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">porciones</div>
                </div>
                @if($producto->stock_disponible !== null)
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 text-center border border-gray-100 dark:border-gray-700">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <div class="font-bold text-gray-900 dark:text-white">{{ $producto->stock_disponible }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">disponibles</div>
                    </div>
                @endif
            </div>

            <!-- Ingredientes -->
            @if($producto->ingredientes && count($producto->ingredientes) > 0)
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Ingredientes
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($producto->ingredientes as $ingrediente)
                            <span class="bg-amber-50 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $ingrediente }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Alérgenos -->
            @if($producto->alergenos && count($producto->alergenos) > 0)
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Alérgenos
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($producto->alergenos as $alergeno)
                            <span class="bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 px-3 py-1 rounded-full text-sm font-medium border border-red-100 dark:border-red-800">
                                {{ $alergeno }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Cocinero -->
            @if($producto->cocinero)
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Preparado por</h3>
                    <a href="{{ route('cocinero.detalle', $producto->cocinero->id) }}"
                       class="flex items-center bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl p-4 hover:shadow-md transition-all duration-300 border border-gray-100 dark:border-gray-700 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/50 dark:to-primary-800/50 rounded-full flex items-center justify-center text-3xl overflow-hidden ring-4 ring-white dark:ring-gray-800 shadow-md">
                            <img src="{{ $producto->cocinero->foto_url }}"
                                 alt="{{ $producto->cocinero->nombre_completo }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">
                                {{ $producto->cocinero->nombre_completo }}
                            </h4>
                            <div class="flex items-center mt-1">
                                <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 rounded-full">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="ml-1 font-semibold text-gray-900 dark:text-white text-sm">{{ number_format($producto->cocinero->calificacion_promedio, 1) }}</span>
                                </div>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Productos Relacionados -->
    @if($relacionados->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Productos Relacionados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relacionados as $rel)
                    <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                        <div class="relative h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden">
                            <img src="{{ $rel->imagen_url }}"
                                 alt="{{ $rel->nombre }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-3 right-3">
                                <span class="bg-white/95 backdrop-blur-sm text-primary-600 font-bold px-3 py-1 rounded-full text-sm shadow-sm">
                                    {{ $rel->precio_formateado }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 transition-colors">
                                {{ $rel->nombre }}
                            </h3>
                            <a href="{{ route('producto.detalle', $rel->id) }}"
                               class="block text-center bg-gray-900 dark:bg-gray-700 text-white py-2 rounded-xl font-medium hover:bg-primary-600 dark:hover:bg-primary-600 transition-colors duration-300">
                                Ver Detalle
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
