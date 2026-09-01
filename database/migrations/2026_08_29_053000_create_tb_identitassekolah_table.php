<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_identitassekolah', function (Blueprint $table) {
            $table->string('npsn', 15)->primary();
            $table->string('nm_sekolah', 64);
            $table->string('jln', 64)->nullable();
            $table->string('desa', 32)->nullable();
            $table->string('kec', 32)->nullable();
            $table->string('kab', 32)->nullable();
            $table->string('kpl_sekolah', 64)->nullable();
            $table->string('nip', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_identitassekolah');
    }
};
