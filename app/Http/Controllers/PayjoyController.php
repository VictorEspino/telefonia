<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SemanaNegocio;
use App\Models\Inventario;
use App\Imports\ImportPayjoy;
use App\Models\PayjoyWeek;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class PayjoyController extends Controller
{
    public function detalle_periodo(Request $request)
    {
        $semana_negocio_id=$request->semana_negocio_id;

        $periodo=SemanaNegocio::find($semana_negocio_id);

        $dia_inicio=$periodo->dia_inicio;
        $dia_fin=$periodo->dia_fin;

        $sql_ventas="select count(*) as n_equipos,sum(precio_equipo) as equipos,sum(enganche) as enganches from ventas where proveedor='PAYJOY' 
                    and lpad(created_at,10,0)>='".$dia_inicio."'
                    and lpad(created_at,10,0)<='".$dia_fin."'";

        $sql_parcialidades="select count(*) as n_parcialidades,sum(monto) as parcialidades from pago_parcialidads where proveedor='PAYJOY'
                    and lpad(created_at,10,0)>='".$dia_inicio."'
                    and lpad(created_at,10,0)<='".$dia_fin."'";

        $ventas=collect(DB::select(DB::raw($sql_ventas)))->first();
        $parcialidades_reg=collect(DB::select(DB::raw($sql_parcialidades)))->first();


        $equipos=$ventas->equipos;
        $enganches=$ventas->n_equipos;
        $parcialidades=$parcialidades_reg->parcialidades;

        $n_equipos=$ventas->n_equipos;
        $n_enganches=$ventas->n_equipos;
        $n_parcialidades=$parcialidades_reg->n_parcialidades;


        //PAYJOY

        $pj_equipos=0;
        $pj_enganches=0;
        $pj_parcialidades=0;

        $pj_n_equipos=0;
        $pj_n_enganches=0;
        $pj_n_parcialidades=0;

        $pj_com_equipos=0;
        $pj_com_parcialidades=0;

        $datos_pj=PayjoyWeek::select(DB::raw('transaction_type,count(*) as n,sum(dinero_payjoy) as dinero_payjoy, sum(dinero_nuestro) as dinero_nuestro'))
                                ->where('semana_negocio_id',$semana_negocio_id)
                                ->groupBy('transaction_type')
                                ->get();

        foreach($datos_pj as $registro)
        {
            if($registro->transaction_type=='purchaseTotal')
            {
                $pj_n_equipos=$registro->n;
                $pj_equipos=$registro->dinero_payjoy;
            }
            if($registro->transaction_type=='purchaseCommission')
            {
                $pj_com_equipos=$registro->dinero_payjoy;
            }
            if($registro->transaction_type=='purchaseDownPayment')
            {
                $pj_n_enganches=$registro->n;
                $pj_enganches=$registro->dinero_nuestro;
            }
            if($registro->transaction_type=='paymentPeriodic')
            {
                $pj_n_parcialidades=$registro->n;
                $pj_parcialidades=$registro->dinero_nuestro;
            }
            if($registro->transaction_type=='paymentCommission')
            {
                $pj_com_parcialidades=$registro->dinero_payjoy;
            }
        }

        //CAPTURADOS SIN CONCILIAR

        $sin_conciliar=Venta::with('user_desc','locacion_desc','inventario_desc')
                        ->where('equipo_conciliado',0)
                        ->whereRaw('lpad(created_at,10,0)>=? and lpad(created_at,10,0)<=?',[$dia_inicio,$dia_fin])
                        ->get();

        //CONCILIADOS SIN CAPTURAR

        $sin_captura=PayjoyWeek::where('semana_negocio_id',$semana_negocio_id)
                               ->where('capturado_id',0)
                               ->where('transaction_type','purchaseTotal')
                               ->get();

        return(view('conciliacion.detalle_payjoy',['semana_negocio_id'=>$semana_negocio_id,
                                                    'n_equipos'=>$n_equipos,
                                                    'equipos'=>$equipos,
                                                    'enganches'=>$enganches,
                                                    'n_enganches'=>$n_enganches,
                                                    'parcialidades'=>$parcialidades,
                                                    'n_parcialidades'=>$n_parcialidades,
                                                    'pj_n_equipos'=>$pj_n_equipos,
                                                    'pj_equipos'=>$pj_equipos,
                                                    'pj_enganches'=>$pj_enganches,
                                                    'pj_n_enganches'=>$pj_n_enganches,
                                                    'pj_parcialidades'=>$pj_parcialidades,
                                                    'pj_n_parcialidades'=>$pj_n_parcialidades,
                                                    'pj_com_equipos'=>$pj_com_equipos,
                                                    'pj_com_parcialidades'=>$pj_com_parcialidades,
                                                    'reg_sin_conciliar'=>$sin_conciliar,
                                                    'reg_sin_captura'=>$sin_captura,
                                                ]));
    }
    public function payjoy_import(Request $request) 
    {
        //return($request->all());
        $request->validate(['file'=> 'required'],['required'=>'Archivo requerido']);
        $file=$request->file('file');
        $semana_negocio_id=$request->semana_negocio_id;

        PayjoyWeek::where('semana_negocio_id',$semana_negocio_id)->delete();
        $periodo=SemanaNegocio::find($semana_negocio_id);

        $dia_inicio=$periodo->dia_inicio;
        $dia_fin=$periodo->dia_fin;

        $sql_reset="update ventas set conciliado_id=0,equipo_conciliado=0 where proveedor='PAYJOY'
                    and lpad(created_at,10,0)>='".$dia_inicio."'
                    and lpad(created_at,10,0)<='".$dia_fin."'";

        DB::select(DB::raw($sql_reset));

        $bytes = random_bytes(5);
        $carga_id=bin2hex($bytes);
       
        $import=new ImportPayjoy($carga_id,$semana_negocio_id);
        try{
        $import->import($file);
        $this->aplica_conciliacion($semana_negocio_id);
        }
        catch(\Maatwebsite\Excel\Validators\ValidationException $e) {
            $this->rollback_conciliacion($semana_negocio_id);
            return back()->withFailures($e->failures());
        }  
        return back()->withStatus('Archivo cargado con exito!');
    }
    public function aplica_conciliacion($semana_negocio_id)
    {
        $transacciones=PayjoyWeek::where('semana_negocio_id',$semana_negocio_id)
                                    ->where('transaction_type','purchaseTotal')
                                    ->get();
        $periodo=SemanaNegocio::find($semana_negocio_id);

        $dia_inicio=$periodo->dia_inicio;
        $dia_fin=$periodo->dia_fin;

        foreach($transacciones as $transaccion)
        {
            $inventario_vendido=Inventario::where('imei',$transaccion->imei)->get();
            foreach($inventario_vendido as $identificado)
            {
                    $venta=Venta::where('inventario_id',$identificado->id)
                        ->update(['conciliado_id'=>$transaccion->id,
                                  'equipo_conciliado'=>1
                        ]);
                    if($venta==1)
                    {
                        $venta_capturada=Venta::where('inventario_id',$identificado->id)->get()->first();
                        PayjoyWeek::where('id',$transaccion->id)
                                    ->update(['capturado_id'=>$venta_capturada->id]);
                    }
                
            }
        }
        $periodo->conciliado=1;
        $periodo->save();

    }
    public function rollback_conciliacion($semana_negocio_id)
    {
        PayjoyWeek::where('semana_negocio_id',$semana_negocio_id)->delete();
        $periodo=SemanaNegocio::find($semana_negocio_id);

        $dia_inicio=$periodo->dia_inicio;
        $dia_fin=$periodo->dia_fin;

        $sql_reset="update ventas set conciliado_id=0,equipo_conciliado=0 where proveedor='PAYJOY'
                    and lpad(created_at,10,0)>='".$dia_inicio."'
                    and lpad(created_at,10,0)<='".$dia_fin."'";

        DB::select(DB::raw($sql_reset));
    }
}
