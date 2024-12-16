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
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paciente_id')->index('paciente_id');
            $table->unsignedBigInteger('servicio_id')->nullable()->index('servicio_id');
            $table->unsignedBigInteger('personal_id')->nullable()->index('personal_id');
            $table->dateTime('fecha_reserva');
            $table->dateTime('fecha_cobro')->nullable();
            $table->enum('estado_pago', ['Pagado', 'Pendiente']);
            $table->enum('asistencia', ['Asistió', 'No asistió', 'Cancelado', 'Pendiente'])->nullable()->default('Pendiente');
            $table->decimal('precio', 10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
