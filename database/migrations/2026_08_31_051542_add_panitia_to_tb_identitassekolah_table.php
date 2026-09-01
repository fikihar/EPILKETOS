<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("tb_identitassekolah", function (Blueprint $table) {
            $table->string("ketua_panitia", 100)->nullable();
            $table->string("nip_panitia", 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table("tb_identitassekolah", function (Blueprint $table) {
            $table->dropColumn(["ketua_panitia", "nip_panitia"]);
        });
    }
};
