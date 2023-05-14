<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    public function GuruMataPelajaran()
    {
        return $this->hasMany(GuruMataPelajaran::class, 'id_guru', 'id');
    }
}
