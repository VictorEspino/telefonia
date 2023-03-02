<?php

namespace App\Imports;

use App\Models\PayjoyWeek;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ImportPayjoy implements ToModel,WithHeadingRow,WithBatchInserts
{
    use Importable;

    private $carga_id;
    private $semana_negocio_id;

    public function __construct($carga_id,$semana_negocio_id) 
    {
        $this->carga_id = $carga_id;
        $this->semana_negocio_id = $semana_negocio_id;
    }
    public function model(array $row)
    {
        return new PayjoyWeek([
            'proveedor'=>'PAYJOY',
            'transaction_time'=>$row['transaction_time'],
            'merchant_name'=>$row['merchant_name'],
            'device'=>$row['device'],
            'transaction_type'=>$row['transaction_type'],
            'device_family'=>$row['device_family'],
            'device_model'=>$row['device_model'],
            'imei'=>$row['imei'],
            'sales_clerk_id'=>$row['sales_clerk_id'],
            'sales_clerk_name'=>$row['sales_clerk_name'],
            'months'=>$row['months'],
            'dinero_payjoy'=>$row['dinero_payjoy'],
            'dinero_nuestro'=>$row['dinero_nuestro'],
            'semana_negocio_id'=>$this->semana_negocio_id,
            'carga_id'=>$this->carga_id,
        ]);
    }
    public function customValidationMessages()
    {
        return [
            'proveedor.required' => 'Campo requerido',
            'proveedor.numeric' => 'Se espera valor numerico',
            'asignacion.required' => 'Campo requerido',
            'modelo.required' => 'Campo requerido',
            'costo.required' => 'Campo requerido',
            'precio.required' => 'Campo requerido',
            'imei.required' => 'Campo requerido',
        ];
    }
    public function batchSize(): int
    {
        return 50;
    }
}
