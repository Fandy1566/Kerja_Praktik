<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /* 
        data for sidebar menu
        ["name","image"]
    */
    protected $model, $table, $loc;

    public function getTableColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }
}
