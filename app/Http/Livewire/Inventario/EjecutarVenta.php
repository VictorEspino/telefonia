<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;

use App\Models\Inventario;
use App\Models\Venta;
use App\Models\Proveedor;
use App\Models\CatalogoServicioTelefonico;
use Illuminate\Support\Facades\Auth;

class EjecutarVenta extends Component
{
    public $open=false;
    public $id_inventario;

    public $procesando=0;
    public $procesando2=0;


    public $asignacion;
    public $proveedor;
    public $tag;
    public $familia;
    public $modelo;
    public $precio;
    public $imei;

    public $locacion_actual;

    public $cliente;
    public $tipo_enganche;
    public $porcentaje_enganche;
    public $enganche;
    public $forma_pago="EFECTIVO";

    public $proveedores_servicio=[];
    public $proveedor_servicio;
    public $precio_equipo;
    public $telefono;

    public $catalogo_servicio_telefonico=[];
    public $servicio_telefonico="SIN SERVICIO";
    public $precios_servicio=[];
    public $precio_servicio=0;
    public $iccid;
    public $total_pago;
    public $portabilidad;

    public function render()
    {   
        return view('livewire.inventario.ejecutar-venta');
    }
    public function updatedEnganche()
    {
        $this->validate([
            'enganche' => 'required|numeric|min:1',
        ],
        [
            'required' => 'Campo requerido.',
            'numeric'=>'Debe ser un numero',
            'min'=>'Valor invalido'
        ]);
        if($this->precio>0 && $this->enganche!="")
        {
                $this->porcentaje_enganche=$this->enganche/$this->precio;   
        }
        else
        {
            $this->porcentaje_enganche=0;
        }
        
    }
    public function mount($id_inventario)
    {
        $this->id_inventario=$id_inventario;
        //dd($this->proveedores_servicio);
    }
    public function abrir()
    {
        $this->procesando=0;
        $this->open=true;
        $inventario=Inventario::with('asignacion_desc','proveedor_desc')
                    ->find($this->id_inventario);
        $this->proveedores_servicio=Proveedor::where('visible',1)->where('tipo',2)->get();
        $this->catalogo_servicio_telefonico=CatalogoServicioTelefonico::all();
        foreach($this->catalogo_servicio_telefonico as $servicios)
        {
            $this->precios_servicio[]=['descripcion'=>$servicios->descripcion,'precio'=>$servicios->precio];
        }
        $this->asignacion=$inventario->asignacion_desc->nombre;
        $this->proveedor=$inventario->proveedor_desc->nombre;
        $this->familia=$inventario->familia;
        $this->modelo=$inventario->modelo;
        $this->precio=$inventario->precio;
        $this->imei=$inventario->imei;
        $this->locacion_actual=$inventario->asignacion;
        $this->precio_equipo=$inventario->precio;
        $this->total_pago=$this->precio;
        $this->precio_sevicio=0;
        $this->servicio_telefonico="SIN SERVICIO";
        
            //dd($this->cis_opciones);
    }
    public function cancelar()
    {
        $this->open=false;

        $this->asignacion="";
        $this->proveedor="";
        $this->familia="";
        $this->modelo="";
        $this->precio="";
        $this->imei="";
        $this->enganche="";
        $this->cliente="";
        $this->telefono="";
        $this->portabilidad="";
        $this->precio_equipo="";
        $this->forma_pago="EFECTIVO";
        $this->porcentaje_enganche=0;
        $this->locacion_actual="";
        $this->precios_servicio=[];
        $this->proveedor_servicio="";
        $this->servicio_telefonico="SIN SERVICIO";
        $this->resetErrorBag();
    }
    public function guardar()
    {
        $this->validate([
            'cliente' => 'required',
            'enganche' => 'required|numeric|min:1',
            'forma_pago' => 'required',
            'proveedor_servicio' => 'required',
            'telefono' => 'required|numeric',
            'precio_equipo'=>'required|numeric',
            'portabilidad'=>'required',
            'servicio_telefonico'=>'required'
        ],
        [
            'required' => 'Campo requerido.',
            'numeric'=>'Debe ser un numero',
            'email'=>'Indique una direccion de correo valida',
            'unique'=>'Valor duplicado en base de datos',
            'digits'=>'Debe contener 10 digitos',
            'min'=>'Valor invalido'
        ]);

        $this->procesando=1;

        Venta::create([
            'inventario_id'=>$this->id_inventario,
            'user_id'=>Auth::user()->id,
            'cliente'=>$this->cliente,
            'enganche'=>$this->enganche,
            'forma_pago'=>$this->forma_pago,
            'telefono'=>$this->telefono,
            'precio_equipo'=>$this->precio_equipo,
            'tipo_servicio'=>$this->servicio_telefonico,
            'portabilidad'=>$this->portabilidad,
            'precio_servicio'=>$this->precio_servicio,
            'proveedor'=>$this->proveedor_servicio,
            'iccid'=>$this->iccid,
        ]);
        
        Inventario::where('id',$this->id_inventario)->update([
                'estatus'=>1,
        ]);
    
        $this->open=false;
        return redirect(request()->header('Referer'));
    }
    public function updatedServicioTelefonico()
    {
        //dd($this->servicio_telefonico);
        foreach($this->precios_servicio as $precio_catalogo)
        {
            if($precio_catalogo['descripcion']==$this->servicio_telefonico)
             $this->precio_servicio=$precio_catalogo['precio'];
        }
        $this->total_pago=$this->precio_equipo+$this->precio_servicio;
    }
    public function updatedPrecioServicio()
    {
        $this->total_pago=$this->precio_equipo+$this->precio_servicio;
    }
    public function updatedProveedorServicio()
    {
        if($this->proveedor_servicio=="CONTADO")
        {
            $this->enganche=$this->precio;
            $this->porcentaje_enganche=$this->enganche/$this->precio;   
        }
    }
}
