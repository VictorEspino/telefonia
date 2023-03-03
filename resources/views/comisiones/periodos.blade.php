<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ttds leading-tight">
            {{'Periodos - Comisiones'}}
        </h2>
    </x-slot>
    <div class="flex flex-col w-full text-gray-700 px-2 md:px-8">
        <div class="w-full rounded-t-lg bg-slate-300 p-3 flex flex-col border-b border-gray-800"> <!--ENCABEZADO-->
            <div class="w-full text-lg font-semibold">Periodos</div>
            <div class="w-full text-sm">({{Auth::user()->usuario}}) - {{Auth::user()->name}}</div>            
            <div class="w-full text-sm">{{App\Models\User::with('locacion_desc')->find(Auth::user()->id)->locacion_desc->nombre}}</div>            
        </div> <!--FIN ENCABEZADO-->
        <div class="flex flex-wrap">
            @foreach($periodos as $periodo)
            
            <div class="w-full md:w-1/3 flex flex-row p-4">
                <div class="w-full flex p-3 flex-row rounded-lg shadow-xl bg-ttds-secundario-2 rounded-lg shadow-xl">
                    <div class="w-5/6 p-2 flex items-center">
                        <div class="w-full flex flex-col justify-center">
                            <div class="w-full text-xl text-yellow-500 font-bold flex justify-start"><i class="fas fa-th-large"></i></div>
                            <div class="w-full text-xl text-gray-500 font-bold flex justify-start">Comisiones semanal</div>
                            <div class="w-full text-xs text-gray-700 flex justify-start">Dia de pago {{$periodo->dia_pago}}</div>
                            <div class="w-full text-lg {{$periodo->pagado==1?'text-green-500':'text-red-500'}} font-semibold flex justify-start">{{$periodo->pagado==1?'CALCULADO':'PENDIENTE'}}</div>                
                        </div>
                    </div>
                    <div class="w-1/6 text-3xl font-thin text-gray-500 flex flex-col text-center">                        
                        <div class="w-full py-2 text-gray-500">
                            <a href="{{route('detalle_comisiones',['id'=>$periodo->id])}}" title="Comisiones Periodo">
                             <i class="fas fa-handshake"></i>
                            </a>
                        </div>
                    </div>    
                </div>
            </div>
            
            @endforeach
        </div>
        @if(session('status')!='')
            <div class="w-full flex justify-center p-3 bg-green-300 rounded-b-lg">
                <span class="font-semibold text-sm text-gray-600">{{session('status')}}</span>
            </div>    
        @endif
    </div>
    
</x-app-layout>