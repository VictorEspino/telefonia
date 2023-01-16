<div>    
    <div class="w-full text-3xl flex flex-col">
        <div class="w-full">
            <i class="text-blue-400 fas fa-pen" wire:click='edit_open' style="cursor: pointer;"></i>
        </div>
        <div class="text-xs w-full">
            Editar
        </div>
    </div>
    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
        <x-slot name="title">
            <div class="w-full flex flex-row">
                <div class="w-1/2">
                    Editar usuario
                </div>
                <div class="w-1/4">
                    <x-jet-button wire:click.prevent="cambiar_estatus">Marcar como {{$estatus=='1'?'INACTIVO':'ACTIVO'}}</x-jet-button>
                </div>
                <div class="w-1/4">
                    <x-jet-button wire:click.prevent="reset_password">Reset Password</x-jet-button>
                </div>
            </div>
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-1/2">
                        <x-jet-label value="User" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="usuario" readonly/>
                        @error('usuario') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Email" />
                        <x-jet-input class="w-full text-sm" type="text"  wire:model.defer="email"/>
                        @error('email') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                        </div>
                </div>
                <div class="w-full mb-2">
                    <x-jet-label value="Nombre" />
                    <x-jet-input class="w-full text-sm" type="text" wire:model.defer="nombre"/>
                    @error('nombre') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full mb-2">
                    <x-jet-label value="Puesto" />                    
                    <select name="puesto" wire:model.defer="puesto" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value=''></option>
                        @foreach($puestos as $puesto_opcion)
                        <option value='{{$puesto_opcion->nombre}}'>{{$puesto_opcion->nombre}}</option>
                        @endforeach
                    </select> 
                    @error('puesto') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
                <div class="w-full mb-2 flex flex-row space-x-3">
                    <div class="w-full">
                        <x-jet-label value="Locacion" />
                        <select name="locacion" wire:model="locacion" class="w-full text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option></option>
                            @foreach($locaciones as $opcion)
                                <option value="{{$opcion->id}}">{{$opcion->nombre}}</option>
                            @endforeach
                        </select>  
                        @error('locacion') <span class="text-xs text-red-400">{{ $message }}</span> @enderror 
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button {{$procesando==1?'disabled':''}} class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' wire:click.prevent="guardar">GUARDAR</button>
        </x-slot>
    </x-jet-dialog-modal>
</div>