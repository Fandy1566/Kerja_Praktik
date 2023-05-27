<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JadwalMengajar;
use App\Models\MataPelajaran;
use App\Models\Kelas;

class PenjadwalanController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $guru = User::all();
        $jadwalMengajar = JadwalMengajar::all();
        $mataPelajaran = MataPelajaran::all();
        return view('dashboard.penjadwalan.index', compact('kelas','guru','jadwalMengajar','mataPelajaran'));
    }
}
