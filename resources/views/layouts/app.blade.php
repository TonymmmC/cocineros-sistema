<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cocineros - Comida Casera')</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-3xl">🍳</span>
                    <span class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-primary-500 bg-clip-text text-transparent">
                        Cocineros
                    </span>
                </a>

                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                       class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50' : '' }}">
                        Inicio
                    </a>
                    <a href="{{ route('productos') }}"
                       class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 {{ request()->routeIs('productos') ? 'text-primary-600 bg-primary-50' : '' }}">
                        Productos
                    </a>
                    <a href="{{ route('cocineros') }}"
                       class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary-600 hover:bg-primary-50 font-medium transition-all duration-200 {{ request()->routeIs('cocineros') ? 'text-primary-600 bg-primary-50' : '' }}">
                        Cocineros
                    </a>
                </nav>

                <!-- Mobile menu button -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile menu -->
            <div x-show="mobileMenu" x-cloak x-transition class="md:hidden pb-4 border-t border-gray-100 mt-2 pt-4">
                <a href="{{ route('home') }}" class="block py-2 px-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Inicio</a>
                <a href="{{ route('productos') }}" class="block py-2 px-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Productos</a>
                <a href="{{ route('cocineros') }}" class="block py-2 px-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 font-medium">Cocineros</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-3xl">🍳</span>
                        <span class="text-2xl font-bold text-white">Cocineros</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed max-w-md">
                        Conectamos a los mejores cocineros locales con amantes de la buena comida.
                        Disfruta de platillos caseros preparados con pasión y los mejores ingredientes.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Enlaces</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Inicio</a></li>
                        <li><a href="{{ route('productos') }}" class="hover:text-primary-400 transition-colors">Productos</a></li>
                        <li><a href="{{ route('cocineros') }}" class="hover:text-primary-400 transition-colors">Cocineros</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Contacto</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <span>📧</span>
                            <span>info@cocineros.com</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span>📱</span>
                            <span>+591 123 456 789</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span>📍</span>
                            <span>La Paz, Bolivia</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500">
                <p>&copy; {{ date('Y') }} Cocineros. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
