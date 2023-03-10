<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ttds leading-tight">
            {{ __('Detalle de comisiones')}} <br> Pago {{$pago->dia_pago}}
        </h2>
    </x-slot>
    <div class="flex flex-col w-full bg-white text-gray-700 shadow-lg rounded-lg">
        <div class="w-full rounded-t-lg bg-ttds-encabezado p-3 flex flex-row justify-between border-b border-gray-800"> <!--ENCABEZADO-->
            <div>
            <div class="w-full text-lg font-semibold">Detalle comisiones</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('locacion_desc')->find(Auth::user()->id)->locacion_desc->nombre}}</div>
            </div>
        </div> <!--FIN ENCABEZADO-->
        @if(session('status')!='')
            <div class="w-full flex justify-between flex-row p-3 bg-green-300" id="estatus1">
                <div class="flex justify-center items-center">
                    <span class="font-semibold text-sm text-gray-600">{{session('status')}}</span>
                </div>
                <div>
                    <a href="javascript:eliminar_estatus()"><span class="font-semibold text-base text-gray-600">X</span></a>
                </div>        
            </div>    
        @endif
        <div class="flex flex-col md:space-x-5 md:space-y-0 items-start md:flex-row">
            <div class="w-full md:w-1/2 flex flex-col justify-center md:p-5 p-3">
                <div class="w-full bg-gray-200 flex flex-col p-2 rounded-t-lg">Periodos cerrados</div>
                <div class="w-full flex flex-row border rounded-b-lg shadow-lg pb-5">  
                    <div class="w-full px-3 pt-2">
                        <div class="w-full flex flex-row border-b text-lg font-semibold">
                            <div class="w-2/3">
                                Proveedores
                            </div>
                            <div class="w-1/3 border-b flex justify-center">
                                
                            </div>
                        </div>
                        <div class="w-full flex flex-row border-b text-sm px-3">
                            <div class="w-1/4  flex items-center">
                                PAYJOY
                            </div>
                            <div class="w-3/4 border-b flex justify-center flex flex-row">
                                <div class="w-5/12  flex items-center">
                                    Del <span class="font-bold text-blue-500">{{$periodo_payjoy->dia_inicio}}</span>
                                </div>
                                <div class="w-5/12  flex items-center">
                                    al <span class="font-bold text-blue-500">{{$periodo_payjoy->dia_fin}}</span>
                                </div>
                                <div class="w-1/6 p-3">
                                    @if($periodo_payjoy->conciliado=='1')
                                    <i class="text-base text-green-500 fas fa-check-circle"></i>
                                    @else
                                    <i class="text-base text-red-500 fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex flex-row border-b text-sm px-3">
                            <div class="w-1/4  flex items-center">
                                KREDIYA
                            </div>
                            <div class="w-3/4 border-b flex justify-center flex flex-row">
                                <div class="w-5/12 flex items-center">
                                    Del <span class="font-bold text-blue-500">{{$periodo_krediya->dia_inicio}}</span>
                                </div>
                                <div class="w-5/12 flex items-center">
                                    al <span class="font-bold text-blue-500">{{$periodo_krediya->dia_fin}}</span>
                                </div>
                                <div class="w-1/6 p-3 flex items-center">
                                    @if($periodo_krediya->conciliado=='1')
                                    <i class="text-base text-green-500 fas fa-check-circle"></i>
                                    @else
                                    <i class="text-base text-red-500 fas fa-times-circle"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex flex-row border-b text-sm px-3">
                            <div class="w-1/4  flex items-center">
                                CONTADO
                            </div>
                            <div class="w-3/4 border-b flex justify-center flex flex-row">
                                <div class="w-5/12 flex items-center">
                                    Del <span class="font-bold text-blue-500">{{$periodo_krediya->dia_inicio}}</span>
                                </div>
                                <div class="w-5/12 flex items-center">
                                    al <span class="font-bold text-blue-500">{{$periodo_krediya->dia_fin}}</span>
                                </div>
                                <div class="w-1/6 p-3 flex items-center">
                                    <i class="text-base text-green-500 fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>                        
                    </div>  

                </div>
            </div>      
            <div class="w-1/2 p-12 flex justify-center">
                <form id="forma_finaliza" method="post" action="{{route('calculo_comisiones')}}">
                    @csrf
                    <input type="hidden" name="id_pj" value="{{$periodo_payjoy->id}}">
                    <input type="hidden" name="id_ky" value="{{$periodo_krediya->id}}">
                    <input type="hidden" name="id_pago" value="{{$pago->id}}">
                </form>
                @if($periodo_krediya->conciliado=='1' && $periodo_payjoy->conciliado=='1')
                <button class="border rounded-xl p-5 bg-black text-sm text-gray-100 hover:bg-gray-700" onClick="confirmar_finalizacion()">CALCULAR COMISIONES</button>
                @else
                <span class="text-lg text-red-500"><-- Es necesario que todos los proveedores hayan finalizado su conciliaci??n para ejecutar el calculo de comisiones.</span>
                @endif
            </div>      
        </div>
        @if($pago->pagado=='1')
        <div class="flex flex-col md:space-x-5 md:space-y-0 items-start md:flex-row">
            <div class="w-full md:w-1/2 flex flex-col justify-center md:p-5 p-3">
                <div class="w-full bg-gray-200 flex flex-col p-2 rounded-t-lg">Pagos Ejecutivos</div>
                <div class="w-full flex flex-col border rounded-b-lg shadow-lg pb-5 px-3">  
                    <div class="w-full flex justify-center pt-5">
                        <a href="{{route('export_ejecutivos',['id'=>$pago->id])}}">
                            <i class="text-3xl text-green-500 fas fa-file-excel"></i>
                        </a>
                    </div>
                    <div class="w-full flex justify-center text-sm">Archivo pagos</div>
                    
                </div>
            </div>
            <div class="w-full md:w-1/2 flex flex-col justify-center md:p-5 p-3">
                <div class="w-full bg-gray-200 flex flex-col p-2 rounded-t-lg">Pagos Gerentes</div>
                <div class="w-full flex flex-col border rounded-b-lg shadow-lg pb-5 px-3">  
                
                    
                </div>
                
            </div>            
        </div>
        @endif
    </div>
