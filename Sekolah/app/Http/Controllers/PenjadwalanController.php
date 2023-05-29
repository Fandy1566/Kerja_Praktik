<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\JadwalDetail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JadwalMengajar;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Hari;
use Illuminate\Support\Facades\Auth;
// use App\Models\JadwalDetail;

class PenjadwalanController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $jadwalMengajar = JadwalMengajar::all();
        $jadwalDetails = JadwalDetail::where('id_jadwal', $request->id)
            ->orderBy('id_jam', 'asc')
            ->orderBy('id_kelas', 'asc')
            ->get();
        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();
        $guru = User::all();
        $hari = Hari::all();
        $penjadwalan = Jadwal::all();
        return response()->view('dashboard.penjadwalan.index', compact('kelas','jadwalMengajar','hari','guru','jadwalDetails','penjadwalan','mataPelajaran'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $guru = User::all();
        $jadwalMengajar = JadwalMengajar::all();
        $mataPelajaran = MataPelajaran::all();
        return view('dashboard.penjadwalan.create', compact('kelas','guru','jadwalMengajar','mataPelajaran'));
    }
}
