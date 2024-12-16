<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rut', 12)->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefono', 15)->nullable();
            $table->string('comentario_adicional')->nullable();
            $table->text('direccion')->nullable();
            $table->unsignedBigInteger('ciudad_id')->nullable()->index('ciudad_id');
            $table->string('email')->nullable()->unique('email');
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro']);
            $table->enum('estado_info', ['verificado', 'pendiente'])->nullable()->default('pendiente');
            $table->date('fecha_nacimiento');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
