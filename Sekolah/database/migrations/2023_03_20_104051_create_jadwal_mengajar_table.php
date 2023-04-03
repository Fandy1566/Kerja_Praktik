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
        // if (!Schema::hasTable('jadwal_mengajar')) {
        //     Schema::create('jadwal_mengajar', function (Blueprint $table) {
        //         $table->id();
        //         $table->string('id_guru')->unsiqned();
        //         $table->foreign('id_guru')->references('id_guru')->on('guru');
        //         $table->string('id_ruang')->unsiqned();
        //         $table->foreign('id_ruang')->references('id_ruangan')->on('ruang');
        //         $table->string('id_mapel')->unsiqned();
        //         $table->foreign('id_mapel')->references('id_mapel')->on('mata_pelajaran');
        //         $table->string('id_jam_mengajar')->unsiqned();
        //         $table->foreign('id_jam_mengajar')->references('id_jam_mengajar')->on('jam_mengajar');
        //         $table->timestamps();
        //     });
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_mengajar');
    }
};
