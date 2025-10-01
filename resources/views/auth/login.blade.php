@extends('layouts.app')

@section('title', 'Iniciar Sesión - Panel Administrativo')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Panel Administrativo</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Correo Electrónico
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Contraseña
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                Iniciar Sesión
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('calendario') }}" class="text-blue-600 hover:text-blue-500 text-sm">
                ← Volver al calendario
            </a>
        </div>

        <!-- Credenciales de prueba -->
        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
            <p class="text-sm font-medium text-yellow-800">Usuario de prueba:</p>
            <p class="text-xs text-yellow-700">jefe.recintos@municipalidadarica.cl / password123</p>
        </div>
    </div>
</div>
@endsection