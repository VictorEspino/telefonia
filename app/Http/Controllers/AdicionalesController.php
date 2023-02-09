<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VentaAdicional;
use Illuminate\Support\Facades\Auth;

class AdicionalesController extends Controller
{
    public function show_nuevo()
    {
        return(view('adicionales.nuevo'));
    }
    public function save_nuevo(Request $request)
    {
        //return($request->all());
        $request->validate([
            'tipo' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric|min:1'        
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
        $registro=new VentaAdicional;      
        $registro->user_id=Auth::user()->id;
        $registro->locacion_id=Auth::user()->locacion;
        $registro->tipo=$request->tipo;
        $registro->descripcion=$request->descripcion;
        $registro->precio=$request->precio;
        $registro->save();
        
        return(view('mensaje',[ 'estatus'=>'OK',
                                'mensaje'=>'El registro de venta ('.$request->tipo.' - '.$request->descripcion.') se realizo de manera exitosa!'
                              ]));
    }
    public function adicionales_borrar(Request $request)
    {
        VentaAdicional::find($request->id)->delete();
        return;
    }
    public function seguimiento_adicionales(Request $request)
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
            $registros=VentaAdicional::with('user_desc','locacion_desc')
                                ->where($campo_universo,$operador,$key_universo)
                                ->whereRaw("lpad(created_at,10,0)='".$_GET["query"]."'")
                                ->orderBy('created_at','desc')
                                ->paginate(10);
            $registros->appends($request->all());
            return(view('adicionales.seguimiento',['registros'=>$registros,'query'=>$_GET['query']]));
        }
        else
        {
            $registros=VentaAdicional::with('user_desc','locacion_desc')
                                ->where($campo_universo,$operador,$key_universo)
                                ->orderBy('created_at','desc')
                                ->paginate(10);
            return(view('adicionales.seguimiento',['registros'=>$registros,'query'=>'']));
        }
    }
}
