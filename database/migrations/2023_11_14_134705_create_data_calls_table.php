<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_calls', function (Blueprint $table) {
            $table->bigIncrements('iddatacall');
            $table->BigInteger('iddata')->unsigned();
            $table->BigInteger('iduser')->unsigned();
            $table->Integer('iddepartamento')->nullable();
            $table->Integer('idpdp')->nullable();
            $table->string('contacto',50)->nullable(); 
            $table->string('telmod')->nullable();  
            $table->string('dirmod')->nullable();
            $table->string('correomod')->nullable();
            $table->string('obs')->nullable();
            $table->string('obs1')->nullable();
            $table->string('obs2')->nullable();
            $table->string('obs3')->nullable();
            $table->string('obs4')->nullable(); 
            $table->dateTime('fechareg')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('status')->default(0)->comment('0=guardado,1=tomado,2=finalizado exitoso,3=finalizado no exitoso'); 
            $table->timestamps();
            $table->foreign('iddata')->references('iddata')->on('data');
            $table->foreign('iduser')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_calls');
    }
};
