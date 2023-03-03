<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PagoComisiones;
use App\Models\SemanaNegocio;
use App\Models\User;
use App\Models\ParticipanteComisiones;
use App\Models\MedicionEjecutivo;
use App\Models\MedicionTiendas;
use App\Models\ComisionEjecutivo;
use Illuminate\Support\Facades\DB;

class ComisionesController extends Controller
{
    public function periodos(Request $request)
    {
        $hoy=getdate();
        $dia=$hoy['mday'];
        if($dia=='1' || $dia=='2' || $dia=='3' || $dia=='4' || $dia=='5' || $dia=='6' || $dia=='7' || $dia=='8' || $dia=='9')
        $dia='0'.$dia;
        $mes=$hoy['mon'];
        if($mes=='1' || $mes=='2' || $mes=='3' || $mes=='4' || $mes=='5' || $mes=='6' || $mes=='7' || $mes=='8' || $mes=='9')
        $mes='0'.$mes;
        $año=$hoy['year'];
        $fecha=$año."-".$mes."-".$dia;

        $proveedor=$request->proveedor;

        $periodos=PagoComisiones::where('dia_pago','<=',$fecha)
                                       ->orderby('dia_pago','desc')
                                       ->get()
                                       ->take(12);

        return(view('comisiones.periodos',['periodos'=>$periodos]));
    }
    public function detalle_comisiones(Request $request)
    {
        $pago=PagoComisiones::find($request->id);

        $periodo_payjoy=SemanaNegocio::where('proveedor','PAYJOY')
                                    ->where('dia_fin','<=',$pago->dia_pago)
                                    ->orderBy('id','desc')
                                    ->get()
                                    ->first();
                                
        $periodo_krediya=SemanaNegocio::where('proveedor','KREDIYA')
                                    ->where('dia_fin','<=',$pago->dia_pago)
                                    ->orderBy('id','desc')
                                    ->get()
                                    ->first();

        return(view('comisiones.detalle_comisiones',[
                                                        'pago'=>$pago,
                                                        'periodo_payjoy'=>$periodo_payjoy,
                                                        'periodo_krediya'=>$periodo_krediya
                                                    ]));
    }
    public function calculo_comisiones(Request $request)
    {
        $periodo_pj=SemanaNegocio::find($request->id_pj);
        $periodo_ky=SemanaNegocio::find($request->id_ky);
        $pago=PagoComisiones::find($request->id_pago);

        $this->participantes($pago->id);
        $this->medicion_ejecutivos($pago->id,$periodo_pj,$periodo_ky);
        $this->medicion_tiendas($pago->id,$periodo_pj,$periodo_ky);
        $this->comision_ejecutivos($pago->id);

        $pago->pagado=1;
        $pago->save();

        return back()->withStatus('El calculo de comisiones se realizo de manera exitosa!');
    }

