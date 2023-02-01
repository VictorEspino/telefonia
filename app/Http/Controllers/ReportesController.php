<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SemanaNatural;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function diario(Request $request)
    {
        if(isset($_GET['query']))
        {
            $query=$_GET["query"];
        }
        else
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
            $query=$fecha;
        }

        //obtiene el rango de semana

        $semana=SemanaNatural::where('dia_inicio','<=',$query)
                             ->where('dia_fin','>=',$query)
                             ->get()
                             ->first();
        $mes=substr($semana->dia_inicio,0,7);
        
        $sql_ventas_dia="
                        select proveedor,sum(ventas) as ventas,sum(enganches) as enganches,sum(precio_venta) as precio_venta from (
                        select 'CONTADO' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        select 'KREDIYA' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        select 'PAYJOY' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        SELECT proveedor,count(*) as ventas,sum(enganche) as enganches,sum(precio_equipo) as precio_venta FROM `ventas` WHERE created_at>='".$query." 00:00:00' and created_at<='".$query." 23:59:59' group by proveedor
                            ) as a group by a.proveedor
                        ";

        $sql_ventas_semana="
                        select proveedor,sum(ventas) as ventas,sum(enganches) as enganches,sum(precio_venta) as precio_venta from (
                        select 'CONTADO' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        select 'KREDIYA' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        select 'PAYJOY' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        SELECT proveedor,count(*) as ventas,sum(enganche) as enganches,sum(precio_equipo) as precio_venta FROM `ventas` WHERE created_at>='".$semana->dia_inicio." 00:00:00' and created_at<='".$semana->dia_fin." 23:59:59' group by proveedor
                            ) as a group by a.proveedor
                            ";
        $sql_ventas_mes="
                        select proveedor,sum(ventas) as ventas,sum(enganches) as enganches,sum(precio_venta) as precio_venta from (
                        select 'CONTADO' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        select 'KREDIYA' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        select 'PAYJOY' as proveedor, 0 as ventas,0 as enganches,0 as precio_venta from dual
                        UNION
                        SELECT proveedor,count(*) as ventas,sum(enganche) as enganches,sum(precio_equipo) as precio_venta FROM `ventas` WHERE lpad(created_at,7,0)='".$mes."'  group by proveedor
                            ) as a group by a.proveedor
                            ";
        $ventas_dia=DB::select(DB::raw($sql_ventas_dia));
        $ventas_semana=DB::select(DB::raw($sql_ventas_semana));
        $ventas_mes=DB::select(DB::raw($sql_ventas_mes));
        return view('reportes.diario',['query'=>$query,'ventas_dia'=>$ventas_dia,'ventas_semana'=>$ventas_semana,'ventas_mes'=>$ventas_mes]);
    }
}
