@extends('layouts.app')

@section('title', 'Productos - Cocineros')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-primary-600 to-orange-500 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-white mb-2">Nuestros Productos</h1>
        <p class="text-white/80 text-lg">Descubre platillos únicos preparados con pasión</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Filtros -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
        <form method="GET" action="{{ route('productos') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <div class="relative">
                    <input type="text" name="buscar" value="{{ request('buscar') }}"
                           placeholder="Buscar productos..."
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <div class="w-full md:w-64">
                <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                <select name="categoria" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition-colors shadow-sm">
                    <span class="hidden sm:inline">Filtrar</span>
                    <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.586V4z"/>
                    </svg>
                </button>
                @if(request('buscar') || request('categoria'))
                    <a href="{{ route('productos') }}" class="px-6 py-3 text-gray-600 hover:text-gray-900 bg-gray-100 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                        Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Resultados -->
    @if(request('buscar') || request('categoria'))
        <div class="mb-6 text-gray-600">
            <span class="font-medium">{{ $productos->total() }}</span> producto(s) encontrado(s)
            @if(request('buscar'))
                para "<span class="font-medium text-gray-900">{{ request('buscar') }}</span>"
            @endif
        </div>
    @endif

    <!-- Lista de Productos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($productos as $producto)
            <div class="group bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                <div class="relative h-52 bg-gray-200 overflow-hidden">
                    @if($producto->primera_imagen)
                        <img src="{{ asset('storage/' . $producto->primera_imagen) }}"
                             alt="{{ $producto->nombre }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                            <span class="text-5xl opacity-50">🍽️</span>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <span class="bg-white/95 backdrop-blur-sm text-primary-600 font-bold px-3 py-1 rounded-full text-sm shadow-sm">
                            {{ $producto->precio_formateado }}
                        </span>
                    </div>
                    @if($producto->es_vegetariano || $producto->es_vegano)
                        <div class="absolute top-3 left-3">
                            <span class="bg-green-500 text-white text-xs font-medium px-2 py-1 rounded-full">
                                {{ $producto->es_vegano ? 'Vegano' : 'Vegetariano' }}
                            </span>
                        </div>
                    @endif
                    @if($producto->es_sin_gluten)
                        <div class="absolute bottom-3 left-3">
                            <span class="bg-blue-500 text-white text-xs font-medium px-2 py-1 rounded-full">
                                Sin Gluten
                            </span>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="mb-2">
                        <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                            {{ $producto->categoria->nombre }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-primary-600 transition-colors">
                        {{ $producto->nombre }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $producto->descripcion }}</p>

                    <div class="flex justify-between items-center text-xs text-gray-500 mb-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $producto->tiempo_preparacion_min }} min
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ $producto->porciones }} porc.
                        </span>
                    </div>

                    <a href="{{ route('producto.detalle', $producto->id) }}"
                       class="block text-center bg-gray-900 text-white py-3 rounded-xl font-medium hover:bg-primary-600 transition-colors duration-300">
                        Ver Detalle
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20">
                <div class="text-6xl mb-4 opacity-30">🔍</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No se encontraron productos</h3>
                <p class="text-gray-500 mb-6">Intenta con otros términos de búsqueda o categoría</p>
                <a href="{{ route('productos') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold">
                    Ver todos los productos
                    <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($productos->hasPages())
        <div class="mt-10">
            {{ $productos->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
