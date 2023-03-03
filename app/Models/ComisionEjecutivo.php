<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComisionEjecutivo extends Model
{
    use HasFactory;
    protected $fillable=['user_id','locacion_id','pago_id','fijo','ventas','rango1','comision_r1','rango2','comision_r2','rango3','comision_r3','total_comisiones','total_pago'];

    public function user_desc()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function locacion_desc()
    {
        return $this->belongsTo(Locacion::class,'locacion_id');
    }
}
