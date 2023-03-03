<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipanteComisiones extends Model
{
    use HasFactory;

    protected $fillable=['user_id','locacion_id','puesto','fijo','pago_id'];
}
