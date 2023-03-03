<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicionTiendas extends Model
{
    use HasFactory;
    protected $fillable=['locacion_id','ventas','pago_id'];
}
