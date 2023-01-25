<?php

namespace App\Http\Livewire\Inventario;

use Livewire\Component;
use App\Models\Inventario;
use App\Models\Locacion;

class CambiarAsignacion extends Component
{
    public $open=false;
    public $id_inventario;

    public $procesando=0;
    public $procesando2=0;

    public $locaciones=[];

    public $asignacion;
    public $proveedor;
    public $tag;
    public $familia;
    public $modelo;
    public $precio;
    public $imei;

    public $locacion_actual;

    public $nueva_locacion;

    public function render()
    {
        return view('livewire.inventario.cambiar-asignacion');
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
        
        $this->locaciones=Locacion::all();

        $this->asignacion=$inventario->asignacion_desc->nombre;
        $this->proveedor=$inventario->proveedor_desc->nombre;
        $this->familia=$inventario->familia;
        $this->modelo=$inventario->modelo;
        $this->precio=$inventario->precio;
        $this->imei=$inventario->imei;
        $this->locacion_actual=$inventario->asignacion;
        $this->nueva_locacion=$this->locacion_actual;
        
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
        $this->locacion_actual="";
    }
    public function guardar()
    {
        $this->validate([
            'nueva_locacion' => 'required',
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
        if($this->nueva_locacion!=$this->locacion_actual)
        {
            Inventario::where('id',$this->id_inventario)->update([
                'asignacion'=>$this->nueva_locacion,
            ]);
        }
        $this->open=false;
        return redirect(request()->header('Referer'));
    }
}
