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
        // Schema::create('jadwal_detail', function (Blueprint $table) {
        //     $table->id();
        //     // $table->unsignedBigInteger('id_jadwal');
        //     // $table->foreign('id_jadwal')->references('id')->on('jadwal')->onDelete('cascade');
        //     // $table->unsignedBigInteger('id_jam');
        //     // $table->foreign('id_jam')->references('id')->on('jadwal_mengajar')->onDelete('cascade');
        //     // $table->unsignedBigInteger('id_guru')->nullable();
        //     // $table->foreign('id_guru')->references('id')->on('users')->onDelete('cascade');
        //     // $table->unsignedBigInteger('id_mata_pelajaran')->nullable();
        //     // $table->foreign('id_mata_pelajaran')->references('id')->on('mata_pelajaran')->onDelete('cascade');
        //     // $table->unsignedBigInteger('id_kelas');
        //     // $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
        //     $table->unsignedBigInteger('id_jadwal');
        //     $table->json('kelas_7');
        //     $table->json('kelas_8');
        //     $table->json('kelas_9');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_detail');
    }
};
