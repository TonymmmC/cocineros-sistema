@extends('layouts.app')

@section('title', 'Cocineros - Cocineros')

@section('content')
<!-- Header -->
<div class="bg-gradient-to-r from-primary-600 to-orange-500 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-white mb-2">Nuestros Cocineros</h1>
        <p class="text-white/80 text-lg">Conoce a los artistas detrás de cada platillo</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar de Filtros -->
        <div class="lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 sticky top-24">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900">Filtros</h2>
                    @if(request()->hasAny(['buscar', 'calificacion_min', 'especialidad', 'radio_min', 'ordenar']))
                        <a href="{{ route('cocineros') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                            Limpiar todo
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('cocineros') }}" id="filtrosCocineros">
                    <!-- Búsqueda -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Buscar cocinero</label>
                        <div class="relative">
                            <input type="text" name="buscar" value="{{ request('buscar') }}"
                                   placeholder="Nombre o biografía..."
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors text-sm">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Calificación mínima -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Calificación mínima</label>
                        <div class="space-y-2">
                            @foreach([4.5, 4.0, 3.5, 3.0] as $rating)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="calificacion_min" value="{{ $rating }}"
                                           {{ request('calificacion_min') == $rating ? 'checked' : '' }}
                                           class="w-4 h-4 text-yellow-500 border-gray-300 focus:ring-yellow-500">
                                    <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900 flex items-center">
                                        <span class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= floor($rating) ? 'text-yellow-400' : ($i - 0.5 <= $rating ? 'text-yellow-400' : 'text-gray-300') }}"
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </span>
                                        <span class="ml-2">{{ $rating }}+</span>
                                    </span>
                                </label>
                            @endforeach
                            @if(request('calificacion_min'))
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="calificacion_min" value=""
                                           class="w-4 h-4 text-gray-500 border-gray-300 focus:ring-gray-500">
                                    <span class="ml-3 text-sm text-gray-500 group-hover:text-gray-700">
                                        Sin filtro de calificación
                                    </span>
                                </label>
                            @endif
                        </div>
                    </div>

                    <!-- Especialidad -->
                    @if($especialidades->count() > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Especialidad</label>
                            <select name="especialidad" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white text-sm">
                                <option value="">Todas las especialidades</option>
                                @foreach($especialidades as $esp)
                                    <option value="{{ $esp }}" {{ request('especialidad') == $esp ? 'selected' : '' }}>
                                        {{ $esp }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Radio de entrega -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Radio de entrega mínimo</label>
                        <select name="radio_min" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white text-sm">
                            <option value="">Sin filtro</option>
                            <option value="2" {{ request('radio_min') == '2' ? 'selected' : '' }}>Al menos 2 km</option>
                            <option value="5" {{ request('radio_min') == '5' ? 'selected' : '' }}>Al menos 5 km</option>
                            <option value="10" {{ request('radio_min') == '10' ? 'selected' : '' }}>Al menos 10 km</option>
                            <option value="15" {{ request('radio_min') == '15' ? 'selected' : '' }}>Al menos 15 km</option>
                            <option value="20" {{ request('radio_min') == '20' ? 'selected' : '' }}>Al menos 20 km</option>
                        </select>
                    </div>

                    <!-- Ordenar por -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ordenar por</label>
                        <select name="ordenar" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors bg-white text-sm">
                            <option value="calificacion" {{ request('ordenar', 'calificacion') == 'calificacion' ? 'selected' : '' }}>Mejor calificados</option>
                            <option value="pedidos" {{ request('ordenar') == 'pedidos' ? 'selected' : '' }}>Más pedidos</option>
                            <option value="productos" {{ request('ordenar') == 'productos' ? 'selected' : '' }}>Más productos</option>
                            <option value="nombre" {{ request('ordenar') == 'nombre' ? 'selected' : '' }}>Nombre A-Z</option>
                            <option value="recientes" {{ request('ordenar') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
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
                    <span class="font-semibold text-gray-900">{{ $cocineros->total() }}</span> cocinero(s) encontrado(s)
                    @if(request('buscar'))
                        <span class="hidden sm:inline">para "<span class="font-medium text-primary-600">{{ request('buscar') }}</span>"</span>
                    @endif
                </div>

                <!-- Filtros activos -->
                @if(request()->hasAny(['calificacion_min', 'especialidad', 'radio_min']))
                    <div class="flex flex-wrap gap-2">
                        @if(request('calificacion_min'))
                            <span class="inline-flex items-center bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ request('calificacion_min') }}+
                            </span>
                        @endif
                        @if(request('especialidad'))
                            <span class="inline-flex items-center bg-primary-50 text-primary-700 px-3 py-1 rounded-full text-xs font-medium">
                                {{ request('especialidad') }}
                            </span>
                        @endif
                        @if(request('radio_min'))
                            <span class="inline-flex items-center bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">
                                ≥{{ request('radio_min') }} km
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Botón móvil para filtros -->
            <div class="lg:hidden mb-6">
                <button type="button" onclick="document.getElementById('mobile-filters-cocineros').classList.toggle('hidden')"
                        class="w-full py-3 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.586V4z"/>
                    </svg>
                    Mostrar Filtros
                </button>
            </div>

            <!-- Lista de Cocineros -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($cocineros as $cocinero)
                    <div class="group bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <!-- Header del cocinero -->
                        <div class="relative h-32 bg-gradient-to-br from-primary-500 to-orange-400">
                            <div class="absolute inset-0 bg-black/10"></div>
                            <div class="absolute -bottom-12 left-6">
                                <div class="w-24 h-24 bg-white rounded-full p-1 shadow-lg">
                                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center text-4xl overflow-hidden">
                                        <img src="{{ $cocinero->foto_url }}"
                                             alt="{{ $cocinero->nombre_completo }}"
                                             class="w-full h-full object-cover rounded-full">
                                    </div>
                                </div>
                            </div>
                            @if($cocinero->esta_disponible)
                                <div class="absolute top-4 right-4">
                                    <span class="bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full flex items-center">
                                        <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                        Disponible
                                    </span>
                                </div>
                            @endif
                            @if($cocinero->radio_entrega_km)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-medium px-2 py-1 rounded-full flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        {{ $cocinero->radio_entrega_km }} km
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Contenido -->
                        <div class="pt-16 p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-xl group-hover:text-primary-600 transition-colors">
                                        {{ $cocinero->nombre_completo }}
                                    </h3>
                                    <div class="flex items-center mt-2">
                                        <div class="flex items-center bg-yellow-50 px-3 py-1 rounded-full">
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="ml-1 font-bold text-gray-900">{{ number_format($cocinero->calificacion_promedio, 1) }}</span>
                                        </div>
                                        <span class="text-gray-500 text-sm ml-2">({{ $cocinero->total_pedidos }} pedidos)</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-gray-600 mb-5 line-clamp-3 leading-relaxed text-sm">
                                {{ $cocinero->bio ?? 'Cocinero profesional apasionado por crear experiencias culinarias únicas y sabores inolvidables.' }}
                            </p>

                            @if($cocinero->especialidades && count($cocinero->especialidades) > 0)
                                <div class="flex flex-wrap gap-2 mb-5">
                                    @foreach(array_slice($cocinero->especialidades, 0, 3) as $especialidad)
                                        <span class="text-xs bg-primary-50 text-primary-700 px-3 py-1 rounded-full font-medium">
                                            {{ $especialidad }}
                                        </span>
                                    @endforeach
                                    @if(count($cocinero->especialidades) > 3)
                                        <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">
                                            +{{ count($cocinero->especialidades) - 3 }} más
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-2 mb-5">
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <div class="font-bold text-primary-600 text-lg">{{ $cocinero->productos_count }}</div>
                                    <div class="text-xs text-gray-500">Productos</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <div class="font-bold text-primary-600 text-lg">{{ $cocinero->experiencia_anios ?? 0 }}</div>
                                    <div class="text-xs text-gray-500">Años exp.</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <div class="font-bold text-primary-600 text-lg">{{ $cocinero->total_pedidos }}</div>
                                    <div class="text-xs text-gray-500">Pedidos</div>
                                </div>
                            </div>

                            @if($cocinero->direccion)
                                <div class="flex items-center text-sm text-gray-500 mb-5">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $cocinero->direccion }}</span>
                                </div>
                            @endif

                            <a href="{{ route('cocinero.detalle', $cocinero->id) }}"
                               class="block text-center bg-gray-900 text-white py-3 rounded-xl font-medium hover:bg-primary-600 transition-colors duration-300">
                                Ver Perfil Completo
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay cocineros disponibles</h3>
                        <p class="text-gray-500 mb-6">Intenta con otros filtros de búsqueda</p>
                        <a href="{{ route('cocineros') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold">
                            Ver todos los cocineros
                            <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Paginación Mejorada -->
            @if($cocineros->hasPages())
                <div class="mt-10">
                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                Mostrando <span class="font-semibold">{{ $cocineros->firstItem() }}</span> a <span class="font-semibold">{{ $cocineros->lastItem() }}</span> de <span class="font-semibold">{{ $cocineros->total() }}</span> cocineros
                            </div>
                            <div>
                                {{ $cocineros->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Mobile Filters Modal -->
<div id="mobile-filters-cocineros" class="hidden lg:hidden fixed inset-0 bg-black/50 z-50" onclick="this.classList.add('hidden')">
    <div class="absolute right-0 top-0 h-full w-full max-w-sm bg-white overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900">Filtros</h2>
                <button type="button" onclick="document.getElementById('mobile-filters-cocineros').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-600">Utiliza el panel de filtros en la parte superior para filtrar los cocineros.</p>
        </div>
    </div>
</div>
@endsection
