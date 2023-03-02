<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayjoyWeek extends Model
{
    use HasFactory;
    protected $fillable =[
            'transaction_time',
            'merchant_name',
            'device',
            'transaction_type',
            'device_family',
            'device_model',
            'imei',
            'sales_clerk_id',
            'sales_clerk_name',
            'months',
            'dinero_payjoy',
            'dinero_nuestro',
            'semana_negocio_id',
            'carga_id',
            'capturado_id'

    ];
}
