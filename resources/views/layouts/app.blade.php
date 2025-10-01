<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Reservas Deportivas')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Vite - AGREGADO -->
    @vite(['resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold">
                        <a href="{{ route('calendario') }}">Reservas Deportivas Arica</a>
                    </h1>
                    <p class="text-blue-200 text-sm">Municipalidad de Arica</p>
                </div>
                
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('calendario') }}" class="hover:text-blue-200 transition-colors">
                        Calendario
                    </a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-200 transition-colors">
                            Administración
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-blue-200 transition-colors">
                                Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-blue-200 transition-colors">
                            Iniciar Sesión
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Mensajes de alerta -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Contenido principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Municipalidad de Arica - Sistema de Reservas Deportivas</p>
            <p class="text-gray-400 text-sm mt-2">
                Epicentro 1 • Epicentro 2 • Fortín Sotomayor • Piscina Olímpica
            </p>
        </div>
    </footer>
</body>
</html>