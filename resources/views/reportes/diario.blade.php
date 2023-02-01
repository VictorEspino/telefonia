<x-app-layout>
    <x-slot name="header">
            {{ __('Reportes - Diario') }}
    </x-slot>

    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
        <div class="w-full text-lg font-semibold">Reporte Diario</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('locacion_desc')->find(Auth::user()->id)->locacion_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        
        <div class="w-full rounded-b-lg bg-white p-3 flex flex-col"> <!--CONTENIDO-->
            <div class="w-full flex flex-row">
                <div class="w-1/3">
                    <form action="{{route('reporte_diario')}}" class="">
                        <input class="w-8/12 rounded p-1 border border-gray-300" type="date" name="query" value="{{$query}}"> 
                        <button class="rounded p-1 border bg-green-500 hover:bg-green-700 text-gray-100 font-semibold">Buscar</button>
                    </form>
                </div>
            </div>

            <div class="w-full flex justify-center pt-5 flex-col text-center"> <!--TABLA DE CONTENIDO-->
                <div class="w-full flex justify-center pb-3"><span class="font-semibold text-sm text-gray-700">Reporte del dia {{$query}}</span></div>
                <!--PAYJOY-->
                <div class="w-full flex justify-center flex-row">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row border-t border-b">
                        <div class="w-1/4 px-4 py-4 text-lg font-bold bg-lime-400 text-white">PAYJOY</div>
                        <div class="w-1/4 flex items-center justify-center">Ventas del Día</div>
                        <div class="w-1/4 flex items-center justify-center">Acumulado Semanal</div>
                        <div class="w-1/4 flex items-center justify-center">Acumulado Mensual</div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row pt-2">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Unidades Vendidas</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='PAYJOY')
                                    {{$venta_dia->ventas}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='PAYJOY')
                                    {{$venta_semana->ventas}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='PAYJOY')
                                    {{$venta_mes->ventas}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Enganches</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='PAYJOY')
                                    ${{number_format($venta_dia->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='PAYJOY')
                                    ${{number_format($venta_semana->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='PAYJOY')
                                    ${{number_format($venta_mes->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Precio Venta</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='PAYJOY')
                                    ${{number_format($venta_dia->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='PAYJOY')
                                    ${{number_format($venta_semana->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='PAYJOY')
                                    ${{number_format($venta_mes->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <!--END PAYJOY-->
                <!--PAYJOY-->
                <div class="w-full flex justify-center flex-row pt-3">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row border-t border-b">
                        <div class="w-1/4 px-4 py-4 text-lg font-bold bg-yellow-400 text-white">CONTADO</div>
                        <div class="w-1/4 flex items-center justify-center">Ventas del Día</div>
                        <div class="w-1/4 flex items-center justify-center">Acumulado Semanal</div>
                        <div class="w-1/4 flex items-center justify-center">Acumulado Mensual</div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row pt-2">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Unidades Vendidas</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='CONTADO')
                                    {{$venta_dia->ventas}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='CONTADO')
                                    {{$venta_semana->ventas}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='CONTADO')
                                    {{$venta_mes->ventas}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Enganches</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='CONTADO')
                                    ${{number_format($venta_dia->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='CONTADO')
                                    ${{number_format($venta_semana->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='CONTADO')
                                    ${{number_format($venta_mes->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Precio Venta</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='CONTADO')
                                    ${{number_format($venta_dia->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='CONTADO')
                                    ${{number_format($venta_semana->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='CONTADO')
                                    ${{number_format($venta_mes->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <!--END PAYJOY-->
                <!--PAYJOY-->
                <div class="w-full flex justify-center flex-row pt-3">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row border-t border-b">
                        <div class="w-1/4 px-4 py-4 text-lg font-bold bg-red-400 text-white">KREDIYA</div>
                        <div class="w-1/4 flex items-center justify-center">Ventas del Día</div>
                        <div class="w-1/4 flex items-center justify-center">Acumulado Semanal</div>
                        <div class="w-1/4 flex items-center justify-center">Acumulado Mensual</div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row pt-2">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Unidades Vendidas</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='KREDIYA')
                                    {{$venta_dia->ventas}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='KREDIYA')
                                    {{$venta_semana->ventas}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='KREDIYA')
                                    {{$venta_mes->ventas}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Enganches</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='KREDIYA')
                                    ${{number_format($venta_dia->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='KREDIYA')
                                    ${{number_format($venta_semana->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='KREDIYA')
                                    ${{number_format($venta_mes->enganches,0)}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <div class="w-full flex justify-center flex-row">
                    <div class="w-1/4"></div>
                    <div class="w-1/2 flex flex-row">
                        <div class="w-1/4">Precio Venta</div>
                        <div class="w-1/4">
                            @foreach($ventas_dia as $venta_dia)
                                @if($venta_dia->proveedor=='KREDIYA')
                                    ${{number_format($venta_dia->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_semana as $venta_semana)
                                @if($venta_semana->proveedor=='KREDIYA')
                                    ${{number_format($venta_semana->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                        <div class="w-1/4">
                            @foreach($ventas_mes as $venta_mes)
                                @if($venta_mes->proveedor=='KREDIYA')
                                    ${{number_format($venta_mes->precio_venta,0)}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="w-1/4"></div>
                </div>
                <!--END PAYJOY-->
            </div><!--FIN DE TABLA -->

        </div> <!-- FIN DEL CONTENIDO -->
    </div> <!--DIV PRINCIPAL-->
</x-app-layout>
