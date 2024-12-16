<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;

    protected $table = 'servicios';
    

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion',
        'categoria_servicio_id'
    ];

    // Relación con Categoría de Servicios (muchos a uno)
    public function categoria()
    {
        return $this->belongsTo(CategoriaServicio::class, 'categoria_servicio_id')->withTrashed();
    }
    
}