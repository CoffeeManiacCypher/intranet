<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromocionServicio extends Model
{
    protected $table = 'promocion_servicio';

    protected $fillable = [
        'promocion_id',
        'servicio_id',
    ];

    public $timestamps = false;

    // Relación con Promocion
    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'promocion_id');
    }

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
