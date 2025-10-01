<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Recinto;
use Illuminate\Http\Request;

class AdminReservaController extends Controller
{
    public function index(Request $request)
    {
        $query = Reserva::with(['recinto', 'aprobadaPor']);
        
        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        if ($request->filled('recinto_id')) {
            $query->where('recinto_id', $request->recinto_id);
        }
        
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_reserva', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_reserva', '<=', $request->fecha_hasta);
        }
        
        $reservas = $query->orderBy('created_at', 'desc')->paginate(20);
        $recintos = Recinto::activos()->get();
        
        return view('admin.reservas.index', compact('reservas', 'recintos'));
    }
    
    public function show(Reserva $reserva)
    {
        $reserva->load(['recinto', 'aprobadaPor']);
        return view('admin.reservas.show', compact('reserva'));
    }
    
    public function aprobar(Request $request, Reserva $reserva)
    {
        if ($reserva->estado !== 'pendiente') {
            return back()->withErrors(['error' => 'Solo se pueden aprobar reservas pendientes']);
        }
        
        $reserva->aprobar(auth()->id(), $request->observaciones);
        
        // TODO: Enviar correo de aprobación
        
        return back()->with('success', 'Reserva aprobada exitosamente');
    }
    
    public function rechazar(Request $request, Reserva $reserva)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500'
        ]);
        
        if ($reserva->estado !== 'pendiente') {
            return back()->withErrors(['error' => 'Solo se pueden rechazar reservas pendientes']);
        }
        
        $reserva->rechazar(auth()->id(), $request->motivo_rechazo);
        
        // TODO: Enviar correo de rechazo
        
        return back()->with('success', 'Reserva rechazada exitosamente');
    }
}