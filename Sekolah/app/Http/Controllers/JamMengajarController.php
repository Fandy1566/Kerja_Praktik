<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JamMengajar;

class JamMengajarController extends Controller
{
    public function __construct()
    {
        $this->loc = 'dashboard.jam_mengajar.';
    }

    public function index()
    {
        $collection = JamMengajar::all();
        return view($this->loc.'index', compact('collection'));
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function store(Request $request)
    {
        $store = new JamMengajar;
        $store->waktu_awal_jam_mengajar = $request->waktu_awal;
        $store->waktu_akhir_jam_mengajar = $request->waktu_akhir;
        $store->save();
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
        $update = JamMengajar::find($id);
        $update->waktu_awal_jam_mengajar = $request->waktu_awal;
        $update->waktu_akhir_jam_mengajar = $request->waktu_akhir;
        $update->save();
        // $request->session()->flash("info", "Data baru berhasil ditambahkan");
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $destroy = JamMengajar::find($id);
        $destroy->delete();

        // $request->session()->flash("info", "Data produk berhasil dihapus!");
        return redirect()->back();
    }
}
