@extends('layouts.app')

@section('title', 'Gestionar Reservas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Reservas</h1>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                    <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobadas</option>
                    <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazadas</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recinto</label>
                <select name="recinto_id" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Todos</option>
                    @foreach($recintos as $recinto)
                        <option value="{{ $recinto->id }}">{{ $recinto->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                <input type="date" name="fecha_desde" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                <input type="date" name="fecha_hasta" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="md:col-span-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Reservas -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organización</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recinto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($reservas as $reserva)
                <tr>
                    <td class="px-6 py-4 text-sm">#{{ $reserva->id }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $reserva->nombre_organizacion }}</div>
                        <div class="text-sm text-gray-500">{{ $reserva->representante_nombre }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $reserva->recinto->nombre }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm">{{ $reserva->fecha_reserva->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($reserva->estado === 'pendiente')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                        @elseif($reserva->estado === 'aprobada')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aprobada</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rechazada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.reservas.show', $reserva) }}" class="text-blue-600 hover:text-blue-800">
                            Ver Detalles
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No hay reservas registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection