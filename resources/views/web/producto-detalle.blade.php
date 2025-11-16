@extends('layouts.app')

@section('title', $producto->nombre . ' - Cocineros')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Inicio</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('productos') }}" class="text-gray-500 hover:text-gray-700">Productos</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900">{{ $producto->nombre }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Imágenes -->
        <div>
            <div class="bg-gray-200 rounded-lg overflow-hidden h-96 flex items-center justify-center">
                @if($producto->primera_imagen)
                    <img src="{{ asset('storage/' . $producto->primera_imagen) }}"
                         alt="{{ $producto->nombre }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-6xl">🍽️</span>
                @endif
            </div>

            @if($producto->imagenes && count($producto->imagenes) > 1)
                <div class="grid grid-cols-4 gap-2 mt-4">
                    @foreach($producto->imagenes as $imagen)
                        <div class="bg-gray-200 rounded h-20 overflow-hidden">
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
            <div class="flex justify-between items-start mb-4">
                <h1 class="text-3xl font-bold text-gray-900">{{ $producto->nombre }}</h1>
                <span class="text-3xl font-bold text-amber-600">{{ $producto->precio_formateado }}</span>
            </div>

            <div class="mb-6">
                <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                    {{ $producto->categoria->nombre }}
                </span>
            </div>

            <p class="text-gray-600 mb-6 leading-relaxed">{{ $producto->descripcion }}</p>

            <!-- Características -->
            <div class="flex flex-wrap gap-3 mb-6">
                @if($producto->es_vegetariano)
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                        🥬 Vegetariano
                    </span>
                @endif
                @if($producto->es_vegano)
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                        🌱 Vegano
                    </span>
                @endif
                @if($producto->es_sin_gluten)
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                        🌾 Sin Gluten
                    </span>
                @endif
            </div>

            <!-- Detalles -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-gray-900 mb-3">Detalles</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Tiempo de preparación:</span>
                        <span class="block font-medium">{{ $producto->tiempo_preparacion_min }} minutos</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Porciones:</span>
                        <span class="block font-medium">{{ $producto->porciones }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Vistas:</span>
                        <span class="block font-medium">{{ $producto->vistas }}</span>
                    </div>
                    @if($producto->stock_disponible !== null)
                        <div>
                            <span class="text-gray-500">Stock disponible:</span>
                            <span class="block font-medium">{{ $producto->stock_disponible }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ingredientes -->
            @if($producto->ingredientes && count($producto->ingredientes) > 0)
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Ingredientes</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($producto->ingredientes as $ingrediente)
                            <span class="bg-amber-50 text-amber-800 px-3 py-1 rounded text-sm">
                                {{ $ingrediente }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Alérgenos -->
            @if($producto->alergenos && count($producto->alergenos) > 0)
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Alérgenos</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($producto->alergenos as $alergeno)
                            <span class="bg-red-50 text-red-700 px-3 py-1 rounded text-sm">
                                ⚠️ {{ $alergeno }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Cocinero -->
            @if($producto->cocinero)
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Preparado por</h3>
                    <a href="{{ route('cocinero.detalle', $producto->cocinero->id) }}"
                       class="flex items-center bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center text-2xl">
                            @if($producto->cocinero->foto_perfil)
                                <img src="{{ asset('storage/' . $producto->cocinero->foto_perfil) }}"
                                     alt="{{ $producto->cocinero->nombre_completo }}"
                                     class="w-full h-full rounded-full object-cover">
                            @else
                                👨‍🍳
                            @endif
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">{{ $producto->cocinero->nombre_completo }}</h4>
                            <div class="flex items-center text-sm">
                                <span class="text-yellow-500">⭐</span>
                                <span class="ml-1">{{ number_format($producto->cocinero->calificacion_promedio, 1) }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Productos Relacionados -->
    @if($relacionados->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Productos Relacionados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relacionados as $rel)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($rel->primera_imagen)
                                <img src="{{ asset('storage/' . $rel->primera_imagen) }}"
                                     alt="{{ $rel->nombre }}"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl">🍽️</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-900 truncate">{{ $rel->nombre }}</h3>
                                <span class="text-amber-600 font-bold">{{ $rel->precio_formateado }}</span>
                            </div>
                            <a href="{{ route('producto.detalle', $rel->id) }}"
                               class="block text-center bg-amber-500 text-white py-2 rounded hover:bg-amber-600 transition">
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
