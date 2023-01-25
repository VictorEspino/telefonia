<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor',
        'asignacion',
        'tag',
        'familia',
        'modelo',
        'costo',
        'precio',
        'imei',
        'estatus',
        'carga_id',
        'user_id',
    ];

    public function proveedor_desc()
    {
        return $this->belongsTo(Proveedor::class,'proveedor');
    }
    public function asignacion_desc()
    {
        return $this->belongsTo(Locacion::class,'asignacion');
    }
}
