<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gasto;
use Illuminate\Support\Facades\Auth;

class GastoController extends Controller
{
    public function show_nuevo()
    {
        return(view('gastos.nuevo'));
    }
    public function save_nuevo(Request $request)
    {
        $request->validate([
            'dia' => 'required|date_format:Y-m-d',
            'descripcion' => 'required',
            'monto' => 'required|numeric|min:1'        
        ],
        [
            'required' => 'Campo requerido.',
            'numeric'=>'Debe ser un numero',
            'email'=>'Indique una direccion de correo valida',
            'unique'=>'Valor duplicado en base de datos',
            'digits'=>'Debe contener 10 digitos',
            'min'=>'Valor invalido',
            'date_format'=>'Formato de fecha invalido'
        ]
        );
        $registro=new Gasto;      
        $registro->user_id=Auth::user()->id;
        $registro->locacion_id=Auth::user()->locacion;
        $registro->dia_gasto=$request->dia;
        $registro->descripcion=$request->descripcion;
        $registro->gasto=$request->monto;
        $registro->save();
        
        return(view('mensaje',[ 'estatus'=>'OK',
                                'mensaje'=>'El registro del gasto ('.$request->dia.' - '.$request->descripcion.') se realizo de manera exitosa!'
                              ]));
    }
    public function gasto_borrar(Request $request)
    {
        Gasto::find($request->id)->delete();
        return;
    }
    public function seguimiento_gastos(Request $request)
    {
        $campo_universo='';
        $key_universo='';
    
        if(Auth::user()->puesto=='EJECUTIVO')
        {
            $campo_universo='user_id';
            $operador='=';
            $key_universo=Auth::user()->id;
        }
        if(Auth::user()->puesto=='GERENTE')
        {
            $campo_universo='locacion_id';
            $operador='=';
            $key_universo=Auth::user()->locacion;
        }
        if(Auth::user()->puesto=='ADMIN')
        {
            $campo_universo='id';
            $operador='>';
            $key_universo=0;
        }
        if(isset($_GET['query']))
        {
            $registros=Gasto::with('user_desc','locacion_desc')
                                ->where($campo_universo,$operador,$key_universo)
                                ->where('dia_gasto',$_GET["query"])
                                ->orderBy('dia_gasto','desc')
                                ->paginate(10);
            $registros->appends($request->all());
            return(view('gastos.seguimiento',['registros'=>$registros,'query'=>$_GET['query']]));
        }
        else
        {
            $registros=Gasto::with('user_desc','locacion_desc')
                                ->where($campo_universo,$operador,$key_universo)
                                ->orderBy('dia_gasto','desc')
                                ->paginate(10);
            return(view('gastos.seguimiento',['registros'=>$registros,'query'=>'']));
        }
    }
}
