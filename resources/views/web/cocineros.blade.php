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

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
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

                    <p class="text-gray-600 mb-5 line-clamp-3 leading-relaxed">
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
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div class="bg-gray-50 rounded-lg p-3 text-center">
                            <div class="font-bold text-primary-600 text-lg">{{ $cocinero->productos_count }}</div>
                            <div class="text-xs text-gray-500">Productos</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3 text-center">
                            <div class="font-bold text-primary-600 text-lg">{{ $cocinero->experiencia_anios ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Años exp.</div>
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
                <p class="text-gray-500">Pronto tendremos más cocineros disponibles para ti</p>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($cocineros->hasPages())
        <div class="mt-12">
            {{ $cocineros->links() }}
        </div>
    @endif
</div>
@endsection
