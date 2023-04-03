<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    protected $name, $table, $loc;

    public function __construct()
    {
        $this->name = new Guru;
        $this->table = $this->name->getTable();
        $this->loc = 'dashboard.guru.';
    }

    public function index()
    {
        $tableColumns = $this->getTableColumns($this->table);
        return view($this->loc.'index', ['data' => $this->data, 'tableColumns' => $tableColumns]);
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
