<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
    /* The side navigation menu */
.sidenav {
  height: 100%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  /*z-index: 1; /* Stay on top */
  /*top: 0; /* Stay at the top */
  /*left: 0;*/
  font-size: 14px;
  background-color:#383c3f; /* Black*/
  overflow-x: hidden; /* Disable horizontal scroll */
  overflow-y: scroll;
  padding-top: 25px; /* Place content 60px from the top */
  transition: 0.2s; /* 0.5 second transition effect to slide in the sidenav */
}

/* The navigation menu links */
.OLD_sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 18px;
  color: #919191;
  display: block;
  transition: 0.3s;
}

/* When you mouse over the navigation links, change their color */
.sidenav a:hover {
  color: #f1f1f1;
}

/* Position and style the close button (top right corner) */
.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 25px;
  margin-left: 50px;
}

/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main {
  transition: margin-left .5s;
  padding: 20px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 14px;}
}

</style>

    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            
            @if (isset($header))
                <header class="bg-gray-100">
                

                <div id="mySidenav" class="sidenav flex flex-col">
                    <div class="flex flex-col overflow-y-auto">
                        <div><a href="javascript:void(0)" class="closebtn text-gray-100 hover:text-lime-200" onclick="closeNav()">&times;</a></div>
                        <div class="px-3 text-white flex flex-col">
                            <div class="text">
                                <i class="fas fa-tasks"></i>
                                Plantilla
                            </div>
                            <div class="flex flex-col">

                                <div class="pl-5 pt-2 text-lime-300">
                                    <a href="{{route('usuarios')}}">
                                        <span class="text-gray-200"><i class="fas fa-user-tie"></i></span>
                                        Usuarios
                                    </a>
                                </div>         
                             </div>
                             <div class="text pt-2">
                                <i class="fas fa-tasks"></i>
                                Inventario
                            </div>
                            <div class="flex flex-col">
                                <div class="pl-5 pt-2 text-lime-300">
                                    <a href="{{route('cargar_inventario')}}">
                                        <span class="text-blue-400"><i class="fas fa-upload"></i></span>
                                         Cargar nuevos equipos
                                    </a>
                                </div>     
                                <div class="pl-5 pt-2 text-lime-300">
                                    <a href="{{route('base_inventario')}}">
                                        <span class="text-red-400"><i class="fas fa-warehouse"></i></span>
                                         Sucursal
                                    </a>
                                </div>       
                             </div>
                             <div class="text pt-2">
                                <i class="fas fa-tasks"></i>
                                Gastos
                            </div>
                            <div class="flex flex-col">
                                <div class="pl-5 pt-2 text-lime-300">
                                    <a href="{{route('gasto_nuevo')}}">
                                        <span class="text-green-500"><i class="far fa-money-bill-alt"></i></span>
                                         Registrar Gasto
                                    </a>
                                </div>       
                                <div class="pl-5 pt-2 text-lime-300">
                                    <a href="{{route('seguimiento_gastos')}}">
                                        <span class="text-green-500"><i class="far fa-money-bill-alt"></i></span>
                                         Seguimiento Gastos
                                    </a>
                                </div>   
                             </div>
                             <div class="text pt-2">
                                <i class="fas fa-tasks"></i>
                                Comisiones
                            </div>
                            <div class="flex flex-col">
                                <div class="pl-5 pt-2 text-lime-300">
                                    <a href="{{route('dashboard')}}">
                                        <span class="text-green-500"><i class="far fa-money-bill-alt"></i></span>
                                         Pagos de Comisiones
                                    </a>
                                </div>        
                             </div>
                             <div class="text pt-2">
                                <i class="fas fa-tasks"></i>
                                Reportes
                            </div>
                            <div class="flex flex-col">
                                <div class="pl-5 pt-2 text-lime-300">
                                    <a href="{{route('reporte_diario')}}">
                                        <span class="text-yellow-500"><i class="fas fa-print"></i></span>
                                         Reporte diario
                                    </a>
                                </div>        
                             </div>
                            <div class="px-3 text-[#383c3f] flex flex-col">.
                            </div>
                            <div class="px-3 text-[#383c3f] flex flex-col">.
                            </div>
                            <div class="px-3 text-[#383c3f] flex flex-col">.
                            </div>
                            <div class="px-3 text-[#383c3f] flex flex-col">.
                            </div>
                            <div class="px-3 text-[#383c3f] flex flex-col">.
                            </div>
                            <div class="px-3 text-[#383c3f] flex flex-col">.
                            </div>
                            <div class="px-3 text-[#383c3f] flex flex-col">.
                            </div>
                            <div class="px-3 text-[#383c3f] flex flex-col">.
                            </div>
                        </div> 
                    </div>
                </div>

                <div class="max-w-7xl mx-auto py-4 px-2 sm:px-2 px-4 flex justify-between flex-row">
                    <div class="flex">
                        <span onclick="openNav()" class="text-lime-900 font-bold text-2xl">
                        <i class="fas fa-bars"></i></span>
                    </div>
                    <div> 
                        <h2 class="font-semibold leading-tight text-ttds text-lg">    
                            {{ $header }} 
                        </h2>
                    </div>
                </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
            <div class="py-2">
                <div class="w-full px-3 lg:px-5">
                    {{ $slot }}
                </div>
                </div>
                
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <script>
        /* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "220px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
<script>
            Livewire.on('alert_ok',function(message)
            {
                Swal.fire(
                    'OK!',
                    message,
                    'success'
                )

            });
        </script>
        <script>
            Livewire.on('livewire_to_controller',function(forma)
            {
                document.getElementById(forma).submit();
            });
        </script>  
    </body>
</html>
