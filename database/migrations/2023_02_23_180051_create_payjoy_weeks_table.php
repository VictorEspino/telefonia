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
        Schema::create('payjoy_weeks', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_time');
            $table->string('merchant_name');
            $table->string('device');
            $table->string('transaction_type');
            $table->string('device_family');
            $table->string('device_model');
            $table->string('imei');
            $table->string('sales_clerk_id');
            $table->string('sales_clerk_name');
            $table->string('months');
            $table->string('dinero_payjoy');
            $table->string('dinero_nuestro');
            $table->foreignId('semana_negocio_id');
            $table->string('carga_id');
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
        Schema::dropIfExists('payjoy_weeks');
    }
};
