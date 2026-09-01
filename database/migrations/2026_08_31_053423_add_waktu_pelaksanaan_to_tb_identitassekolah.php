<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table("tb_identitassekolah", function (Blueprint $table) {
            $table->dateTime("waktu_pelaksanaan")->nullable();
        });
    }
    public function down(): void {
        Schema::table("tb_identitassekolah", function (Blueprint $table) {
            $table->dropColumn("waktu_pelaksanaan");
        });
    }
};
