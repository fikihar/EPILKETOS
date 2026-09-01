<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_pilih', function (Blueprint $table) {
            $table->id('id_pilih');
            $table->string('nisn', 32);    // calon yang dipilih
            $table->string('username', 32); // siswa yang memilih
            $table->timestamps();

            // Foreign keys
            $table->foreign('nisn')
                  ->references('nisn')
                  ->on('tb_pilihan')
                  ->cascadeOnDelete();

            $table->foreign('username')
                  ->references('username')
                  ->on('tb_siswa')
                  ->cascadeOnDelete();

            // 1 siswa hanya boleh vote 1x
            $table->unique('username');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_pilih');
    }
};
