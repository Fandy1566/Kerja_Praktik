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
        Schema::create('jadwal_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_jam');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->unsignedBigInteger('id_kelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_detail');
    }
};
