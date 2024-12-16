<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    // Definimos el nombre de la tabla
    protected $table = 'pacientes';

    // Definimos los campos que pueden ser llenados
    protected $fillable = [
        'rut',
        'nombres',
        'apellidos',
        'telefono',
        'comentario_adicional',
        'direccion',
        'ciudad_id',
        'email',
        'genero',
        'estado_info',
        'fecha_nacimiento',
        'created_at',
        'updated_at',
    ];

    // Relaciones
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    // Mutators (Opcional) - Obtener el nombre completo del paciente
    public function getNombreCompletoAttribute()
    {
        return trim(($this->nombres ?? '') . ' ' . ($this->apellidos ?? ''));
    }
    
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'paciente_id');
    }
    
    public function giftcards()
    {
        return $this->hasMany(Giftcard::class, 'paciente_id');
    }
    
    

    // Soft delete
    protected $dates = ['deleted_at'];


}
