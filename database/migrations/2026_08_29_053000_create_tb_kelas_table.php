<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_kelas', function (Blueprint $table) {
            $table->id('kd_kelas');
            $table->string('nm_kelas', 32);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_kelas');
    }
};
