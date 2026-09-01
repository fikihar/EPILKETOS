<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_pilihan', function (Blueprint $table) {
            $table->string('nisn', 32)->primary();   // NISN calon
            $table->unsignedTinyInteger('no');        // nomor urut kandidat
            $table->string('nama', 64);
            $table->string('photo', 100)->nullable(); // nama file foto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_pilihan');
    }
};
