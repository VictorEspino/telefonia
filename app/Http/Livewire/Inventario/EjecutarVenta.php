<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;

use App\Models\Inventario;
use App\Models\Venta;
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

    public function render()
    {   if($this->precio>0 && $this->enganche!="")
        {
        $this->porcentaje_enganche=$this->enganche/$this->precio;
        }
        else
        {
            $this->porcentaje_enganche=0;
        }
        return view('livewire.inventario.ejecutar-venta');
    }

    public function mount($id_inventario)
    {
        $this->id_inventario=$id_inventario;
    }
    public function abrir()
    {
        $this->procesando=0;
        $this->open=true;
        $inventario=Inventario::with('asignacion_desc','proveedor_desc')
                    ->find($this->id_inventario);
        $this->asignacion=$inventario->asignacion_desc->nombre;
        $this->proveedor=$inventario->proveedor_desc->nombre;
        $this->familia=$inventario->familia;
        $this->modelo=$inventario->modelo;
        $this->precio=$inventario->precio;
        $this->imei=$inventario->imei;
        $this->locacion_actual=$inventario->asignacion;
        
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
        $this->forma_pago="EFECTIVO";
        $this->porcentaje_enganche=0;
        $this->locacion_actual="";
    }
    public function guardar()
    {
        $this->validate([
            'cliente' => 'required',
            'enganche' => 'required|numeric|min:1',
            'forma_pago' => 'required',
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
        ]);
        
        Inventario::where('id',$this->id_inventario)->update([
                'estatus'=>1,
        ]);
    
        $this->open=false;
        return redirect(request()->header('Referer'));
    }
}
