<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->loc = 'dashboard.kelas.';
    }

    public function index()
    {
        $collection = Kelas::all();
        return view($this->loc.'index', compact('collection'));
    }

    public function create()
    {
        return view($this->loc.'create');
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        return view($this->loc.'edit');
    }
}
