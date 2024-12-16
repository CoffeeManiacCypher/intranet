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
        Schema::create('fichas_medicas', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('paciente_id')->index('paciente_id');
            $table->bigInteger('trabajador_id')->index('trabajador_id');
            $table->bigInteger('servicio_id')->index('servicio_id');
            $table->string('archivo');
            $table->enum('tipo_archivo', ['pdf', 'docx']);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichas_medicas');
    }
};
