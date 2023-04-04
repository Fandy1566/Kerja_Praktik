<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    protected $loc;

    public function __construct()
    {
        $this->name = new Guru;
        $this->table = $this->name->getTable();
        $this->loc = 'dashboard.guru.';
    }

    public function index()
    {
        return view($this->loc.'index');
    }

    public function create()
    {
        return view($this->loc.'create', ['data' => $this->data, 'tableColumns' => $this->tableColumns]);
    }

    public function store(Request $request)
    {
        $increment = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='" . env('DB_DATABASE') . "' AND TABLE_NAME ='" . $table . "'")[0]->AUTO_INCREMENT;
        $this->name->{$this->tableColumns[0]} = strtoupper(substr($table, 0, 1))."-".str_pad($increment,6,"0",STR_PAD_LEFT);
        for ($i=1; $i < count($this->tableColumns); $i++) { 
            $this->name->{$this->tableColumns[$i]} = $request->{str_replace('_'.strtolower($table),'',$this->tableColumns[$i])};
        }
        $this->name->save();
        // $request->session()->flash("info", "Data baru berhasil ditambahkan");
        return redirect()->route($this->loc.'index');
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        return view($this->loc.'create', ['data' => $this->data, 'tableColumns' => $this->tableColumns]);
    }

    public function update(Request $request, string $id)
    {
        $update = str_replace('_', '', ucwords($this->table))::find($id);
        for ($i=1; $i < count($this->tableColumns); $i++) {
            if ($request->has($this->tableColumns[$i])) {
                $update->{$this->tableColumns[$i]} = $request->{str_replace('_'.strtolower($table),'',$this->tableColumns[$i])};
            }  
        }
        $update->save();
        // $request->session()->flash("info", "Data baru berhasil ditambahkan");
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $destroy = str_replace('_', '', ucwords($this->table))::find($id);
        $destroy->delete();

        // $request->session()->flash("info", "Data produk berhasil dihapus!");
        return redirect()->back();
    }
}
