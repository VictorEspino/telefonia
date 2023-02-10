<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Usuario\ShowUsuarios;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\AdicionalesController;
use App\Http\Controllers\PagoParcialidadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/usuarios',ShowUsuarios::class)->name('usuarios')->middleware('auth');
Route::get('/upload_inventario',[InventarioController::class,'show_upload'])->name('cargar_inventario')->middleware('auth');
Route::post('/upload_inventario',[InventarioController::class,'inventario_import'])->name('cargar_inventario')->middleware('auth');
Route::get('/base_inventario',[InventarioController::class,'base_inventario'])->middleware('auth')->name('base_inventario');

Route::get('/gasto_nuevo',[GastoController::class,'show_nuevo'])->name('gasto_nuevo')->middleware('auth');
Route::post('/gasto_nuevo',[GastoController::class,'save_nuevo'])->name('gasto_nuevo')->middleware('auth');
Route::get('/gasto_seguimiento',[GastoController::class,'seguimiento_gastos'])->name('seguimiento_gastos')->middleware('auth');
Route::post('/gasto_borrar',[GastoController::class,'gasto_borrar'])->middleware('auth');

Route::get('/reporte_diario',[ReportesController::class,'diario'])->middleware('auth')->name('reporte_diario');


Route::get('/venta_adicionales',[AdicionalesController::class,'show_nuevo'])->name('venta_adicionales')->middleware('auth');
Route::post('/venta_adicionales',[AdicionalesController::class,'save_nuevo'])->name('adicionales_nuevo')->middleware('auth');
Route::get('/adicionales_seguimiento',[AdicionalesController::class,'seguimiento_adicionales'])->name('seguimiento_adicionales')->middleware('auth');
Route::post('/adicionales_borrar',[AdicionalesController::class,'adicionales_borrar'])->middleware('auth');

Route::get('/nuevo_parcialidad',[PagoParcialidadController::class,'show_nuevo'])->name('nuevo_parcialidad')->middleware('auth');
Route::post('/save_parcialidades',[PagoParcialidadController::class,'save_nuevo'])->name('parcialidades_nuevo')->middleware('auth');
Route::get('/parcialidades_seguimiento',[PagoParcialidadController::class,'seguimiento_parcialidades'])->name('seguimiento_parcialidades')->middleware('auth');
Route::post('/parcialidades_borrar',[PagoParcialidadController::class,'parcialidades_borrar'])->middleware('auth');