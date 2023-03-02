<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SemanaNegocio;
use App\Models\Inventario;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class KrediyaController extends Controller
{
    public function detalle_periodo(Request $request)
    {
        $semana_negocio_id=$request->semana_negocio_id;

        $periodo=SemanaNegocio::find($semana_negocio_id);

        $dia_inicio=$periodo->dia_inicio;
        $dia_fin=$periodo->dia_fin;

        $sql_ventas="select count(*) as n_equipos,sum(precio_equipo) as equipos,sum(enganche) as enganches from ventas where proveedor='KREDIYA' 
                    and lpad(created_at,10,0)>='".$dia_inicio."'
                    and lpad(created_at,10,0)<='".$dia_fin."'";

        $sql_parcialidades="select count(*) as n_parcialidades,sum(monto) as parcialidades from pago_parcialidads where proveedor='KREDIYA'
                    and lpad(created_at,10,0)>='".$dia_inicio."'
                    and lpad(created_at,10,0)<='".$dia_fin."'";

        $ventas=collect(DB::select(DB::raw($sql_ventas)))->first();
        $parcialidades_reg=collect(DB::select(DB::raw($sql_parcialidades)))->first();


        $equipos=$ventas->equipos;
        $enganches=$ventas->enganches;
        $parcialidades=$parcialidades_reg->parcialidades;

        $n_equipos=$ventas->n_equipos;
        $n_enganches=$ventas->n_equipos;
        $n_parcialidades=$parcialidades_reg->n_parcialidades;




        $sin_conciliar=Venta::with('user_desc','locacion_desc','inventario_desc')
                        ->where('equipo_conciliado',0)
                        ->where('proveedor','KREDIYA')
                        ->whereRaw('lpad(created_at,10,0)>=? and lpad(created_at,10,0)<=?',[$dia_inicio,$dia_fin])
                        ->get();

        $conciliados=Venta::with('user_desc','locacion_desc','inventario_desc')
                        ->where('equipo_conciliado',1)
                        ->where('proveedor','KREDIYA')
                        ->whereRaw('lpad(created_at,10,0)>=? and lpad(created_at,10,0)<=?',[$dia_inicio,$dia_fin])
                        ->get();



        return(view('conciliacion.detalle_krediya',['semana_negocio_id'=>$semana_negocio_id,
                                                    'dia_inicio'=>$dia_inicio,
                                                    'dia_fin'=>$dia_fin,
                                                    'n_equipos'=>$n_equipos,
                                                    'equipos'=>$equipos,
                                                    'enganches'=>$enganches,
                                                    'n_enganches'=>$n_enganches,
                                                    'parcialidades'=>$parcialidades,
                                                    'n_parcialidades'=>$n_parcialidades,                                                    
                                                    'reg_sin_conciliar'=>$sin_conciliar,
                                                    'reg_conciliados'=>$conciliados,
                                                    
                                                ]));
    }

    public function cierra_conciliacion(Request $request)
    {
        $dia_inicio=$request->dia_inicio;
        $dia_fin=$request->dia_fin;

        Venta::where('proveedor','KREDIYA')
                ->whereRaw('lpad(created_at,10,0)>=? and lpad(created_at,10,0)<=?',[$dia_inicio,$dia_fin])
                ->update(['equipo_conciliado'=>0]);


        $id_conciliados=[];
        foreach($request->all() as $index=>$elemento)
        {
            if($index!='dia_inicio' && $index!='dia_fin' && $index!='_token' && $index!='semana_negocio_id')
            $id_conciliados[]=$index;
        }
        Venta::whereIn('id',$id_conciliados)
                ->update(['equipo_conciliado'=>1]);

        SemanaNegocio::where('id',$request->semana_negocio_id)
                    ->update(['conciliado'=>1]);

        return back()->withStatus('Conciliacion guardada con exito!');
    }
}
