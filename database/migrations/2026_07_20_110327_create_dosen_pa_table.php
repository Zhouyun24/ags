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
    Schema::create('dosen_pa', function (Blueprint $table) {
        $table->string('nip', 12)->primary();
        $table->string('program_studi', 32);
        $table->string('id_pengguna', 12);
        $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_pa');
    }
};
