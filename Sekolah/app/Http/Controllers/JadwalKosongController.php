<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKosong;

class JadwalKosongController extends Controller
{
    public function index()
    {
        $collection = JadwalKosong::all();
        return view($this->loc.'index', compact('collection'));
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function store(Request $request)
    {
        $store = new JadwalKosong;
        $store->nama_guru = $request->nama_guru;
        // $store->gender_guru = $request->gender_guru;
        // $store->no_telp_guru = $request->no_telp_guru;
        // $store->alamat_guru = $request->alamat_guru;
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
        $update = JadwalKosong::find($id);
        $update->nama_guru = $request->nama_guru;
        // $update->gender_guru = $request->gender_guru;
        // $update->no_telp_guru = $request->no_telp_guru;
        // $update->alamat_guru = $request->alamat_guru;
        $update->is_active_guru = $request->is_active_guru;
        $update->save();
        // $request->session()->flash("info", "Data baru berhasil ditambahkan");
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $destroy = JadwalKosong::find($id);
        $destroy->delete();

        // $request->session()->flash("info", "Data produk berhasil dihapus!");
        return redirect()->back();
    }
}
