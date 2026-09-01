<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_siswa', function (Blueprint $table) {
            $table->string('username', 32)->primary(); // NISN
            $table->string('password', 255);           // bcrypt
            $table->string('nm_siswa', 64)->nullable();
            $table->char('jk', 1);                    // L / P
            $table->foreignId('kd_kelas')
                  ->nullable()
                  ->constrained('tb_kelas', 'kd_kelas')
                  ->nullOnDelete();
            $table->enum('hadir', ['Hadir', 'Tidak Hadir'])->default('Tidak Hadir');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_siswa');
    }
};
