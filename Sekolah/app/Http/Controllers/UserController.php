<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->model = new User;
        $this->table = $this->model->table;
        $this->loc = 'dashboard.jam_mengajar.';
    }

    public function index()
    {
        $collection = get_class($this->model)::all();
        return view($this->loc.'index', compact('collection'));
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function store(Request $request)
    {
        $model = $this->model;
        $waktu_mengajar = $request->waktu_awal." - ".$request->waktu_akhir;
        $model->waktu_jam_mengajar = $waktu_mengajar;
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
        $update->waktu_mengajar = $request->waktu_mengajar;
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
