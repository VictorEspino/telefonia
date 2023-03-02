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
        Schema::create('semana_negocios', function (Blueprint $table) {
            $table->id();
            $table->date('dia_inicio');
            $table->date('dia_fin');
            $table->string('proveedor');
            $table->integer('conciliado');
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
        Schema::dropIfExists('semana_negocios');
    }
};