    public function participantes($id_pago)
    {
        ParticipanteComisiones::where('pago_id',$id_pago)->delete();
        $usuarios=User::all();
        foreach($usuarios as $usuario)
        {
            ParticipanteComisiones::create([
                                                'user_id'=>$usuario->id,
                                                'locacion_id'=>$usuario->locacion,
                                                'puesto'=>$usuario->puesto,
                                                'fijo'=>$usuario->fijo,
                                                'pago_id'=>$id_pago,
            ]);
        }
    }
    public function medicion_ejecutivos($id_pago,$periodo_pj,$periodo_ky)
    {
        MedicionEjecutivo::where('pago_id',$id_pago)->delete();
        
        $sql_medicion="
                        SELECT user_id,sum(n) as ventas from (
                        SELECT user_id,count(*) as n FROM ventas WHERE proveedor='PAYJOY' and lpad(created_at,10,0)>='".$periodo_pj->dia_inicio."' and lpad(created_at,10,0)<='".$periodo_pj->dia_fin."' and equipo_conciliado=1 group by user_id
                        UNION
                        SELECT user_id,count(*) as n FROM ventas WHERE proveedor='KREDIYA' and lpad(created_at,10,0)>='".$periodo_ky->dia_inicio."' and lpad(created_at,10,0)<='".$periodo_ky->dia_fin."' and equipo_conciliado=1 group by user_id
                        UNION
                        SELECT user_id,count(*) as n FROM ventas WHERE proveedor='CONTADO' and lpad(created_at,10,0)>='".$periodo_ky->dia_inicio."' and lpad(created_at,10,0)<='".$periodo_ky->dia_fin."' and equipo_conciliado=1 group by user_id
                            ) as a group by a.user_id
                      ";
        $mediciones=collect(DB::select(DB::raw($sql_medicion)));
        foreach($mediciones as $medicion)
        {
                MedicionEjecutivo::create([
                    'user_id'=>$medicion->user_id,
                    'ventas'=>$medicion->ventas,
                    'pago_id'=>$id_pago
                ]);
        }
       
    }
    public function medicion_tiendas($id_pago,$periodo_pj,$periodo_ky)
    {
        MedicionTiendas::where('pago_id',$id_pago)->delete();
        
        $sql_medicion="
                        SELECT locacion_id,sum(n) as ventas from (
                        SELECT locacion_id,count(*) as n FROM ventas WHERE proveedor='PAYJOY' and lpad(created_at,10,0)>='".$periodo_pj->dia_inicio."' and lpad(created_at,10,0)<='".$periodo_pj->dia_fin."' and equipo_conciliado=1 group by locacion_id
                        UNION
                        SELECT locacion_id,count(*) as n FROM ventas WHERE proveedor='KREDIYA' and lpad(created_at,10,0)>='".$periodo_ky->dia_inicio."' and lpad(created_at,10,0)<='".$periodo_ky->dia_fin."' and equipo_conciliado=1 group by locacion_id
                        UNION
                        SELECT locacion_id,count(*) as n FROM ventas WHERE proveedor='CONTADO' and lpad(created_at,10,0)>='".$periodo_ky->dia_inicio."' and lpad(created_at,10,0)<='".$periodo_ky->dia_fin."' and equipo_conciliado=1 group by locacion_id
                            ) as a group by a.locacion_id
                      ";
        $mediciones=collect(DB::select(DB::raw($sql_medicion)));

        foreach($mediciones as $medicion)
        {
                MedicionTiendas::create([
                    'locacion_id'=>$medicion->locacion_id,
                    'ventas'=>$medicion->ventas,
                    'pago_id'=>$id_pago
                ]);

        }
    }
    public function comision_ejecutivos($id_pago)
    {
        ComisionEjecutivo::where('pago_id',$id_pago)->delete();
        $ejecutivos=ParticipanteComisiones::where('puesto','!=','GERENTE')
                                ->where('pago_id',$id_pago)
                                ->get();
        $ventas_medidas=MedicionEjecutivo::where('pago_id',$id_pago)->get();
        $ventas_medidas=$ventas_medidas->pluck('ventas','user_id');
        
        foreach($ejecutivos as $ejecutivo)
            {
                $ventas_ejecutivo=0;
                try
                {
                    $ventas_ejecutivo=$ventas_medidas[$ejecutivo->user_id];
                }
                catch(\Exception $e){;}
                $ventas_r1=0;
                $ventas_r2=0;
                $ventas_r3=0;

                if($ventas_ejecutivo>=5)
                {
                    $ventas_r1=5;
                    if(($ventas_ejecutivo-$ventas_r1)>=5)
                    {
                        $ventas_r2=5;
                        $ventas_r3=$ventas_ejecutivo-$ventas_r1-$ventas_r2;
                    }
                    else
                    {
                        $ventas_r2=$ventas_ejecutivo-$ventas_r1;
                        $ventas_r3=0;
                    }
                }
                else
                {
                    $ventas_r1=$ventas_ejecutivo;
                    $ventas_r2=0;
                    $ventas_r3=0;
                }
        ComisionEjecutivo::create([
                'user_id'=>$ejecutivo->user_id,
                'locacion_id'=>$ejecutivo->locacion_id,
                'pago_id'=>$id_pago,
                'fijo'=>$ejecutivo->fijo,
                'ventas'=>$ventas_ejecutivo,
                'rango1'=>$ventas_r1,
                'comision_r1'=>$ventas_r1*100,
                'rango2'=>$ventas_r2,
                'comision_r2'=>$ventas_r2*125,
                'rango3'=>$ventas_r3,
                'comision_r3'=>$ventas_r3*150,
                'total_comisiones'=>$ventas_r1*100+$ventas_r2*125+$ventas_r3*150,
                'total_pago'=>$ventas_r1*100+$ventas_r2*125+$ventas_r3*150+$ejecutivo->fijo
                ]);
            }
    }
    public function export_ejecutivos(Request $request)
    {
        $registros=ComisionEjecutivo::with('locacion_desc','user_desc')->where('pago_id',$request->id)->get();
        return(view('comisiones.pagos_ejecutivos',['query'=>$registros]));
    }
}
