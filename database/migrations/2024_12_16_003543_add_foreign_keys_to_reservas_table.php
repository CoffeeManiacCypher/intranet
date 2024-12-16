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
        Schema::table('reservas', function (Blueprint $table) {
            $table->foreign(['paciente_id'], 'reservas_ibfk_1')->references(['id'])->on('pacientes')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['servicio_id'], 'reservas_ibfk_2')->references(['id'])->on('servicios')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['personal_id'], 'reservas_ibfk_3')->references(['id'])->on('personal')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign('reservas_ibfk_1');
            $table->dropForeign('reservas_ibfk_2');
            $table->dropForeign('reservas_ibfk_3');
        });
    }
};
