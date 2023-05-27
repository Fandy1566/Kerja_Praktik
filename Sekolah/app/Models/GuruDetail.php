<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruDetail extends Model
{
    use HasFactory;
    protected $table = 'guru_detail';

    public function Guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }

}
