<?php

namespace App\Http\Controllers;

use App\Models\GuruDetail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\JadwalMengajar;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $guru = User::all();
        $mataPelajaran = MataPelajaran::all()->count();
        $kelas = Kelas::all();
        $jadwalMengajar = JadwalMengajar::all()->count();
        $guruDetail = GuruDetail::all();

        return view('dashboard.home', compact('guru','mataPelajaran','kelas','jadwalMengajar','guruDetail'));
    }
}
