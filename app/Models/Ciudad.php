<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    // Definimos el nombre de la tabla
    protected $table = 'ciudades';

    // Definimos los campos que pueden ser llenados
    protected $fillable = [
        'nombre',
    ];

    // Las relaciones con otras tablas
    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'ciudad_id');
    }
}
