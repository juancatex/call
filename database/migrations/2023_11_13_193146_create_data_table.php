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
        Schema::create('data', function (Blueprint $table) {
            $table->bigIncrements('iddata');
            $table->string('user',150)->nullable();
            $table->string('menbresia1',50)->nullable();
            $table->string('menbresia2',50)->nullable();
            $table->string('rango',50)->nullable();
            $table->date('fechaini')->nullable()->default(DB::raw('CURRENT_DATE'));
            $table->string('tipouser',50)->nullable();
            $table->string('ci')->nullable(); 
            $table->string('patrocinador',50)->nullable();
            $table->string('correo')->nullable();
            $table->string('tel')->nullable(); 
            $table->date('fechanac')->nullable()->default(DB::raw('CURRENT_DATE'));
            $table->string('nombrecompleto',150)->nullable();
            $table->string('dir')->nullable();
            $table->boolean('status')->default(0)->comment('0=libre,1=en proceso,2=finalizado exitoso,3=finalizado no exitoso'); 
            $table->date('statusfecha')->default(DB::raw('CURRENT_DATE'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
