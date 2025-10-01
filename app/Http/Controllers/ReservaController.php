<?php

namespace App\Http\Controllers;

use App\Models\Recinto;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservaController extends Controller
{
    public function create(Recinto $recinto)
    {
        return view('reservas.create', compact('recinto'));
    }
    
    public function store(Request $request)
    {
        // Validación básica (expandiremos esto después)
        $validated = $request->validate([
            'recinto_id' => 'required|exists:recintos,id',
            'rut' => 'required|string|max:12',
            'nombre_organizacion' => 'required|string|max:255',
            'representante_nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'email_confirmacion' => 'required|email|same:email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'cantidad_personas' => 'required|integer|min:1|max:500',
            'fecha_reserva' => 'required|date|after:today',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'observaciones' => 'nullable|string|max:1000',
            'acepta_reglamento' => 'required|accepted'
        ]);
        
        // Verificar disponibilidad
        $recinto = Recinto::find($validated['recinto_id']);
        if (!$recinto->disponibleEn($validated['fecha_reserva'], $validated['hora_inicio'], $validated['hora_fin'])) {
            return back()->withErrors(['horario' => 'El horario seleccionado no está disponible']);
        }
        
        // Crear la reserva
        $reserva = Reserva::create($validated);
        
        // TODO: Enviar correo de confirmación
        
        return redirect()->route('calendario')
            ->with('success', 'Reserva enviada exitosamente. Recibirá una confirmación por correo electrónico.');
    }
    
    public function show(Reserva $reserva)
    {
        return view('reservas.show', compact('reserva'));
    }
}