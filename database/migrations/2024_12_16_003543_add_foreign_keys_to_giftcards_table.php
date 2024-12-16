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
        Schema::table('giftcards', function (Blueprint $table) {
            $table->foreign(['comprado_por'], 'fk_giftcards_comprador')->references(['id'])->on('pacientes')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['beneficiador_id'], 'giftcards_ibfk_1')->references(['id'])->on('pacientes')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['trabajador_id'], 'giftcards_ibfk_2')->references(['id'])->on('personal')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['promocion_id'], 'giftcards_ibfk_3')->references(['id'])->on('promociones')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('giftcards', function (Blueprint $table) {
            $table->dropForeign('fk_giftcards_comprador');
            $table->dropForeign('giftcards_ibfk_1');
            $table->dropForeign('giftcards_ibfk_2');
            $table->dropForeign('giftcards_ibfk_3');
        });
    }
};
