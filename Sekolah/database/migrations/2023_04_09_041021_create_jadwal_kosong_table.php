<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'jadwal_kosong';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->id();
                $table->string('kode_'.$this->tableName,4);
                $table->unsignedBigInteger('kode_jam_mengajar');
                $table->foreign('kode_jam_mengajar')->references('id')->on('jam_mengajar');
                $table->unsignedBigInteger('kode_hari');
                $table->foreign('kode_hari')->references('id')->on('hari');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kosong');
    }
};
