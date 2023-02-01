<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Usuario\ShowUsuarios;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ReportesController;

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
