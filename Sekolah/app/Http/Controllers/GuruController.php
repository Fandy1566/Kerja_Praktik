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

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        return view($this->loc.'edit');
    }
}
