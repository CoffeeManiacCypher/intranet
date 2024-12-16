<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FichaMedica extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fichas_medicas';

    protected $fillable = [
        'paciente_id',
        'servicio_id',
        'archivo',
    ];

    /**
     * Relación con el modelo Paciente.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    /**
     * Relación con el modelo Servicio.
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
