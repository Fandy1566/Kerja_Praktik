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
        Schema::create('guru_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_guru");
            $table->foreign("id_guru")->references("id")->on("guru");
            $table->unsignedBigInteger("id_mata_pelajaran");
            $table->foreign("id_mata_pelajaran")->references("id")->on("mata_pelajaran");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mata_pelajaran');
    }
};
