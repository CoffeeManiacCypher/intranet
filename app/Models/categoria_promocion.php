<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaPromocion extends Model
{
    protected $table = 'categoria_promocion';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public $timestamps = false;

    // Relación con Promociones
    public function promociones()
    {
        return $this->hasMany(Promocion::class, 'categoria_promocion_id');
    }
}
