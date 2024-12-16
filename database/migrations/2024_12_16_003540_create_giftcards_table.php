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
        Schema::create('giftcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('comprado_por')->nullable()->index('fk_giftcards_comprador');
            $table->unsignedBigInteger('beneficiador_id')->nullable()->index('beneficiador_id');
            $table->unsignedBigInteger('trabajador_id')->nullable()->index('trabajador_id');
            $table->unsignedBigInteger('promocion_id')->nullable()->index('promocion_id');
            $table->decimal('valor', 10);
            $table->text('mensaje_personalizado')->nullable();
            $table->date('fecha_compra');
            $table->date('fecha_expiracion');
            $table->date('fecha_cobro')->nullable();
            $table->enum('estatus_giftcard', ['activa', 'por_expirar', 'vencida', 'cobrada']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giftcards');
    }
};
