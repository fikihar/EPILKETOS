<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_admin', function (Blueprint $table) {
            $table->string('username', 32)->primary();
            $table->string('password', 255); // bcrypt hash
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_admin');
    }
};
