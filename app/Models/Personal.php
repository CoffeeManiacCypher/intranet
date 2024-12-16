<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    use HasFactory, SoftDeletes;

    // Nombre de la tabla
    protected $table = 'personal';

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'nombres',
        'apellidos',
        'rut',
        'telefono',
        'email',
        'rol',
    ];

    // Tipos de datos para las columnas
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Reglas de validación para el rol
    public static $roles = ['Trabajador', 'Recepcionista', 'Administrador'];

    /**
     * Validar si el rol es válido.
     *
     * @param string $rol
     * @return bool
     */
    public static function validarRol($rol)
    {
        return in_array($rol, self::$roles);
    }

    // Relación con la tabla reservas (si aplica)
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'prestador_id');
    }

    // Relación con la tabla giftcards (si aplica)
    public function giftcards()
    {
        return $this->hasMany(Giftcard::class, 'cobrado_por_id');
    }
}
