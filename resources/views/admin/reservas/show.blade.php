@extends('layouts.app')

@section('title', 'Reserva #' . $reserva->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.reservas.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Volver a la lista
            </a>
        </div>

        <!-- Estado -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start">
                <h1 class="text-3xl font-bold text-gray-800">Reserva #{{ $reserva->id }}</h1>
                @if($reserva->estado === 'pendiente')
                    <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-800">PENDIENTE</span>
                @elseif($reserva->estado === 'aprobada')
                    <span class="px-4 py-2 rounded-full bg-green-100 text-green-800">APROBADA</span>
                @else
                    <span class="px-4 py-2 rounded-full bg-red-100 text-red-800">RECHAZADA</span>
                @endif
            </div>
        </div>

        <!-- Detalles -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Información del Recinto</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500">Recinto</label>
                    <p class="text-lg font-medium">{{ $reserva->recinto->nombre }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Fecha</label>
                    <p class="text-lg font-medium">{{ $reserva->fecha_reserva->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Horario</label>
                    <p class="text-lg font-medium">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Personas</label>
                    <p class="text-lg font-medium">{{ $reserva->cantidad_personas }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Información de la Organización</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500">Organización</label>
                    <p class="text-lg font-medium">{{ $reserva->nombre_organizacion }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Representante</label>
                    <p class="text-lg font-medium">{{ $reserva->representante_nombre }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">RUT</label>
                    <p class="text-lg font-medium">{{ $reserva->rut }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Email</label>
                    <p class="text-lg font-medium">{{ $reserva->email }}</p>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        @if($reserva->estado === 'pendiente')
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Acciones</h2>
            <div class="flex gap-4">
                <form method="POST" action="{{ route('admin.reservas.aprobar', $reserva) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-md">
                        Aprobar Reserva
                    </button>
                </form>
                <button onclick="document.getElementById('modal').classList.remove('hidden')" 
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 rounded-md">
                    Rechazar Reserva
                </button>
            </div>
        </div>

        <!-- Modal -->
        <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 max-w-md w-full">
                <h3 class="text-xl font-bold mb-4">Motivo del Rechazo</h3>
                <form method="POST" action="{{ route('admin.reservas.rechazar', $reserva) }}">
                    @csrf
                    <textarea name="motivo_rechazo" rows="4" required
                              class="w-full border rounded-md px-3 py-2 mb-4"></textarea>
                    <div class="flex gap-2">
                        <button type="button" onclick="document.getElementById('modal').classList.add('hidden')"
                                class="flex-1 bg-gray-300 py-2 rounded-md">Cancelar</button>
                        <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded-md">
                            Confirmar Rechazo
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection