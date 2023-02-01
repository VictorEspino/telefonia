<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    public function user_desc()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function locacion_desc()
    {
        return $this->belongsTo(Locacion::class,'locacion_id');
    }
}
