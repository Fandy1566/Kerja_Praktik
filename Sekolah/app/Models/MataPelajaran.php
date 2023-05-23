<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    public function GuruMataPelajaran()
    {
        return $this->hasMany(GuruMataPelajaran::class, 'id_mata_pelajaran', 'id');
    }
}
