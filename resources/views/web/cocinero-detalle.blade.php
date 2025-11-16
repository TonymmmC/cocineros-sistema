@extends('layouts.app')

@section('title', $cocinero->nombre_completo . ' - Cocineros')

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
                <a href="{{ route('cocineros') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Cocineros</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </li>
            <li>
                <span class="text-gray-900 dark:text-white font-medium">{{ $cocinero->nombre_completo }}</span>
            </li>
        </ol>
    </nav>

    <!-- Perfil del Cocinero -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 mb-12">
        <!-- Header con gradiente -->
        <div class="relative h-48 bg-gradient-to-br from-primary-500 via-primary-600 to-orange-500">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute inset-0">
                <div class="absolute top-10 left-20 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-10 right-20 w-40 h-40 bg-orange-300/20 rounded-full blur-2xl"></div>
            </div>
        </div>

        <div class="relative px-8 pb-8">
            <!-- Foto de perfil -->
            <div class="absolute -top-16 left-8">
                <div class="w-32 h-32 bg-white dark:bg-gray-900 rounded-full p-1 shadow-xl">
                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/50 dark:to-primary-800/50 rounded-full flex items-center justify-center text-5xl overflow-hidden">
                        <img src="{{ $cocinero->foto_url }}"
                             alt="{{ $cocinero->nombre_completo }}"
                             class="w-full h-full object-cover rounded-full">
                    </div>
                </div>
            </div>

            <!-- Badge de disponibilidad -->
            @if($cocinero->esta_disponible)
                <div class="absolute top-4 right-8">
                    <span class="bg-green-500 text-white text-sm font-medium px-4 py-2 rounded-full flex items-center shadow-sm">
                        <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                        Disponible para pedidos
                    </span>
                </div>
            @else
                <div class="absolute top-4 right-8">
                    <span class="bg-gray-500 text-white text-sm font-medium px-4 py-2 rounded-full shadow-sm">
                        No disponible
                    </span>
                </div>
            @endif

            <!-- Información -->
            <div class="pt-20">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-6">
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-3">{{ $cocinero->nombre_completo }}</h1>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/30 px-4 py-2 rounded-full">
                                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="ml-2 text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($cocinero->calificacion_promedio, 1) }}</span>
                            </div>
                            <span class="text-gray-500 dark:text-gray-400">({{ $cocinero->total_pedidos }} pedidos completados)</span>
                        </div>
                    </div>
                </div>

                <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed mb-8 max-w-3xl">
                    {{ $cocinero->bio ?? 'Cocinero profesional apasionado por crear experiencias culinarias únicas y sabores inolvidables. Cada platillo es preparado con los mejores ingredientes y mucho amor.' }}
                </p>

                <!-- Especialidades -->
                @if($cocinero->especialidades && count($cocinero->especialidades) > 0)
                    <div class="mb-8">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            Especialidades
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($cocinero->especialidades as $especialidad)
                                <span class="bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 px-4 py-2 rounded-full font-medium">
                                    {{ $especialidad }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Estadísticas -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-primary-50 to-white dark:from-primary-900/30 dark:to-gray-900 rounded-xl p-6 text-center border border-primary-100 dark:border-primary-800">
                        <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-1">{{ $cocinero->productos_count }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Productos</div>
                    </div>
                    <div class="bg-gradient-to-br from-primary-50 to-white dark:from-primary-900/30 dark:to-gray-900 rounded-xl p-6 text-center border border-primary-100 dark:border-primary-800">
                        <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-1">{{ $cocinero->total_pedidos }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Pedidos</div>
                    </div>
                    <div class="bg-gradient-to-br from-primary-50 to-white dark:from-primary-900/30 dark:to-gray-900 rounded-xl p-6 text-center border border-primary-100 dark:border-primary-800">
                        <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-1">{{ $cocinero->experiencia_anios ?? 0 }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Años de exp.</div>
                    </div>
                    <div class="bg-gradient-to-br from-primary-50 to-white dark:from-primary-900/30 dark:to-gray-900 rounded-xl p-6 text-center border border-primary-100 dark:border-primary-800">
                        <div class="text-3xl font-bold {{ $cocinero->esta_disponible ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mb-1">
                            {{ $cocinero->esta_disponible ? 'Sí' : 'No' }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">Disponible</div>
                    </div>
                </div>

                <!-- Ubicación -->
                @if($cocinero->direccion)
                    <div class="flex items-center text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="font-medium">{{ $cocinero->direccion }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Productos del Cocinero -->
    <div>
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Productos de {{ $cocinero->nombre_completo }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $productos->total() }} producto(s) disponible(s)</p>
            </div>
        </div>

        @if($productos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($productos as $producto)
                    <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                        <div class="relative h-52 bg-gray-200 dark:bg-gray-700 overflow-hidden">
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
                            <div class="mb-2">
                                <span class="text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-2 py-1 rounded">
                                    {{ $producto->categoria->nombre }}
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary-600 transition-colors">
                                {{ $producto->nombre }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $producto->descripcion }}</p>

                            <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400 mb-4">
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
                               class="block text-center bg-gray-900 dark:bg-gray-700 text-white py-3 rounded-xl font-medium hover:bg-primary-600 dark:hover:bg-primary-600 transition-colors duration-300">
                                Ver Detalle
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($productos->hasPages())
                <div class="mt-12">
                    {{ $productos->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700">
                <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Sin productos disponibles</h3>
                <p class="text-gray-500 dark:text-gray-400">Este cocinero aún no tiene productos publicados</p>
            </div>
        @endif
    </div>
</div>
@endsection
