@extends('layouts.app')

@section('title', 'Inicio - Cocineros')

@section('content')
<!-- Hero Section con Banner -->
<section class="relative overflow-hidden">
    {{-- Banner de fondo --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/banner.png') }}"
             alt="Banner Cocineros"
             class="w-full h-full object-cover"
             onerror="this.style.display='none'; this.parentElement.classList.add('bg-gradient-to-br', 'from-primary-600', 'via-primary-500', 'to-orange-400');">
    </div>
    {{-- Overlay para mejorar legibilidad del texto --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/70"></div>
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-orange-300/10 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
                Comida Casera,<br>
                <span class="text-orange-300">Sabor Auténtico</span>
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-10 max-w-3xl mx-auto leading-relaxed">
                Descubre platillos únicos preparados por cocineros locales apasionados.
                Cada bocado cuenta una historia.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('productos') }}"
                   class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-600 rounded-xl font-bold text-lg hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-xl">
                    <span>Explorar Productos</span>
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('cocineros') }}"
                   class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-xl font-bold text-lg hover:bg-white/10 transition-all duration-300">
                    Conocer Cocineros
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-white dark:bg-gray-900 py-12 -mt-8 relative z-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 grid grid-cols-2 md:grid-cols-4 gap-8 border border-gray-100 dark:border-gray-700">
            <div class="text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $productos->count() }}+</div>
                <div class="text-gray-600 dark:text-gray-400 mt-1">Productos</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $cocineros->count() }}+</div>
                <div class="text-gray-600 dark:text-gray-400 mt-1">Cocineros</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $categorias->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400 mt-1">Categorías</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">4.8</div>
                <div class="text-gray-600 dark:text-gray-400 mt-1">Calificación</div>
            </div>
        </div>
    </div>
</section>

<!-- Categorías -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Explora por Categoría</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Encuentra exactamente lo que buscas entre nuestra variedad de opciones</p>
        </div>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach($categorias as $categoria)
                <a href="{{ route('productos', ['categoria' => $categoria->id]) }}"
                   class="group px-6 py-3 bg-gray-100 dark:bg-gray-800 rounded-full text-gray-700 dark:text-gray-300 hover:bg-primary-500 hover:text-white font-medium transition-all duration-300 transform hover:scale-105 hover:shadow-lg border border-transparent dark:border-gray-700">
                    {{ $categoria->nombre }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Productos Destacados -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Productos Recientes</h2>
                <p class="text-gray-600 dark:text-gray-400">Los últimos platillos agregados por nuestros cocineros</p>
            </div>
            <a href="{{ route('productos') }}"
               class="hidden sm:inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold group">
                Ver todos
                <svg class="ml-1 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($productos as $producto)
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $producto->cocinero->nombre_completo ?? 'Sin cocinero' }}
                            </span>
                        </div>
                        <a href="{{ route('producto.detalle', $producto->id) }}"
                           class="block text-center bg-gray-900 dark:bg-gray-700 text-white py-3 rounded-xl font-medium hover:bg-primary-600 dark:hover:bg-primary-600 transition-colors duration-300">
                            Ver Detalle
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No hay productos disponibles</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('productos') }}"
               class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold">
                Ver todos los productos
                <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Cocineros Destacados -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Cocineros Destacados</h2>
                <p class="text-gray-600 dark:text-gray-400">Conoce a los artistas detrás de cada platillo</p>
            </div>
            <a href="{{ route('cocineros') }}"
               class="hidden sm:inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold group">
                Ver todos
                <svg class="ml-1 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($cocineros as $cocinero)
                <div class="group bg-gradient-to-br from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center mb-5">
                        <div class="relative">
                            <div class="w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/50 dark:to-primary-800/50 rounded-full flex items-center justify-center text-3xl overflow-hidden ring-4 ring-white dark:ring-gray-800 shadow-lg">
                                <img src="{{ $cocinero->foto_url }}"
                                     alt="{{ $cocinero->nombre_completo }}"
                                     class="w-full h-full object-cover">
                            </div>
                            @if($cocinero->esta_disponible)
                                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-4 border-white dark:border-gray-800"></div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg group-hover:text-primary-600 transition-colors">
                                {{ $cocinero->nombre_completo }}
                            </h3>
                            <div class="flex items-center mt-1">
                                <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 rounded-full">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="ml-1 font-semibold text-gray-900 dark:text-white">{{ number_format($cocinero->calificacion_promedio, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 mb-5 line-clamp-3 leading-relaxed">
                        {{ $cocinero->bio ?? 'Cocinero profesional apasionado por crear experiencias culinarias únicas.' }}
                    </p>

                    @if($cocinero->especialidades && count($cocinero->especialidades) > 0)
                        <div class="flex flex-wrap gap-2 mb-5">
                            @foreach(array_slice($cocinero->especialidades, 0, 3) as $especialidad)
                                <span class="text-xs bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 px-3 py-1 rounded-full font-medium">
                                    {{ $especialidad }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <a href="{{ route('cocinero.detalle', $cocinero->id) }}"
                       class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold group/link">
                        Ver perfil completo
                        <svg class="ml-1 w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No hay cocineros disponibles</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('cocineros') }}"
               class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold">
                Ver todos los cocineros
                <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-primary-600 to-orange-500">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            ¿Eres cocinero y quieres unirte?
        </h2>
        <p class="text-xl text-white/90 mb-8">
            Comparte tu talento culinario con miles de personas y genera ingresos haciendo lo que amas.
        </p>
        <a href="#"
           class="inline-flex items-center px-8 py-4 bg-white text-primary-600 rounded-xl font-bold text-lg hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-xl">
            Registrarme como Cocinero
        </a>
    </div>
</section>
@endsection
