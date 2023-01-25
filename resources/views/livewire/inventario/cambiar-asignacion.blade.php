<div>
    <i wire:click="abrir" class="fas fa-warehouse text-orange-500 text-sm" style="cursor:pointer"></i>
    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Cambiar locacion
        </x-slot>
        <x-slot name="content">
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="Proveedor" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="proveedor" readonly/>
                    </div>
                    <div class="w-1/2">
                        <x-jet-label value="Asignacion actual" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="asignacion" readonly/>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/3">
                    <x-jet-label value="Familia" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="familia" readonly/>
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Modelo" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="modelo" readonly/>
                    </div>
                    <div class="w-1/3">
                        <x-jet-label value="Precio" />
                        <x-jet-input class="w-full text-sm" type="text" wire:model.defer="precio" readonly/>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-full">
                    <x-jet-label value="IMEI" />
                        <x-jet-input class="w-full text-4xl font-bold" type="text" wire:model.defer="imei" readonly/>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-full">
                    <x-jet-label value="Nueva locacion" />
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="nueva_locacion" wire:model.defer="nueva_locacion">
                            <option value="0" class=""></option>
                            @foreach($locaciones as $tienda)
                            <option value="{{$tienda->id}}" class="" >{{$tienda->nombre}}</option>
                            @endforeach
                        </select>  
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button {{$procesando==1?'disabled':''}} wire:click="guardar" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">GUARDAR<button>
        </x-slot>
    </x-jet-dialog-modal>
</div>