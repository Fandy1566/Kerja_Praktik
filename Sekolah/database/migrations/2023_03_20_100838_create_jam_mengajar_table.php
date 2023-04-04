<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'jam_mengajar';

    public function up(): void
    {
        if (!Schema::hasTable($this->tableName)) {
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->id();
                $table->string('waktu_'.$this->tableName, 50);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
