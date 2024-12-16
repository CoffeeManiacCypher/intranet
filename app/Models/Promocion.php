<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends Model
{
    use SoftDeletes;

    protected $table = 'promociones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_promocion_id',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con CategoriaPromocion
    public function categoriaPromocion()
    {
        return $this->belongsTo(CategoriaPromocion::class, 'categoria_promocion_id');
    }

    // Relación muchos a muchos con Servicios a través de PromocionServicio
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'promocion_servicio', 'promocion_id', 'servicio_id');
    }
}
