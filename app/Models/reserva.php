<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $table = 'reservas';

    protected $fillable = [
        'paciente_id',
        'servicio_id',
        'personal_id',
        'fecha_realizacion',
        'asistencia',
        'estado_pago',
        'precio'
    ];

    protected $dates = ['fecha_realizacion', 'deleted_at'];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
