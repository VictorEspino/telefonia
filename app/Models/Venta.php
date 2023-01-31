<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable=[
            'inventario_id',    
            'user_id',
            'cliente',
            'enganche',
            'forma_pago',
            'telefono',
            'precio_equipo',
            'tipo_servicio',
            'portabilidad',
            'precio_servicio',
            'proveedor',
            'iccid',
        ];
}
