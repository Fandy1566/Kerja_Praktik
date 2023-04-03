<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    protected $name;
    protected $table;

    public function __construct()
    {
        $this->name = new MataPelajaran;
        $this->table = $this->name->getTable();
    }

    public function index()
    {
        $tableColumns = $this->getTableColumns($this->table);
        return view('dashboard.mata_pelajaran.index', ['data' => $this->data, 'tableColumns' => $tableColumns]);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }
}
