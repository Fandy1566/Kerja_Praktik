<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function __construct()
    {
        $this->loc = 'dashboard.mata_pelajaran.';
    }

    public function index()
    {
        $collection = MataPelajaran::all();
        return view($this->loc.'index', compact('collection'));
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function store(Request $request)
    {
        $store = new MataPelajaran;
        $store->kode_mata_pelajaran = $request->kode_mata_pelajaran;
        $store->nama_mata_pelajaran = $request->nama_mata_pelajaran;
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
        $update = MataPelajaran::find($id);
        $update->kode_mata_pelajaran = $request->kode_mata_pelajaran;
        $update->nama_mata_pelajaran = $request->nama_mata_pelajaran;
        $update->save();
        // $request->session()->flash("info", "Data baru berhasil ditambahkan");
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $destroy = MataPelajaran::find($id);
        $destroy->delete();

        // $request->session()->flash("info", "Data produk berhasil dihapus!");
        return redirect()->back();
    }
}
