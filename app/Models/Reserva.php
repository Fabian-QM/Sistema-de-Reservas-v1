<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'recinto_id',
        'deporte',
        'rut',
        'nombre_organizacion',
        'representante_nombre',
        'email',
        'email_confirmacion',
        'telefono',
        'direccion',
        'region',
        'comuna',
        'cantidad_personas',
        'fecha_reserva',
        'hora_inicio',
        'hora_fin',
        'estado',
        'observaciones',
        'motivo_rechazo',
        'acepta_reglamento'
    ];

    protected $casts = [
        'fecha_reserva' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
        'fecha_respuesta' => 'datetime',
        'acepta_reglamento' => 'boolean'
    ];

    public function recinto()
    {
        return $this->belongsTo(Recinto::class);
    }

    public function aprobadaPor()
    {
        return $this->belongsTo(User::class, 'aprobada_por');
    }

    public function getRutFormateadoAttribute()
    {
        $rut = $this->rut;
        if (strlen($rut) < 8) return $rut;
        
        $cuerpo = substr($rut, 0, -1);
        $dv = substr($rut, -1);
        
        return number_format($cuerpo, 0, '', '.') . '-' . $dv;
    }

    public function getDuracionAttribute()
    {
        $inicio = Carbon::parse($this->hora_inicio);
        $fin = Carbon::parse($this->hora_fin);
        
        return $inicio->diffInHours($fin) . ' horas';
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    public function scopeFuturas($query)
    {
        return $query->where('fecha_reserva', '>=', now()->toDateString());
    }

    public function esEditable()
    {
        return $this->estado === 'pendiente' && 
               $this->fecha_reserva > now()->toDateString();
    }

    public function aprobar($userId, $observaciones = null)
    {
        $this->update([
            'estado' => 'aprobada',
            'aprobada_por' => $userId,
            'fecha_respuesta' => now(),
            'observaciones' => $observaciones
        ]);
    }

    public function rechazar($userId, $motivo)
    {
        $this->update([
            'estado' => 'rechazada',
            'aprobada_por' => $userId,
            'fecha_respuesta' => now(),
            'motivo_rechazo' => $motivo
        ]);
    }
}
