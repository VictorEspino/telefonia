<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_ejecutivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('locacion_id');
            $table->foreignId('pago_id');
            $table->float('fijo');
            $table->integer('ventas');
            $table->integer('rango1');
            $table->float('comision_r1');
            $table->integer('rango2');
            $table->float('comision_r2');
            $table->integer('rango3');
            $table->float('comision_r3');
            $table->float('total_comisiones');
            $table->float('total_pago');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comision_ejecutivos');
    }
};
