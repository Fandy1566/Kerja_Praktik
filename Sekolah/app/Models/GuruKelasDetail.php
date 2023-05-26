<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruKelasDetail extends Model
{
    use HasFactory;
    protected $table = 'guru_mata_pelajaran';

    public function Guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }

}
