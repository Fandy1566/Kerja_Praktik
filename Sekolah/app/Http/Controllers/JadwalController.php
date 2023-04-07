<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function __construct()
    {
        // $this->model = new Guru;
        // $this->table = $this->model->table;
        $this->loc = 'dashboard.jadwal.';
    }

    public function index()
    {
        // $collection = get_class($this->model)::all();
        return view($this->loc.'index');
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function store(Request $request)
    {
        $model = $this->model;
        $model->nama_guru = $request->nama_guru;
        $model->gender_guru = $request->gender_guru;
        $model->no_telp_guru = $request->no_telp_guru;
        $model->alamat_guru = $request->alamat_guru;
        $model->is_active_guru = 1;

        $model->save();
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
        $update = get_class($this->model)::find($id);
        $update->nama_guru = $request->nama_guru;
        $update->gender_guru = $request->gender_guru;
        $update->no_telp_guru = $request->no_telp_guru;
        $update->alamat_guru = $request->alamat_guru;
        $update->is_active_guru = $request->is_active_guru;
        $update->save();
        // $request->session()->flash("info", "Data baru berhasil ditambahkan");
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $destroy = get_class($this->model)::find($id);
        $destroy->delete();

        // $request->session()->flash("info", "Data produk berhasil dihapus!");
        return redirect()->back();
    }
}
