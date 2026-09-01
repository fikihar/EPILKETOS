<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_datapilketos', function (Blueprint $table) {
            $table->id();
            $table->string('tapel', 20)->nullable();
            $table->date('tgl')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_datapilketos');
    }
};
