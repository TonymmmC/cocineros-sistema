@extends('layouts.app')

@section('title', 'Productos - Cocineros')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Productos</h1>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" action="{{ route('productos') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       placeholder="Buscar productos..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            </div>
            <div class="w-48">
                <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-amber-500 text-white px-6 py-2 rounded-lg hover:bg-amber-600 transition">
                Filtrar
            </button>
            @if(request('buscar') || request('categoria'))
                <a href="{{ route('productos') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    <!-- Lista de Productos -->
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
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                No se encontraron productos
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $productos->withQueryString()->links() }}
    </div>
</div>
@endsection
