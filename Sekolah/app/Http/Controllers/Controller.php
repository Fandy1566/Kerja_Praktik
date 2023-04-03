<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /* 
        data for sidebar menu
        ["name","image"]
    */
    
    protected $data = [
        ["Guru",""],
        ["Siswa", ""],
        ["Mata Pelajaran",""],
        ["Jam Mengajar",""],
        ["User",""]
    ];
}
