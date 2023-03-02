<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SemanaNegocio;

class ConciliacionController extends Controller
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

        $periodos_negocio=SemanaNegocio::where('proveedor', $proveedor)
                                       ->where('dia_fin','<=',$fecha)
                                       ->orderby('dia_fin','desc')
                                       ->get()
                                       ->take(12);

        return(view('conciliacion.periodos',['proveedor'=>$proveedor,'periodos'=>$periodos_negocio]));
    }
}
