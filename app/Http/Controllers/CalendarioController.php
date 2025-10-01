<?php

namespace App\Http\Controllers;

use App\Models\Recinto;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index()
    {
        // Obtener todos los recintos activos
        $recintos = Recinto::activos()->get();
        
        // Obtener fecha actual y próximos 30 días
        $fechaInicio = Carbon::now()->startOfDay();
        $fechaFin = Carbon::now()->addDays(30)->endOfDay();
        
        // Obtener reservas aprobadas para el período
        $reservas = Reserva::with('recinto')
            ->aprobadas()
            ->whereBetween('fecha_reserva', [$fechaInicio, $fechaFin])
            ->get()
            ->groupBy(['recinto_id', 'fecha_reserva']);
        
        return view('calendario.index', compact('recintos', 'reservas', 'fechaInicio', 'fechaFin'));
    }
    
    public function disponibilidad(Request $request)
    {
        $recintoId = $request->get('recinto_id');
        $fecha = $request->get('fecha');
        
        if (!$recintoId || !$fecha) {
            return response()->json(['error' => 'Parámetros inválidos'], 400);
        }
        
        $recinto = Recinto::find($recintoId);
        if (!$recinto) {
            return response()->json(['error' => 'Recinto no encontrado'], 404);
        }
        
        // Generar horarios disponibles (cada 1 hora)
        $horariosDisponibles = [];
        $horaInicio = Carbon::parse($recinto->horarios_disponibles['inicio'] ?? '08:00');
        $horaFin = Carbon::parse($recinto->horarios_disponibles['fin'] ?? '23:00');
        
        while ($horaInicio < $horaFin) {
            $siguienteHora = $horaInicio->copy()->addHour();
            
            $disponible = $recinto->disponibleEn(
                $fecha, 
                $horaInicio->format('H:i'), 
                $siguienteHora->format('H:i')
            );
            
            $horariosDisponibles[] = [
                'hora_inicio' => $horaInicio->format('H:i'),
                'hora_fin' => $siguienteHora->format('H:i'),
                'disponible' => $disponible
            ];
            
            $horaInicio = $siguienteHora;
        }
        
        return response()->json([
            'recinto' => $recinto->nombre,
            'fecha' => $fecha,
            'horarios' => $horariosDisponibles
        ]);
    }
}
