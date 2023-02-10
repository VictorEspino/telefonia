<x-app-layout>
    <x-slot name="header">
            {{ __('Pago - Parcialidad') }}
    </x-slot>
    <form method="post" action="{{route('parcialidades_nuevo')}}">
    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
        <div class="w-full text-lg font-semibold">Pago de parcialidad</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('locacion_desc')->find(Auth::user()->id)->locacion_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
            @csrf
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full flex flex-row space-x-2">
                <div class="w-3/4">
                    <x-jet-label value="Nombre Cliente" />
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="nombre" value="{{old('nombre')}}">
                    @error('nombre') <span class="text-xs text-red-400">{{ $message }}</span> @enderror              
                </div>       
                <div class="w-1/4">
                    <x-jet-label value="Telefono" />
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="telefono" value="{{old('telefono')}}">
                    
                    @error('telefono')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>   
            </div>  
            <div class="w-full flex flex-row space-x-2 pt-3">  
                <div class="w-1/2">
                    <span class="text-xs">IMEI</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="imei" value="{{old('imei')}}">
                    
                    @error('imei')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>   
                <div class="w-1/2">
                    <span class="text-xs">Proveedor</span><br>
                    <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="proveedor_servicio" >
                        <option value="" class=""></option>
                        @foreach($proveedores_servicio as $prov)
                        <option value="{{$prov->nombre}}" class="" >{{$prov->nombre}}</option>
                        @endforeach
                    </select>  
                    
                    @error('proveedor_servicio')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>     
                <div class="w-1/2">
                    <span class="text-xs">Monto</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="monto" value="{{old('monto')}}">
                    
                    @error('monto')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>                     
            </div>  
        </div> <!--FIN CONTENIDO-->
        <div class="w-full flex justify-center py-4 bg-white rounded-b">
            <x-jet-button>GUARDAR</x-jet-button>
        </div>
    </div>
</form>    

</x-app-layout>
