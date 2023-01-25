<div>
    <i wire:click="abrir" class="px-3 far fa-money-bill-alt text-green-500 text-xl" style="cursor:pointer"></i>

    <x-jet-dialog-modal wire:model="open" maxWidth="2xl">
        <x-slot name="title">
            Registro de Venta
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
                        <x-jet-input class="w-full text-sm font-bold" type="text" wire:model.defer="precio" readonly/>
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
            <div class="flex flex-col w-full border-b border-red-500">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-full">
                    <x-jet-label class="font-bold text-red-500 text-base" value="Datos de venta - Enganche {{number_format(100*$porcentaje_enganche,2)}}%" />
                        
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full pt-4">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-full">
                    <x-jet-label value="Cliente" />
                        <x-jet-input class="w-full text-base font-bold text-blue-600" type="text" wire:model.defer="cliente"/>
                        @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-1/2">
                    <x-jet-label value="Enganche" />
                        <x-jet-input class="w-full text-base font-bold text-blue-600" type="text" wire:model="enganche"/>
                        @error('enganche') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/2">
                    <x-jet-label value="Forma de pago" />
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="forma_pago" wire:model.defer="forma_pago">
                            <option value="EFECTIVO" class="">EFECTIVO</option>
                            <option value="CLIP" class="">CLIP</option>
                        </select>  
                        @error('forma_pago') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
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