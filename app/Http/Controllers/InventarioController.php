<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Locacion;
use App\Imports\ImportInventario;
use Illuminate\Support\Facades\Auth;

class InventarioController extends Controller
{
    public function show_upload(Request $request)
    {
        return view('inventario.cargar_inventario');
    }
    public function inventario_import(Request $request) 
    {
        $request->validate(['file'=> 'required'],['required'=>'Archivo requerido']);
        $file=$request->file('file');

        $bytes = random_bytes(5);
        $carga_id=bin2hex($bytes);
       

        $import=new ImportInventario($carga_id);
        try{
        $import->import($file);
        }
        catch(\Maatwebsite\Excel\Validators\ValidationException $e) {
            return back()->withFailures($e->failures());
        }  
        return back()->withStatus('Archivo cargado con exito!');
    }
    public function base_inventario(Request $request)
    {
        //return($request->all());
        $filtro_text='';
        $proveedor='';
        $asignacion='';
        $filtro=false;
        $excel="NO";
        if(isset($_GET['filtro']))
        {
            $filtro=true;
            $filtro_text=$_GET["query"];
            $proveedor=$_GET["proveedor"];
            $asignacion=$_GET["asignacion"];
            $excel=$_GET["excel"];
        }
        if($excel=="NO")
        {
        $registros=Inventario::with('proveedor_desc','asignacion_desc')
                        ->orderBy('created_at','asc')
                        ->where('estatus',0)
                        ->when ($asignacion>0,function ($query) use ($asignacion)
                        {
                            $query->where('asignacion',$asignacion);
                        })
                        ->when ($proveedor>0,function ($query) use ($proveedor)
                        {
                            $query->where('proveedor',$proveedor);
                        })

                        ->when (Auth::user()->puesto!='ADMIN',function ($query)
                        {
                            $query->where('asignacion',Auth::user()->locacion);
                        })
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('familia','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('modelo','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('imei','like','%'.$filtro_text.'%');
                                });               
                            })
                        ->paginate(10);
        }    
        else
        {
            $registros=Inventario::with('proveedor_desc','asignacion_desc')
                        ->orderBy('created_at','asc')
                        ->where('estatus',0)
                        ->when ($asignacion>0,function ($query) use ($asignacion)
                        {
                            $query->where('asignacion',$asignacion);
                        })
                        ->when ($proveedor>0,function ($query) use ($proveedor)
                        {
                            $query->where('proveedor',$proveedor);
                        })
                        ->when (Auth::user()->puesto!='ADMIN',function ($query)
                        {
                            $query->where('asignacion',Auth::user()->locacion);
                        })
                        ->when($filtro && $filtro_text!='',function ($query) use ($filtro_text)
                            {
                                $query->where(function ($anidado) use ($filtro_text){
                                    $anidado->where('familia','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('modelo','like','%'.$filtro_text.'%');
                                    $anidado->orWhere('imei','like','%'.$filtro_text.'%');
                                });               
                            })        
                        ->get();
        }           
        
        if($filtro && $excel=="NO")
        {
            $registros->appends([
                    'filtro'=>'ACTIVE',
                    'query' => $filtro_text,
                    'asignacion'=>$asignacion,
                    'proveedor'=>$proveedor,
                    ]);   
        }            
        $locaciones=Locacion::orderBy('nombre')
                    ->when (Auth::user()->puesto!='ADMIN',function ($query)
                    {
                        $query->where('id',Auth::user()->locacion);
                    })
                    ->get();
        return(view($excel=="NO"?'inventario.base_inventario':'inventario.export',['registros'=>$registros,'query'=>$filtro_text,'asignacion'=>$asignacion,'proveedor'=>$proveedor,'excel'=>$excel,'locaciones'=>$locaciones]));
    }
}
