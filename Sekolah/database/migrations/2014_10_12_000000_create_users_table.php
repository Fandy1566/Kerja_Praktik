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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('foto_profil')->nullable();
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_kepala_sekolah')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_guru_tetap')->default(1);
            $table->string('password');
            $table->boolean('is_guru_kelas_7')->default(1);
            $table->boolean('is_guru_kelas_8')->default(1);
            $table->boolean('is_guru_kelas_9')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
