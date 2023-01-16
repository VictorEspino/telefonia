<?php

namespace App\Http\Livewire\Usuario;

use Livewire\Component;
use App\Models\Locacion;
use App\Models\Puesto;

use App\Models\User;

class NuevoUsuario extends Component
{
    public $open=false;
    public $procesando;

    public $usuario;
    public $email;
    public $nombre;
    public $puesto;
    public $locacion;
    public $locaciones=[];
    public $puestos=[];

    public function render()
    {
        return view('livewire.usuario.nuevo-usuario');
    }

    public function mount()
    {
        $this->locaciones=Locacion::where('visible',1)
                        ->orderBy('nombre','asc')
                        ->get();
        $this->puestos=Puesto::where('visible',1)->orderBy('nombre','asc')->get();
    }
    public function nuevo()
    {
        $this->open=true;
        $this->procesando=0;
    }
    public function cancelar()
    {
        $this->open=false;
        $this->email='';
        $this->usuario='';
        $this->nombre='';
        $this->puesto='';
        $this->locacion='';
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function validacion()
    {
        $reglas = [
            'usuario'=>'required|unique:users,usuario',
            'email'=>'required|email|unique:users,email',
            'nombre' => 'required',
            'puesto' => 'required',
            'locacion'=>'required',
          ];
        //dd($reglas);
        $this->validate($reglas,
            [
                'required' => 'Campo requerido.',
                'numeric'=>'Debe ser un numero',
                'unique'=>'El valor ya existe en la base de datos',
                'email'=>'Se requiere una direccion de correo valida'
            ],
          );
    }
    public function guardar()
    {
        $this->validacion();
        $this->procesando=1;

        User::create([
            'usuario'=>$this->usuario,
            'name'=>$this->nombre,
            'puesto'=> $this->puesto,
            'locacion'=> $this->locacion,
            'email'=>$this->email,
            'password'=>'$2y$10$l3Ie3V7nvjxar33TlexunOeoP.0t9EnvwvyEDkCk1sIdjKjoO1oRK',
        ]);


        $this->emit('usuarioAgregado');
        $this->emit('alert_ok','El usuario se creo satisfactoriamente');
        $this->open=false;
        $this->email='';
        $this->usuario='';
        $this->nombre='';
        $this->puesto='';
        $this->locacion='';
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
