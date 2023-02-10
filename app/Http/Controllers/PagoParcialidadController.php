<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Proveedor;
use App\Models\PagoParcialidad;
use Illuminate\Support\Facades\Auth;

class PagoParcialidadController extends Controller
{
    public function show_nuevo()
    {
        $proveedores_servicio=Proveedor::where('visible',1)->where('tipo',2)->where('nombre','!=','CONTADO')->get();
        return(view('pago_parcialidades.nuevo',['proveedores_servicio'=>$proveedores_servicio]));
    }
    public function save_nuevo(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required|numeric|digits:10',
            'imei' => 'required',
            'proveedor_servicio' => 'required',
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
        $registro=new PagoParcialidad;      
        $registro->user_id=Auth::user()->id;
        $registro->locacion_id=Auth::user()->locacion;
        $registro->nombre=$request->nombre;
        $registro->imei=$request->imei;
        $registro->telefono=$request->telefono;
        $registro->proveedor=$request->proveedor_servicio;
        $registro->monto=$request->monto;
        $registro->save();
        
        return(view('mensaje',[ 'estatus'=>'OK',
                                'mensaje'=>'El registro de parcialidad ('.$request->nombre.' - '.$request->proveedor_servicio.' por $'.number_format($request->monto,2).') se realizo de manera exitosa!'
                              ]));
    }
    public function parcialidades_borrar(Request $request)
    {
        PagoParcialidad::find($request->id)->delete();
        return;
    }
    public function seguimiento_parcialidades(Request $request)
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
            $registros=PagoParcialidad::with('user_desc','locacion_desc')
                                ->where($campo_universo,$operador,$key_universo)
                                ->whereRaw("lpad(created_at,10,0)='".$_GET["query"]."'")
                                ->orderBy('created_at','desc')
                                ->paginate(10);
            $registros->appends($request->all());
            return(view('pago_parcialidades.seguimiento',['registros'=>$registros,'query'=>$_GET['query']]));
        }
        else
        {
            $registros=PagoParcialidad::with('user_desc','locacion_desc')
                                ->where($campo_universo,$operador,$key_universo)
                                ->orderBy('created_at','desc')
                                ->paginate(10);
            return(view('pago_parcialidades.seguimiento',['registros'=>$registros,'query'=>'']));
        }
    }
}
