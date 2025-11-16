@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white dark:bg-stone-800 rounded-2xl shadow-xl border border-stone-200 dark:border-stone-700 p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-stone-900 dark:text-white">Crear una cuenta</h2>
                <p class="text-stone-500 dark:text-stone-400 mt-2">Únete a nuestra comunidad de sabores</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                        Nombre Completo
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white placeholder-stone-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder="Tu nombre"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                        Correo Electrónico
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white placeholder-stone-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder="tu@email.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                        Teléfono
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white placeholder-stone-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder="+593 999 999 999"
                    >
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                        Contraseña
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white placeholder-stone-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                        Confirmar Contraseña
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white placeholder-stone-400 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder="••••••••"
                    >
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 focus:ring-4 focus:ring-amber-500/50"
                >
                    Crear Cuenta
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6 text-center">
                <p class="text-stone-500 dark:text-stone-400">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" class="text-amber-600 dark:text-amber-500 hover:underline font-medium">
                        Inicia sesión
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
