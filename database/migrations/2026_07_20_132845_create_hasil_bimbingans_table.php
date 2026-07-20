<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('hasil_bimbingans', function (Blueprint $table) {
            $table->string('id_hasil')->primary();
            $table->text('catatan_bimbingan');
            $table->text('arahan_akademik');

            // Foreign Key
            $table->string('id_jadwal');
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_bimbingans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_bimbingans');
    }
};
