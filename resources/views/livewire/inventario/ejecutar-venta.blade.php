<div>
    <i wire:click="abrir" class="px-3 far fa-money-bill-alt text-green-500 text-xl" style="cursor:pointer"></i>

    <x-jet-dialog-modal wire:model="open" maxWidth="5xl">
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
                        <x-jet-input class="w-full text-sm font-bold text-xl text-red-400" type="text" wire:model.defer="precio" readonly/>
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
            <div class="flex flex-col w-full border-b border-red-500 pb-2">
            </div>    
            <div class="flex flex-col w-full border-b border-red-500 pt-2">
                <div class="w-full mb-2 flex flex-row space-x-4">
                    <div class="w-full flex flex-row">
                        <div class="w-1/2">
                            <x-jet-label class="font-bold text-red-500 text-base" value="Datos de venta - Enganche {{number_format(100*$porcentaje_enganche,2)}}%" />
                        </div>
                        <div class="w-1/2">
                            <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="proveedor_servicio" wire:model.defer="proveedor_servicio">
                                <option value="" class=""></option>
                                @foreach($proveedores_servicio as $prov)
                                <option value="{{$prov->nombre}}" class="" >{{$prov->nombre}}</option>
                                @endforeach
                            </select>  
                        </div> 
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-row">
                <div class="w-3/4">
                    <div class="flex flex-col w-full pt-4">
                        <div class="w-full mb-2 flex flex-row space-x-4">
                            <div class="w-full flex flex-row">
                                <div class="w-3/4">
                                    <x-jet-label value="Cliente" />
                                    <x-jet-input class="w-full text-base font-bold text-blue-600" type="text" wire:model.defer="cliente"/>
                                    @error('cliente') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-1/4 px-3">
                                    <x-jet-label value="Telefono" />
                                    <x-jet-input class="w-full text-base font-bold text-blue-600" type="text" wire:model.defer="telefono"/>
                                    @error('telefono') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                                </div>
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
                </div>
                <div class="w-1/4 p-3 flex items-center">
                    <x-jet-label value="Precio final" />
                    <x-jet-input class="w-full text-base font-bold text-green-600 text-xl" type="text" wire:model="precio_equipo"/>
                    @error('precio_equipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex flex-col w-full border-b border-red-500 pb-2">
            </div>  
            <div class="w-full pt-2">
                <x-jet-label class="font-bold text-red-500 text-base" value="Servicio Telefonico" />
            </div>
            <div class="flex flex-col w-full border-b border-red-500 pb-2">
            </div>  

            <div class="w-full flex flex-row">
                <div class="w-3/4">
                    <div class="flex flex-col w-full pt-4">
                        <div class="w-full mb-2 flex flex-row space-x-4">
                            <div class="w-full flex flex-row">
                                <div class="w-3/4">
                                    <x-jet-label value="Tipo de Servicio" />
                                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="servicio_telefonico" wire:model="servicio_telefonico">
                                        <option value="" class=""></option>
                                        @foreach($catalogo_servicio_telefonico as $prov)
                                        <option value="{{$prov->descripcion}}" class="" >{{$prov->descripcion}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                                <div class="w-1/4 px-3">
                                    <x-jet-label value="Portabilidad" />
                                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="servicio_telefonico" wire:model.defer="servicio_telefonico">
                                        <option value="" class=""></option>
                                        <option value="NO" class="">NO</option>
                                        <option value="SI" class="">SI</option>
                                    </select>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col w-full">
                        <div class="w-full mb-2 flex flex-row space-x-4">
                            <div class="w-full">
                            <x-jet-label value="ICCID" />
                                <x-jet-input class="w-full text-base font-bold text-blue-600" type="text" wire:model="iccid"/>
                                @error('iccid') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-1/4 p-3 flex items-center">
                    <x-jet-label value="Precio final" />
                    <x-jet-input class="w-full text-base font-bold text-green-600 text-xl" type="text" wire:model="precio_servicio"/>
                    @error('precio_servicio') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>
            </div>



            <div class="flex flex-col w-full border-b border-green-500 pb-2">
            </div>  
            <div class="w-full pt-2">
                <x-jet-label class="font-bold text-green-500 text-xl" value="Total a pagar : ${{number_format($total_pago,2)}}" />
            </div>
            <div class="flex flex-col w-full border-b border-green-500 pb-2">
            </div>  
            
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelar">CANCELAR</x-jet-secondary-button>
            <button {{$procesando==1?'disabled':''}} wire:click="guardar" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">GUARDAR<button>
        </x-slot>
    </x-jet-dialog-modal>
</div>