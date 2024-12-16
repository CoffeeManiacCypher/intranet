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
        'trabajador_id',
        'servicio_id',
        'archivo',
        'tipo_archivo',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relaciones
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Personal::class, 'trabajador_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
