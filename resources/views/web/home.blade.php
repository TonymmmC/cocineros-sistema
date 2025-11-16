@extends('layouts.app')

@section('title', 'Inicio - Cocineros')

@section('content')
<!-- Hero -->
<section class="bg-gradient-to-r from-amber-500 to-orange-500 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Comida Casera, Sabor Auténtico
        </h1>
        <p class="text-xl md:text-2xl mb-8 opacity-90">
            Conectamos cocineros locales con amantes de la buena comida
        </p>
        <a href="{{ route('productos') }}" class="bg-white text-amber-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition">
            Ver Productos
        </a>
    </div>
</section>

<!-- Categorías -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Categorías</h2>
        <div class="flex flex-wrap gap-3">
            @foreach($categorias as $categoria)
                <a href="{{ route('productos', ['categoria' => $categoria->id]) }}"
                   class="px-4 py-2 bg-gray-100 rounded-full text-gray-700 hover:bg-amber-100 hover:text-amber-700 transition">
                    {{ $categoria->nombre }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Productos Destacados -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Productos Recientes</h2>
            <a href="{{ route('productos') }}" class="text-amber-600 hover:text-amber-700 font-medium">
                Ver todos →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($productos as $producto)
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
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span class="bg-gray-100 px-2 py-1 rounded">{{ $producto->categoria->nombre }}</span>
                            <span>{{ $producto->cocinero->nombre_completo ?? 'Sin cocinero' }}</span>
                        </div>
                        <a href="{{ route('producto.detalle', $producto->id) }}"
                           class="mt-3 block text-center bg-amber-500 text-white py-2 rounded hover:bg-amber-600 transition">
                            Ver Detalle
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    No hay productos disponibles
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Cocineros Destacados -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Cocineros Destacados</h2>
            <a href="{{ route('cocineros') }}" class="text-amber-600 hover:text-amber-700 font-medium">
                Ver todos →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($cocineros as $cocinero)
                <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center text-2xl">
                            @if($cocinero->foto_perfil)
                                <img src="{{ asset('storage/' . $cocinero->foto_perfil) }}"
                                     alt="{{ $cocinero->nombre_completo }}"
                                     class="w-full h-full rounded-full object-cover">
                            @else
                                👨‍🍳
                            @endif
                        </div>
                        <div class="ml-4">
                            <h3 class="font-semibold text-gray-900">{{ $cocinero->nombre_completo }}</h3>
                            <div class="flex items-center text-sm">
                                <span class="text-yellow-500">⭐</span>
                                <span class="ml-1">{{ number_format($cocinero->calificacion_promedio, 1) }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $cocinero->bio ?? 'Cocinero profesional' }}
                    </p>
                    <a href="{{ route('cocinero.detalle', $cocinero->id) }}"
                       class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                        Ver perfil →
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    No hay cocineros disponibles
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
