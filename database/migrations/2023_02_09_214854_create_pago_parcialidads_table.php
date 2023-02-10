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
        Schema::create('pago_parcialidads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('locacion_id');
            $table->string('nombre');
            $table->string('imei');
            $table->string('telefono');
            $table->string('proveedor');
            $table->float('monto');
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
        Schema::dropIfExists('pago_parcialidads');
    }
};
