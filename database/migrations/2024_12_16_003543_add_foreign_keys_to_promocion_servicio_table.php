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
        Schema::table('promocion_servicio', function (Blueprint $table) {
            $table->foreign(['promocion_id'], 'promocion_servicio_ibfk_1')->references(['id'])->on('promociones')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['servicio_id'], 'promocion_servicio_ibfk_2')->references(['id'])->on('servicios')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promocion_servicio', function (Blueprint $table) {
            $table->dropForeign('promocion_servicio_ibfk_1');
            $table->dropForeign('promocion_servicio_ibfk_2');
        });
    }
};
