<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use DB;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->loc = 'dashboard.guru.';
    }

    public function index()
    {
        $collection = Guru::all();
        return view($this->loc.'index', compact('collection'));
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function store(Request $request)
    {

        $store = new Guru;
        $store->kode_guru = $request->nama_guru;
        $store->nama_guru = $request->nama_guru;
        // $store->gender_guru = $request->gender_guru;
        // $store->no_telp_guru = $request->no_telp_guru;
        // $store->alamat_guru = $request->alamat_guru;
        $store->is_active_guru = 1;
        $store->save();
        $request->session()->flash("info", "Data baru berhasil ditambahkan");
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
        $update = Guru::find($id);
        $update->nama_guru = $request->nama_guru;
        $update->is_active_guru = $request->is_active_guru;
        $update->save();
        $request->session()->flash("info", "Data baru berhasil diubah");
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $destroy = Guru::find($id);
        $destroy->delete();
        return redirect()->back();
    }
}
