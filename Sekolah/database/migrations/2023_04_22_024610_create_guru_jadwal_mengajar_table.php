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
        // Schema::create('guru_jadwal_mengajar', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger("id_guru");
        //     $table->foreign("id_guru")->references("id")->on("guru");
        //     $table->unsignedBigInteger("id_jadwal_mengajar");
        //     $table->foreign("id_jadwal_mengajar")->references("id")->on("jadwal_mengajar");
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_jadwal_mengajar');
    }
};
