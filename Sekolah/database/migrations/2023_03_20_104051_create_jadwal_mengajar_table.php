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
        if (!Schema::hasTable('jadwal_mengajar')) {
            Schema::create('jadwal_mengajar', function (Blueprint $table) {
                $table->id();
                $table->string('kode_jadwal_mengajar',4)->unique();
                $table->unsignedBigInteger('id_hari');
                $table->foreign('id_hari')->references('id')->on('hari');
                $table->time('waktu_awal');
                $table->time('waktu_akhir');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_mengajar');
    }
};
