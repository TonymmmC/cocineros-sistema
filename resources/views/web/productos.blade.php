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
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar de Filtros -->
        <div class="lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 sticky top-24">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900">Filtros</h2>
                    @if(request()->hasAny(['buscar', 'categoria', 'precio_min', 'precio_max', 'vegetariano', 'vegano', 'sin_gluten', 'tiempo_max', 'ordenar']))
                        <a href="{{ route('productos') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                            Limpiar todo
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('productos') }}" id="filtrosForm">
                    <!-- Búsqueda -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Buscar</label>
                        <div class="relative">
                            <input type="text" name="buscar" value="{{ request('buscar') }}"
                                   placeholder="Nombre o descripción..."
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors text-sm">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Categoría -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Categoría</label>
                        <select name="categoria" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white text-sm">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rango de Precio -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rango de Precio</label>
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                                <input type="number" name="precio_min" value="{{ request('precio_min') }}"
                                       placeholder="{{ number_format($precioMin, 0) }}"
                                       min="0" step="0.01"
                                       class="w-full pl-7 pr-2 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                            </div>
                            <span class="text-gray-400">-</span>
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                                <input type="number" name="precio_max" value="{{ request('precio_max') }}"
                                       placeholder="{{ number_format($precioMax, 0) }}"
                                       min="0" step="0.01"
                                       class="w-full pl-7 pr-2 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Tiempo de Preparación -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tiempo máximo de preparación</label>
                        <select name="tiempo_max" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white text-sm">
                            <option value="">Sin límite</option>
                            <option value="15" {{ request('tiempo_max') == '15' ? 'selected' : '' }}>Hasta 15 min</option>
                            <option value="30" {{ request('tiempo_max') == '30' ? 'selected' : '' }}>Hasta 30 min</option>
                            <option value="45" {{ request('tiempo_max') == '45' ? 'selected' : '' }}>Hasta 45 min</option>
                            <option value="60" {{ request('tiempo_max') == '60' ? 'selected' : '' }}>Hasta 1 hora</option>
                            <option value="90" {{ request('tiempo_max') == '90' ? 'selected' : '' }}>Hasta 1.5 horas</option>
                        </select>
                    </div>

                    <!-- Características Dietéticas -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Preferencias alimentarias</label>
                        <div class="space-y-3">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="vegetariano" value="1" {{ request('vegetariano') ? 'checked' : '' }}
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900">
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Vegetariano
                                    </span>
                                </span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="vegano" value="1" {{ request('vegano') ? 'checked' : '' }}
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900">
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Vegano
                                    </span>
                                </span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="sin_gluten" value="1" {{ request('sin_gluten') ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900">
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Sin Gluten
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Ordenar por -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ordenar por</label>
                        <select name="ordenar" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white text-sm">
                            <option value="recientes" {{ request('ordenar', 'recientes') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                            <option value="precio_asc" {{ request('ordenar') == 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                            <option value="precio_desc" {{ request('ordenar') == 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                            <option value="popular" {{ request('ordenar') == 'popular' ? 'selected' : '' }}>Más populares</option>
                            <option value="nombre" {{ request('ordenar') == 'nombre' ? 'selected' : '' }}>Nombre A-Z</option>
                        </select>
                    </div>

                    <!-- Botón Aplicar -->
                    <button type="submit" class="w-full py-3 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors shadow-sm flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.586V4z"/>
                        </svg>
                        Aplicar Filtros
                    </button>
                </form>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="flex-1">
            <!-- Barra de resultados -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-gray-600">
                    <span class="font-semibold text-gray-900">{{ $productos->total() }}</span> producto(s) encontrado(s)
                    @if(request('buscar'))
                        <span class="hidden sm:inline">para "<span class="font-medium text-primary-600">{{ request('buscar') }}</span>"</span>
                    @endif
                </div>

                <!-- Filtros activos -->
                @if(request()->hasAny(['categoria', 'precio_min', 'precio_max', 'vegetariano', 'vegano', 'sin_gluten', 'tiempo_max']))
                    <div class="flex flex-wrap gap-2">
                        @if(request('categoria'))
                            @php $catActiva = $categorias->firstWhere('id', request('categoria')); @endphp
                            @if($catActiva)
                                <span class="inline-flex items-center bg-primary-50 text-primary-700 px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $catActiva->nombre }}
                                    <a href="{{ request()->fullUrlWithQuery(['categoria' => null]) }}" class="ml-1 hover:text-primary-900">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </a>
                                </span>
                            @endif
                        @endif
                        @if(request('vegetariano'))
                            <span class="inline-flex items-center bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                                Vegetariano
                            </span>
                        @endif
                        @if(request('vegano'))
                            <span class="inline-flex items-center bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                                Vegano
                            </span>
                        @endif
                        @if(request('sin_gluten'))
                            <span class="inline-flex items-center bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">
                                Sin Gluten
                            </span>
                        @endif
                        @if(request('tiempo_max'))
                            <span class="inline-flex items-center bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">
                                ≤{{ request('tiempo_max') }} min
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Botón móvil para abrir filtros -->
            <div class="lg:hidden mb-6">
                <button type="button" onclick="document.getElementById('mobile-filters').classList.toggle('hidden')"
                        class="w-full py-3 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.586V4z"/>
                    </svg>
                    Mostrar Filtros
                </button>
            </div>

            <!-- Lista de Productos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($productos as $producto)
                    <div class="group bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100">
                        <div class="relative h-52 bg-gray-200 overflow-hidden">
                            <img src="{{ $producto->imagen_url }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
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
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                                    {{ $producto->categoria->nombre }}
                                </span>
                                @if($producto->cocinero)
                                    <span class="text-xs text-gray-500 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $producto->cocinero->nombre_completo }}
                                    </span>
                                @endif
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
                                <span class="flex items-center text-yellow-500">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $producto->vistas }}
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
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No se encontraron productos</h3>
                        <p class="text-gray-500 mb-6">Intenta con otros filtros o términos de búsqueda</p>
                        <a href="{{ route('productos') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold">
                            Ver todos los productos
                            <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Paginación Mejorada -->
            @if($productos->hasPages())
                <div class="mt-10">
                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                Mostrando <span class="font-semibold">{{ $productos->firstItem() }}</span> a <span class="font-semibold">{{ $productos->lastItem() }}</span> de <span class="font-semibold">{{ $productos->total() }}</span> resultados
                            </div>
                            <div>
                                {{ $productos->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mobile Filters Modal -->
<div id="mobile-filters" class="hidden lg:hidden fixed inset-0 bg-black/50 z-50" onclick="this.classList.add('hidden')">
    <div class="absolute right-0 top-0 h-full w-full max-w-sm bg-white overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">Filtros</h2>
                <button type="button" onclick="document.getElementById('mobile-filters').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <!-- El mismo formulario se puede clonar aquí para móvil si es necesario -->
            <p class="text-sm text-gray-600">Utiliza el panel de filtros en la parte superior para filtrar los productos.</p>
        </div>
    </div>
</div>
@endsection