<!--MODAL CONFIRMACION-->

<div class="fixed hidden inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full" id="modal_finalizacion">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <i class="text-green-500 text-2xl font-bold far fa-check-circle"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 p-3">??Desea continuar?</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Esta operacion realizara el calculo de comisiones y dejara dispobible un estado de cuenta de consulta para los miembros de las tiendas.
                </p>
            </div>
            <div class="px-4 py-3 flex flex-row">
                <div class="w-1/2 flex justify-center">
                    <button onClick="ejecuta_finalizacion()" class="px-3 w-2/3 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                        OK
                    </button>
                </div>
                <div class="w-1/2 flex justify-center">
                    <button onClick="cancelar_finalizacion()" class="px-3 w-2/3 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fixed hidden inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full" id="modal_procesa">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-36 w-36 rounded-full bg-green-100">
                <svg version="1.1" id="L7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                <path fill="#fff" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                    <animateTransform 
                        attributeName="transform" 
                        attributeType="XML" 
                        type="rotate"
                        dur="2s" 
                        from="0 50 50"
                        to="360 50 50" 
                        repeatCount="indefinite" />
                </path>
                <path fill="#fff" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                    <animateTransform 
                        attributeName="transform" 
                        attributeType="XML" 
                        type="rotate"
                        dur="1s" 
                        from="0 50 50"
                        to="-360 50 50" 
                        repeatCount="indefinite" />
                </path>
                <path fill="#fff" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
                L82,35.7z">
                    <animateTransform 
                        attributeName="transform" 
                        attributeType="XML" 
                        type="rotate"
                        dur="2s" 
                        from="0 50 50"
                        to="360 50 50" 
                        repeatCount="indefinite" />
                </path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 p-3" id="mensaje">Procesando</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Esta operacion puede tardar algunos segundos.
                </p>
            </div>
        </div>
    </div>
</div>
<!--FIN MODALES-->






    <script type="text/javascript">
        function ejecuta_finalizacion() 
        {
            document.getElementById('forma_finaliza').submit();
        }
        function confirmar_finalizacion()
        {
            document.getElementById('modal_finalizacion').style.display="block"
        }
        function cancelar_finalizacion()
        {
            document.getElementById('modal_finalizacion').style.display="none"
        }
        @if(session('status')!='')

            //setTimeout(eliminar_estatus(), 6000);
            function eliminar_estatus() {
                document.getElementById("estatus1").style.display="none";
                document.getElementById("estatus2").style.display="none";
                }   
        @endif
        </script>
</x-app-layout>