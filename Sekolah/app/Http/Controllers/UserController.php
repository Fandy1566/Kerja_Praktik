<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->loc = 'dashboard.jam_mengajar.';
    }

    public function index()
    {
        $collection = User::all();
        return view($this->loc.'index', compact('collection'));
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function store(Request $request)
    {
        $store = new User;

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
        $update = User::find($id);
        
        $update->save();
        // $request->session()->flash("info", "Data baru berhasil ditambahkan");
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $destroy = User::find($id);
        $destroy->delete();

        // $request->session()->flash("info", "Data produk berhasil dihapus!");
        return redirect()->back();
    }
}
