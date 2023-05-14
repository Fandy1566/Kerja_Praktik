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
        $list_hari = ["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"];
        for ($i=0; $i < count($list_hari); $i++) { 
            DB::table('hari')->insert([
                'nama_hari' => $list_hari[$i]
            ]);
        }

    }
}
