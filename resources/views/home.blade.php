@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-amber-50 to-stone-100 dark:from-stone-900 dark:to-stone-800 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23d97706\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-stone-900 dark:text-white mb-6">
                Sabores Auténticos,
                <span class="text-amber-600 dark:text-amber-500">Cerca de Ti</span>
            </h1>
            <p class="text-lg sm:text-xl text-stone-600 dark:text-stone-300 max-w-3xl mx-auto mb-10">
                Descubre la mejor comida casera preparada por cocineros locales apasionados.
                Platos frescos, sabores tradicionales y la calidez del hogar en cada bocado.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                        Comenzar Ahora
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-white dark:bg-stone-700 hover:bg-stone-50 dark:hover:bg-stone-600 text-stone-900 dark:text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-lg border border-stone-200 dark:border-stone-600">
                        Iniciar Sesión
                    </a>
                @else
                    <a href="{{ route('perfil') }}" class="px-8 py-4 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                        Ir a Mi Perfil
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-20 bg-white dark:bg-stone-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-stone-900 dark:text-white mb-4">¿Por qué elegirnos?</h2>
            <p class="text-stone-600 dark:text-stone-400 max-w-2xl mx-auto">
                Conectamos a los mejores cocineros caseros con personas que valoran la comida auténtica
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-stone-50 dark:bg-stone-700/50 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-stone-900 dark:text-white mb-3">Comida Casera</h3>
                <p class="text-stone-600 dark:text-stone-400">
                    Platos preparados con amor y recetas familiares transmitidas por generaciones
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-stone-50 dark:bg-stone-700/50 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-stone-900 dark:text-white mb-3">Cerca de Ti</h3>
                <p class="text-stone-600 dark:text-stone-400">
                    Encuentra cocineros en tu zona y recibe comida fresca sin largos tiempos de espera
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-stone-50 dark:bg-stone-700/50 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-stone-900 dark:text-white mb-3">Confianza</h3>
                <p class="text-stone-600 dark:text-stone-400">
                    Cocineros verificados y valoraciones reales de nuestra comunidad
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="py-20 bg-amber-600 dark:bg-amber-700">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">
            ¿Eres cocinero? Únete a nuestra plataforma
        </h2>
        <p class="text-amber-100 text-lg mb-8">
            Comparte tus recetas favoritas, genera ingresos extra y conecta con clientes que valoran la autenticidad
        </p>
        @guest
            <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-amber-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg hover:bg-amber-50">
                Regístrate como Cocinero
            </a>
        @else
            @if(auth()->user()->isCliente())
                <p class="text-white/90">
                    Contacta con el administrador para convertirte en cocinero
                </p>
            @endif
        @endguest
    </div>
</div>
@endsection
