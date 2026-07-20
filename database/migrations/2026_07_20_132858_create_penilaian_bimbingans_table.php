<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('penilaian_bimbingans', function (Blueprint $table) {
            $table->string('id_perkembangan')->primary();
            $table->integer('skor_keaktifan');
            $table->integer('skor_pemahaman');
            $table->integer('nilai_perkembangan');

            // Foreign Key
            $table->string('id_hasil');
            $table->foreign('id_hasil')->references('id_hasil')->on('hasil_bimbingans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_bimbingans');
    }
};
