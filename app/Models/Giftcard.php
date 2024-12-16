<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Giftcard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'giftcards';

    protected $fillable = [
        'comprado_por',             // Relación con el ID del paciente que compra la giftcard
        'beneficiador_id',          // Relación con el ID del paciente que usa la giftcard
        'trabajador_id',            // Relación con el ID del trabajador que gestiona la giftcard
        'promocion_id',             // Relación con el ID de la promoción asociada
        'valor',                    // Valor de la giftcard
        'mensaje_personalizado',    // Mensaje opcional
        'fecha_compra',             // Fecha de compra de la giftcard
        'fecha_expiracion',         // Fecha de expiración de la giftcard
        'fecha_cobro',              // Fecha en la que se cobró la giftcard
        'estatus_giftcard',         // Estado actual de la giftcard
    ];

    protected $dates = [
        'fecha_compra',
        'fecha_expiracion',
        'fecha_cobro',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relación con el modelo Paciente (comprador)
    public function comprador()
    {
        return $this->belongsTo(Paciente::class, 'comprado_por');
    }

    // Giftcard.php
    public function beneficiador()
    {
        return $this->belongsTo(Paciente::class, 'beneficiador_id');
    }


    // Relación con el modelo Personal (trabajador que gestiona la giftcard)
    public function trabajador()
    {
        return $this->belongsTo(Personal::class, 'trabajador_id');
    }

    // Relación con el modelo Promocion
    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'promocion_id');
    }
}
