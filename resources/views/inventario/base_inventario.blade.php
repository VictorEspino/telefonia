<x-app-layout>
    <x-slot name="header">
            {{ __('Inventario') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
        <div class="w-full text-lg font-semibold">Inventario</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('locacion_desc')->find(Auth::user()->id)->locacion_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <form class="w-full" action="{{route('base_inventario')}}" class="">
            <input type="hidden" name="filtro" value="ACTIVE"> 
            <div class="w-full flex flex-row space-x-2 bg-slate-400 py-3 px-3">
                    <div class="w-1/2">
                        <x-jet-label class="text-white text-sm">Buscar familia / modelo / imei</x-jet-label>
                        <x-jet-input class="w-full py-1" type="text" name="query" value="{{$query}}" placeholder=""></x-jet-input>
                    </div>
                    
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Asignacion</x-jet-label>
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="asignacion">
                            <option value="" class=""></option>
                            @foreach($locaciones as $tienda)
                            <option value="{{$tienda->id}}" class="" {{$asignacion==$tienda->id?'selected':''}}>{{$tienda->nombre}}</option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="w-1/6">
                        <x-jet-label class="text-white text-sm">Proveedor</x-jet-label>
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="proveedor">
                            <option value="" class=""></option>
                            <option value="1" class="" {{$proveedor=='1'?'selected':''}}>PAYJOY</option>
                            <option value="2" class="" {{$proveedor=='2'?'selected':''}}>KrediYA</option>                    
                        </select>  
                    </div>
                    @if(Auth::user()->puesto=='ADMIN')
                    <div class="w-1/12">
                        <x-jet-label class="text-white text-sm">Excel</x-jet-label>
                        <select class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm py-1" name="excel">
                            <option value="" class=""></option>
                            <option value="NO" class="" {{$excel=='NO'?'selected':''}}>NO</option>
                            <option value="SI" class="" {{$excel=='SI'?'selected':''}}>SI</option>
                        </select>  
                    </div>
                    @else
                        <input type="hidden" name="excel" value="NO">
                    @endif
                    <div class="w-1/6 flex justify-center">
                        <x-jet-button>Buscar</x-jet-button>
                    </div>
                </form>
            </div>
            </form>
            <div class="flex justify-end text-xs pt-2">
                {{$registros->links()}}
            </div>
            <div class="w-full flex justify-center pt-5 flex-col"> <!--TABLA DE CONTENIDO-->
                <div class="w-full flex justify-center pb-3"><span class="font-semibold text-sm text-gray-700">Registros de Ventas</span></div>
                <div class="w-full flex justify-center">
                <table>
                    <tr class="">
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"></td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Asignacion</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Proveedor</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>TAG</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Familia</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Modelo</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>Precio</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"><center>IMEI</td>
                        <td class="border border-gray-300 font-semibold bg-slate-600 text-gray-200 p-1 text-sm"></td>
                    </tr>
                <?php
                    $color=false;
                    foreach($registros as $registro)
                    {
                ?>
                    <tr class="">
                        <td class="px-3 border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">@livewire('inventario.cambiar-asignacion',['id_inventario'=>$registro->id])</td>
                        <td class="px-3 border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$registro->asignacion_desc->nombre}}</td>
                        <td class="px-3 border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$registro->proveedor_desc->nombre}}</td>
                        <td class="px-3 border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$registro->tag}}</td>
                        <td class="px-3 border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$registro->familia}}</td>
                        <td class="px-3 border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">{{$registro->modelo}}</td>
                        <td class="px-3 border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs"><center>${{number_format($registro->precio,2)}}</td>
                        <td class="px-3 border border-gray-300 {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-sm font-bold"><center>{{$registro->imei}}</td>
                        <td class="border border-gray-300 font-light {{$color?'bg-lime-100':''}} text-gray-700 p-1 text-xs">@livewire('inventario.ejecutar-venta',['id_inventario'=>$registro->id])</td>
                    </tr>
                <?php
                    $color=!$color;
                    }
                ?>
                </table>
                </div>
            </div><!--FIN DE TABLA -->

        </div> <!-- FIN DEL CONTENIDO -->
    </div> <!--DIV PRINCIPAL -->
</x-app-layout>