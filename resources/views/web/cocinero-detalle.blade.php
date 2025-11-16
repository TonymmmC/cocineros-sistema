@extends('layouts.app')

@section('title', $cocinero->nombre_completo . ' - Cocineros')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Inicio</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('cocineros') }}" class="text-gray-500 hover:text-gray-700">Cocineros</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-900">{{ $cocinero->nombre_completo }}</span>
    </nav>

    <!-- Perfil del Cocinero -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="flex flex-col md:flex-row items-start gap-8">
            <!-- Foto -->
            <div class="w-32 h-32 bg-amber-100 rounded-full flex items-center justify-center text-5xl flex-shrink-0">
                @if($cocinero->foto_perfil)
                    <img src="{{ asset('storage/' . $cocinero->foto_perfil) }}"
                         alt="{{ $cocinero->nombre_completo }}"
                         class="w-full h-full rounded-full object-cover">
                @else
                    👨‍🍳
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $cocinero->nombre_completo }}</h1>
                    <div class="flex items-center mt-2 sm:mt-0">
                        <span class="text-yellow-500 text-2xl">⭐</span>
                        <span class="ml-2 text-2xl font-bold">{{ number_format($cocinero->calificacion_promedio, 1) }}</span>
                        <span class="ml-2 text-gray-500">({{ $cocinero->total_pedidos }} pedidos)</span>
                    </div>
                </div>

                <p class="text-gray-600 mb-6 leading-relaxed">
                    {{ $cocinero->bio ?? 'Cocinero profesional apasionado por la gastronomía local.' }}
                </p>

                <!-- Especialidades -->
                @if($cocinero->especialidades && count($cocinero->especialidades) > 0)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Especialidades</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($cocinero->especialidades as $especialidad)
                                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $especialidad }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Estadísticas -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-amber-600">{{ $cocinero->productos_count }}</div>
                        <div class="text-sm text-gray-500">Productos</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-amber-600">{{ $cocinero->total_pedidos }}</div>
                        <div class="text-sm text-gray-500">Pedidos</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-amber-600">{{ $cocinero->experiencia_anios ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Años de exp.</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold {{ $cocinero->esta_disponible ? 'text-green-600' : 'text-red-600' }}">
                            {{ $cocinero->esta_disponible ? 'Sí' : 'No' }}
                        </div>
                        <div class="text-sm text-gray-500">Disponible</div>
                    </div>
                </div>

                <!-- Ubicación -->
                @if($cocinero->direccion)
                    <div class="mt-6">
                        <span class="text-gray-500">📍</span>
                        <span class="text-gray-700 ml-1">{{ $cocinero->direccion }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Productos del Cocinero -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Productos de {{ $cocinero->nombre_completo }}</h2>

        @if($productos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($productos as $producto)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($producto->primera_imagen)
                                <img src="{{ asset('storage/' . $producto->primera_imagen) }}"
                                     alt="{{ $producto->nombre }}"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl">🍽️</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-900 truncate">{{ $producto->nombre }}</h3>
                                <span class="text-amber-600 font-bold">{{ $producto->precio_formateado }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $producto->descripcion }}</p>

                            <div class="flex flex-wrap gap-2 mb-3">
                                @if($producto->es_vegetariano)
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Vegetariano</span>
                                @endif
                                @if($producto->es_vegano)
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Vegano</span>
                                @endif
                                @if($producto->es_sin_gluten)
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">Sin Gluten</span>
                                @endif
                            </div>

                            <div class="flex justify-between items-center text-xs text-gray-500 mb-3">
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $producto->categoria->nombre }}</span>
                                <span>⏱️ {{ $producto->tiempo_preparacion_min }} min</span>
                            </div>

                            <a href="{{ route('producto.detalle', $producto->id) }}"
                               class="block text-center bg-amber-500 text-white py-2 rounded hover:bg-amber-600 transition">
                                Ver Detalle
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $productos->links() }}
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                Este cocinero aún no tiene productos disponibles
            </div>
        @endif
    </div>
</div>
@endsection
