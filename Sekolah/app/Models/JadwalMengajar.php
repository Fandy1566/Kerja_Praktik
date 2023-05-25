<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMengajar extends Model
{
    use HasFactory;

    protected $table = "jadwal_mengajar";

    public function hari()
    {
        return $this->belongsTo(Hari::class, 'id_hari', 'id');

    }
}
