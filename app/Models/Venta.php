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
            'locacion_id',
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
    public function user_desc()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function locacion_desc()
    {
        return $this->belongsTo(Locacion::class,'locacion_id');
    }
    public function inventario_desc()
    {
        return $this->belongsTo(Inventario::class,'inventario_id');
    }
}
