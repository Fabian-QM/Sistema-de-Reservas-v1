@extends('layouts.app')

@section('title', 'Solicitar Reserva - ' . $recinto->nombre)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Solicitar Reserva</h1>
            <h2 class="text-xl text-blue-600 mb-4">{{ $recinto->nombre }}</h2>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700 mb-2">{{ $recinto->descripcion }}</p>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <strong>Capacidad máxima:</strong> {{ $recinto->capacidad_maxima }} personas
                    </div>
                    <div>
                        <strong>Horario:</strong> 
                        @if(is_array($recinto->horarios_disponibles))
                            {{ $recinto->horarios_disponibles['inicio'] }} - {{ $recinto->horarios_disponibles['fin'] }}
                        @else
                            08:00 - 23:00
                        @endif
                    </div>
                </div>
                
                @if($recinto->dias_cerrados)
                    @php
                        $esDiaCerrado = false;
                        if (is_array($recinto->dias_cerrados)) {
                            $esDiaCerrado = in_array('monday', $recinto->dias_cerrados);
                        } else {
                            $diasArray = json_decode($recinto->dias_cerrados, true);
                            if (is_array($diasArray)) {
                                $esDiaCerrado = in_array('monday', $diasArray);
                            }
                        }
                    @endphp
                    
                    @if($esDiaCerrado)
                    <div class="mt-2 text-red-600 font-medium">
                        ⚠️ Este recinto permanece cerrado todos los lunes por mantenimiento
                    </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('reservas.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="recinto_id" value="{{ $recinto->id }}">

                <!-- Información de la Organización -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Información de la Organización</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre_organizacion" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre del Club/Organización *
                            </label>
                            <input type="text" id="nombre_organizacion" name="nombre_organizacion" 
                                   value="{{ old('nombre_organizacion') }}" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('nombre_organizacion')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="representante_nombre" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre del Representante *
                            </label>
                            <input type="text" id="representante_nombre" name="representante_nombre" 
                                   value="{{ old('representante_nombre') }}" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('representante_nombre')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="rut" class="block text-sm font-medium text-gray-700 mb-1">
                                RUT del Representante *
                            </label>
                            <input type="text" id="rut" name="rut" value="{{ old('rut') }}" 
                                   placeholder="12345678-9" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('rut')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">
                                Teléfono de Contacto
                            </label>
                            <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" 
                                   placeholder="+56 9 8765 4321"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('telefono')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Correo Electrónico *
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email_confirmacion" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirmar Correo Electrónico *
                            </label>
                            <input type="email" id="email_confirmacion" name="email_confirmacion" 
                                   value="{{ old('email_confirmacion') }}" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('email_confirmacion')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">
                            Dirección de la Organización
                        </label>
                        <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" 
                               placeholder="Calle, número, comuna"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Información de la Reserva -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Detalles de la Reserva</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="fecha_reserva" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha de la Reserva *
                            </label>
                            <input type="date" id="fecha_reserva" name="fecha_reserva" 
                                   value="{{ old('fecha_reserva') }}" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="hora_inicio" class="block text-sm font-medium text-gray-700 mb-1">
                                Hora de Inicio *
                            </label>
                            <select id="hora_inicio" name="hora_inicio" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Seleccionar hora</option>
                                @for($hora = 8; $hora < 23; $hora++)
                                    <option value="{{ sprintf('%02d:00', $hora) }}">
                                        {{ sprintf('%02d:00', $hora) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="hora_fin" class="block text-sm font-medium text-gray-700 mb-1">
                                Hora de Término *
                            </label>
                            <select id="hora_fin" name="hora_fin" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Seleccionar hora</option>
                                @for($hora = 9; $hora <= 23; $hora++)
                                    <option value="{{ sprintf('%02d:00', $hora) }}">
                                        {{ sprintf('%02d:00', $hora) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="cantidad_personas" class="block text-sm font-medium text-gray-700 mb-1">
                            Cantidad de Personas *
                        </label>
                        <input type="number" id="cantidad_personas" name="cantidad_personas" 
                               value="{{ old('cantidad_personas') }}" 
                               min="1" max="{{ $recinto->capacidad_maxima }}" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-600 mt-1">
                            Máximo permitido: {{ $recinto->capacidad_maxima }} personas
                        </p>
                    </div>

                    <div class="mt-4">
                        <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">
                            Observaciones Adicionales
                        </label>
                        <textarea id="observaciones" name="observaciones" rows="3" 
                                  placeholder="Describa el tipo de actividad, equipamiento necesario, etc."
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('observaciones') }}</textarea>
                    </div>
                </div>

                <!-- Aceptación de Reglamento -->
                <div>
                    <div class="flex items-start">
                        <input type="checkbox" id="acepta_reglamento" name="acepta_reglamento" value="1" required
                               class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="acepta_reglamento" class="ml-2 text-sm text-gray-700">
                            Acepto el reglamento de uso de recintos deportivos municipales *
                        </label>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mt-4 text-sm text-gray-600">
                        <h4 class="font-medium text-gray-800 mb-2">Resumen de condiciones:</h4>
                        <ul class="space-y-1">
                            <li>• Uso exclusivo para actividades deportivas y recreativas</li>
                            <li>• Mantener el orden y limpieza del recinto</li>
                            <li>• Respetar horarios asignados</li>
                            <li>• La reserva está sujeta a aprobación municipal</li>
                            <li>• Prohibido el consumo de alcohol y sustancias prohibidas</li>
                        </ul>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-between">
                    <a href="{{ route('calendario') }}" 
                       class="px-6 py-2 text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-md transition-colors">
                        Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                        Enviar Solicitud de Reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection