@extends('layouts.app')

@section('title', 'Cocineros - Cocineros')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Nuestros Cocineros</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($cocineros as $cocinero)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center text-3xl">
                        @if($cocinero->foto_perfil)
                            <img src="{{ asset('storage/' . $cocinero->foto_perfil) }}"
                                 alt="{{ $cocinero->nombre_completo }}"
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            👨‍🍳
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $cocinero->nombre_completo }}</h3>
                        <div class="flex items-center text-sm mt-1">
                            <span class="text-yellow-500">⭐</span>
                            <span class="ml-1 font-medium">{{ number_format($cocinero->calificacion_promedio, 1) }}</span>
                            <span class="text-gray-500 ml-2">({{ $cocinero->total_pedidos }} pedidos)</span>
                        </div>
                    </div>
                </div>

                <p class="text-gray-600 mb-4 line-clamp-3">
                    {{ $cocinero->bio ?? 'Cocinero profesional apasionado por la gastronomía local.' }}
                </p>

                <div class="flex flex-wrap gap-2 mb-4">
                    @if($cocinero->especialidades)
                        @foreach(array_slice($cocinero->especialidades, 0, 3) as $especialidad)
                            <span class="text-xs bg-amber-100 text-amber-700 px-2 py-1 rounded">
                                {{ $especialidad }}
                            </span>
                        @endforeach
                    @endif
                </div>

                <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                    <span>📍 {{ Str::limit($cocinero->direccion, 30) }}</span>
                    <span>🍽️ {{ $cocinero->productos_count }} productos</span>
                </div>

                <a href="{{ route('cocinero.detalle', $cocinero->id) }}"
                   class="block text-center bg-amber-500 text-white py-2 rounded hover:bg-amber-600 transition">
                    Ver Perfil
                </a>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                No hay cocineros disponibles
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-8">
        {{ $cocineros->links() }}
    </div>
</div>
@endsection
