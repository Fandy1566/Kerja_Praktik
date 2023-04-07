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
        Schema::create('guru_jam_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_guru');
            $table->foreign('id_guru')->references('id')->on('guru');
            $table->unsignedBigInteger('id_jam_mengajar');
            $table->foreign('id_jam_mengajar')->references('id')->on('jam_mengajar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_jam_detail');
    }
};
