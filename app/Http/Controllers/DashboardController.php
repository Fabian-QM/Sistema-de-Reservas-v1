<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Recinto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas básicas
        $reservasPendientes = Reserva::pendientes()->count();
        $reservasHoy = Reserva::aprobadas()
            ->where('fecha_reserva', Carbon::today())
            ->count();
        
        $reservasEstesMes = Reserva::aprobadas()
            ->whereMonth('fecha_reserva', Carbon::now()->month)
            ->count();
            
        $recintosActivos = Recinto::activos()->count();
        
        // Reservas pendientes recientes
        $reservasPendientesRecientes = Reserva::with(['recinto'])
            ->pendientes()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'reservasPendientes',
            'reservasHoy', 
            'reservasEstesMes',
            'recintosActivos',
            'reservasPendientesRecientes'
        ));
    }
}