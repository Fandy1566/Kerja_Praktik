<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'guru';

    public function up(): void
    {
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->id();
                $table->string('kode_'.$this->tableName,4);
                $table->string('nama_'.$this->tableName, 50);
                // $table->enum('gender_'.$this->tableName,['L','P','?']);
                // $table->string('no_telp_'.$this->tableName,30);
                // $table->text('alamat_'.$this->tableName);
                $table->boolean('is_active_'.$this->tableName);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
