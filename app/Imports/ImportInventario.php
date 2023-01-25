<?php

namespace App\Imports;

use App\Models\Inventario;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ImportInventario implements ToModel,WithHeadingRow,WithValidation,WithBatchInserts
{
    use Importable;

    private $carga_id;

    public function __construct($carga_id) 
    {
        $this->carga_id = $carga_id;
    }
    public function model(array $row)
    {
        return new Inventario([
            'proveedor'=>$row['proveedor'],
            'asignacion'=>$row['asignacion'],
            'tag'=>$row['tag'],
            'familia'=>$row['familia'],
            'modelo'=>$row['modelo'],
            'costo'=>$row['costo'],
            'precio'=>$row['precio'],
            'imei'=>$row['imei'],
            'estatus'=>0,
            'carga_id'=>$this->carga_id,
            'user_id'=>Auth::user()->id,
        ]);
    }
    public function rules(): array
    {
        return [
            '*.proveedor' => ['required'],
            '*.asignacion' => ['required'],
            '*.modelo' => ['required'],
            '*.costo' => ['required'],
            '*.precio' => ['required'],
            '*.imei' => ['required']
        ];
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
