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
        if (!Schema::hasTable('guru')) {
            Schema::create('guru', function (Blueprint $table) {
                $table->id();
                $table->string('id_guru', 8)->unique();
                $table->string('nama_guru', 50);
                $table->enum('gender_guru',['L','P','?']);
                $table->string('no_telp_guru', 13);
                $table->text('alamat_guru');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
