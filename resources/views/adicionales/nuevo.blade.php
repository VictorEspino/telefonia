<x-app-layout>
    <x-slot name="header">
            {{ __('Venta - Adicional') }}
    </x-slot>
    <form method="post" action="{{route('adicionales_nuevo')}}">
    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
        <div class="w-full text-lg font-semibold">Venta de Adicionales</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('locacion_desc')->find(Auth::user()->id)->locacion_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
            @csrf
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-row"> <!--CONTENIDO-->
            <div class="w-full flex flex-row space-x-2">
                <div class="w-1/3">
                <x-jet-label value="Tipo" />
                <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="tipo">
                    <option value="ACCESORIO" class="">ACCESORIO</option>
                    <option value="OTRO" class="">OTRO</option>
                </select>  
                @error('tipo') <span class="text-xs text-red-400">{{ $message }}</span> @enderror              
                </div>       
                <div class="w-1/2">
                    <span class="text-xs">Descripcion</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="descripcion" value="{{old('descripcion')}}">
                    
                    @error('descripcion')
                      <br><span class="text-xs italic text-red-700 text-xs">{{ $message }}</span>
                    @enderror                    
                </div>      
                <div class="w-1/2">
                    <span class="text-xs">Precio</span><br>
                    <input class="w-full rounded p-1 border border-gray-300" type="text" name="precio" value="{{old('precio')}}">
                    
                    @error('precio')
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
