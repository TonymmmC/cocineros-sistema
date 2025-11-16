@extends('layouts.app')

@section('title', 'Mis Favoritos - Cocineros')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mis Favoritos</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Productos que has guardado</p>
    </div>

    @if($favoritos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($favoritos as $favorito)
                @if($favorito->producto)
                    <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                        <div class="relative h-52 bg-gray-200 dark:bg-gray-700 overflow-hidden">
                            <img src="{{ $favorito->producto->imagen_url }}"
                                 alt="{{ $favorito->producto->nombre }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-3 right-3">
                                <span class="bg-white/95 backdrop-blur-sm text-primary-600 font-bold px-3 py-1 rounded-full text-sm shadow-sm">
                                    {{ $favorito->producto->precio_formateado }}
                                </span>
                            </div>
                            <button class="absolute top-3 left-3 p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                        <div class="p-5">
                            <div class="mb-2">
                                <span class="text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 px-2 py-1 rounded">
                                    {{ $favorito->producto->categoria->nombre ?? 'Sin categoría' }}
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                {{ $favorito->producto->nombre }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $favorito->producto->descripcion }}</p>

                            @if($favorito->producto->cocinero)
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $favorito->producto->cocinero->nombre_completo }}
                                </div>
                            @endif

                            <a href="{{ route('producto.detalle', $favorito->producto->id) }}"
                               class="block text-center bg-gray-900 dark:bg-gray-700 text-white py-3 rounded-xl font-medium hover:bg-primary-600 dark:hover:bg-primary-600 transition-colors duration-300">
                                Ver Detalle
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        @if($favoritos->hasPages())
            <div class="mt-10">
                {{ $favoritos->links() }}
            </div>
        @endif
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No tienes favoritos</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Explora productos y guarda tus favoritos para encontrarlos fácilmente</p>
            <a href="{{ route('productos') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition-colors">
                Explorar Productos
            </a>
        </div>
    @endif
</div>
@endsection
