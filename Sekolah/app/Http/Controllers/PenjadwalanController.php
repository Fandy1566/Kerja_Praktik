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
use Session;
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
        $jadwal = Jadwal::where('tahun_awal', $request->tahun_awal)->where('is_gasal', $request->is_gasal)->first();
        try {
            $jadwalDetails = JadwalDetail::with('Guru', 'Kelas', 'Jadwal', 'Jam', 'MataPelajaran', 'Jam.hari')
            ->where('id_jadwal', $jadwal->id)
            ->orderBy('id_jam', 'asc')
            ->orderBy('id_kelas', 'asc')
            ->get();
        } catch (\Exception $e) {
            $jadwalDetails = false;
        }

        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();
        $guru = User::all();
        $hari = Hari::all();
        $penjadwalan = Jadwal::orderBy('tahun_awal', 'asc')->get();

        return response()->view('dashboard.penjadwalan.index', compact('kelas','jadwalMengajar','hari','guru','jadwalDetails','penjadwalan','mataPelajaran'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $guru = User::where('role', '!=', 6)->get();
        $jadwalMengajar = JadwalMengajar::all();
        $mataPelajaran = MataPelajaran::all();
        return view('dashboard.penjadwalan.create', compact('kelas','guru','jadwalMengajar','mataPelajaran'));
    }

    function edit(Request $request, $id) {
        $jadwal = Jadwal::find($id);
        $jadwalDetails = JadwalDetail::with('Guru','Kelas','Jadwal','Jam','MataPelajaran','Jam.hari')->where('id_jadwal', $jadwal->id ?? 0)
        ->orderBy('id_jam', 'asc')
        ->orderBy('id_kelas', 'asc')
        ->get();
        $kelas = Kelas::all();
        $guru = User::where('role', '!=', 6)->get();
        $jadwalMengajar = JadwalMengajar::all();
        $mataPelajaran = MataPelajaran::all();
        return view('dashboard.penjadwalan.edit', compact('kelas','guru','jadwalMengajar','mataPelajaran','jadwalDetails'));
    }

    public function show(Request $request)
    {
        $jadwalMengajar = JadwalMengajar::all();
        $jadwal = Jadwal::where('tahun_awal', $request->tahun_awal)->where('is_gasal', $request->is_gasal)->first();
        try {
            $jadwalDetails = JadwalDetail::with('Guru', 'Kelas', 'Jadwal', 'Jam', 'MataPelajaran', 'Jam.hari')
            ->where('id_jadwal', $jadwal->id)
            ->orderBy('id_jam', 'asc')
            ->orderBy('id_kelas', 'asc')
            ->get();
        } catch (\Exception $e) {
            $jadwalDetails = false;
        }
        $kelas = Kelas::all();
        $guru = User::all();
        $penjadwalan = Jadwal::orderBy('tahun_awal', 'asc')->get();

        return response()->view('dashboard.penjadwalan.show', compact('kelas','jadwalMengajar','guru','jadwalDetails','penjadwalan'));
    }

    public function showKelas(Request $request)
    {
        $jadwalMengajar = JadwalMengajar::all();
        $jadwal = Jadwal::where('tahun_awal', $request->tahun_awal)->where('is_gasal', $request->is_gasal)->first();

        
        try {
            $jadwalDetails = JadwalDetail::with('Guru', 'Kelas', 'Jadwal', 'Jam', 'MataPelajaran', 'Jam.hari')
            ->where('id_jadwal', $jadwal->id)
            ->orderBy('id_jam', 'asc')
            ->orderBy('id_kelas', 'asc')
            ->get();
        } catch (\Exception $e) {
            $jadwalDetails = false;
        }

        $kelas = Kelas::all();
        $guru = User::all();
        $penjadwalan = Jadwal::orderBy('tahun_awal', 'asc')->get();

        return response()->view('dashboard.penjadwalan.show_kelas', compact('kelas','jadwalMengajar','guru','jadwalDetails','penjadwalan'));
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->delete();

        Session::flash('message', 'Data Berhasil dihapus!'); 

        return redirect()->back();
    }

    public function validasi($id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->is_validated = 1;
        $jadwal->save();

        Session::flash('message', 'Data Berhasil divalidasi!'); 

        return redirect()->back();
    }

    public function print($id)
    {
        $jadwalDetails = JadwalDetail::with('Guru','Kelas','Jadwal','Jam','MataPelajaran','Jam.hari')->where('id_jadwal', $id)
            ->orderBy('id_jam', 'asc')
            ->orderBy('id_kelas', 'asc')
            ->get();
        return view('dashboard.penjadwalan.print', compact('jadwalDetails'));
    }

    public function printKelas($id)
    {
        $jadwalDetails = JadwalDetail::with('Guru','Kelas','Jadwal','Jam','MataPelajaran','Jam.hari')->where('id_jadwal', $id)
            ->orderBy('id_jam', 'asc')
            ->orderBy('id_kelas', 'asc')
            ->get();
        return view('dashboard.penjadwalan.print_kelas', compact('jadwalDetails'));
    }
}
