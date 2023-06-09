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
                $table->unsignedBigInteger('id_hari');
                $table->foreign('id_hari')->references('id')->on('hari');
                $table->time('waktu_awal');
                $table->time('waktu_akhir');
                $table->boolean('isDeleted')->default(0);
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
