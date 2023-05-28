<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDetail extends Model
{
    use HasFactory;

    protected $table = "jadwal_detail";

    public function Guru()
    {
        return $this->belongsTo(User::class, 'id_guru', 'id');
    }
    public function MataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran', 'id');
    }
    public function Kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
    public function Jam()
    {
        return $this->belongsTo(JadwalMengajar::class, 'id_jam', 'id');
    }
}
