<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cocineros - Comida Casera')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-amber-600">
                    🍳 Cocineros
                </a>

                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-amber-600 font-medium">
                        Inicio
                    </a>
                    <a href="{{ route('productos') }}" class="text-gray-700 hover:text-amber-600 font-medium">
                        Productos
                    </a>
                    <a href="{{ route('cocineros') }}" class="text-gray-700 hover:text-amber-600 font-medium">
                        Cocineros
                    </a>
                </nav>

                <div class="flex items-center space-x-4">
                    <a href="{{ url('/admin') }}" class="text-sm text-gray-600 hover:text-amber-600">
                        Admin
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">🍳 Cocineros</h3>
                    <p class="text-gray-400">
                        Conectamos cocineros caseros con personas que buscan comida auténtica y deliciosa.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Inicio</a></li>
                        <li><a href="{{ route('productos') }}" class="hover:text-white">Productos</a></li>
                        <li><a href="{{ route('cocineros') }}" class="hover:text-white">Cocineros</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contacto</h4>
                    <p class="text-gray-400">
                        contacto@cocineros.com<br>
                        +591 123 456 789
                    </p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                &copy; {{ date('Y') }} Cocineros. Todos los derechos reservados.
            </div>
        </div>
    </footer>
</body>
</html>
