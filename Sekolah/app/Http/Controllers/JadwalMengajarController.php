<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMengajar;

class JadwalMengajarController extends Controller
{
    public function __construct()
    {
        $this->loc = 'dashboard.jadwal_mengajar.';
    }

    public function index()
    {
        $collection = JadwalMengajar::all();
        return view($this->loc.'index', compact('collection'));
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function store(Request $request)
    {
        $jadwalMengajar = new JadwalMengajar;
        $jadwalMengajar->kode_jadwal_mengajar = $request->kode_jadwal_mengajar;
        $jadwalMengajar->id_hari = $request->id_hari;
        $jadwalMengajar->waktu_awal = $request->waktu_awal;
        $jadwalMengajar->waktu_akhir = $request->waktu_akhir;
        $jadwalMengajar->save();
        return redirect()->back();
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        return view($this->loc.'edit');
    }

    public function update(Request $request, string $id)
    {
        $jadwalMengajar = JadwalMengajar::find($id);
        $jadwalMengajar->id_hari = $request->id_hari;
        $jadwalMengajar->waktu_awal = $request->waktu_awal;
        $jadwalMengajar->waktu_akhir = $request->waktu_akhir;
        $jadwalMengajar->save();
        // $request->session()->flash("info", "Data baru berhasil ditambahkan");
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $destroy = JadwalMengajar::find($id);
        $destroy->delete();

        // $request->session()->flash("info", "Data produk berhasil dihapus!");
        return redirect()->back();
    }
}
