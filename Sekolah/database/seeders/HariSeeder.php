<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class HariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_hari = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
        for ($i=0; $i < count($list_hari); $i++) { 
            DB::table('hari')->insert([
                'kode_hari' => "H". str_pad($i+1, 3, 0, STR_PAD_LEFT),
                'nama_hari' => $list_hari[$i]
            ]);
        }

    }
}
