@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-stone-900 dark:text-white">Mi Perfil</h1>
            <p class="text-stone-500 dark:text-stone-400 mt-2">Administra tu información personal</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Profile Card -->
            <div class="bg-white dark:bg-stone-800 rounded-xl shadow-md border border-stone-200 dark:border-stone-700 overflow-hidden">
                <!-- Card Header with Avatar -->
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-8">
                    <div class="flex items-center space-x-4">
                        <div class="w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-3xl font-bold border-4 border-white/30">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="text-white">
                            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                            <p class="text-amber-100">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Info Form -->
                <form method="POST" action="{{ route('perfil.update') }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                                Nombre Completo
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email (readonly) -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                                Correo Electrónico
                            </label>
                            <input
                                type="email"
                                id="email"
                                value="{{ $user->email }}"
                                disabled
                                class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-stone-100 dark:bg-stone-600 text-stone-500 dark:text-stone-400 cursor-not-allowed"
                            >
                            <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">El email no se puede cambiar</p>
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
                                value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                placeholder="+593 999 999 999"
                            >
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                                Rol
                            </label>
                            <div class="px-4 py-3 rounded-lg bg-stone-100 dark:bg-stone-600 text-stone-700 dark:text-stone-300 font-medium">
                                @switch($user->role)
                                    @case('superadmin')
                                        <span class="inline-flex items-center">
                                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                            Super Administrador
                                        </span>
                                        @break
                                    @case('admin')
                                        <span class="inline-flex items-center">
                                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                            Administrador
                                        </span>
                                        @break
                                    @case('cocinero')
                                        <span class="inline-flex items-center">
                                            <span class="w-2 h-2 bg-amber-500 rounded-full mr-2"></span>
                                            Cocinero
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            Cliente
                                        </span>
                                @endswitch
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 focus:ring-4 focus:ring-amber-500/50"
                        >
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-stone-800 rounded-xl shadow-md border border-stone-200 dark:border-stone-700 p-6">
                <h3 class="text-lg font-semibold text-stone-900 dark:text-white mb-4">Acciones Rápidas</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if($user->hasAdminAccess())
                        <a href="{{ url('/admin') }}" class="flex items-center p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors group">
                            <div class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-stone-900 dark:text-white">Panel Admin</p>
                                <p class="text-sm text-stone-500 dark:text-stone-400">Gestionar sistema</p>
                            </div>
                        </a>
                    @elseif($user->isCocinero())
                        <a href="{{ url('/admin') }}" class="flex items-center p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors group">
                            <div class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-stone-900 dark:text-white">Gestionar Mi Cocina</p>
                                <p class="text-sm text-stone-500 dark:text-stone-400">Mis productos y pedidos</p>
                            </div>
                        </a>
                    @endif

                    <a href="{{ url('/') }}" class="flex items-center p-4 bg-stone-50 dark:bg-stone-700/50 rounded-lg hover:bg-stone-100 dark:hover:bg-stone-700 transition-colors group">
                        <div class="w-12 h-12 bg-stone-500 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-stone-900 dark:text-white">Inicio</p>
                            <p class="text-sm text-stone-500 dark:text-stone-400">Volver al inicio</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white dark:bg-stone-800 rounded-xl shadow-md border border-stone-200 dark:border-stone-700 p-6">
                <h3 class="text-lg font-semibold text-stone-900 dark:text-white mb-4">Cambiar Contraseña</h3>
                <form method="POST" action="{{ route('perfil.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                            Contraseña Actual
                        </label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            required
                            class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        >
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                                Nueva Contraseña
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                            >
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-stone-700 dark:text-stone-300 mb-2">
                                Confirmar Nueva Contraseña
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                class="w-full px-4 py-3 rounded-lg border border-stone-300 dark:border-stone-600 bg-white dark:bg-stone-700 text-stone-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                            >
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-6 py-3 bg-stone-600 hover:bg-stone-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 focus:ring-4 focus:ring-stone-500/50"
                        >
                            Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
