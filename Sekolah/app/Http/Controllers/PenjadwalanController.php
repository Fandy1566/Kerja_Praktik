<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JadwalMengajar;
use App\Models\MataPelajaran;
use App\Models\Kelas;
// use App\Models\JadwalDetail;

class PenjadwalanController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index()
    {
        $penjadwalan = Jadwal::all();
        return view('dashboard.penjadwalan.index', compact('penjadwalan'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $guru = User::all();
        $jadwalMengajar = JadwalMengajar::all();
        $mataPelajaran = MataPelajaran::all();
        return view('dashboard.penjadwalan.index', compact('kelas','guru','jadwalMengajar','mataPelajaran'));
    }
}
