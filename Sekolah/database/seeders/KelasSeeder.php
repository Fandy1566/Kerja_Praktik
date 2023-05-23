<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total_per_tingkat = [8,8,7];

        foreach ($total_per_tingkat as $idx => $jumlah_kelas) {
            switch ($idx) {
                case 0:
                    $tingkat = 7;
                    $nama = "VII.";
                    break;
                case 1:
                    $tingkat = 8;
                    $nama = "VIII.";
                    break;
                case 2:
                    $tingkat = 9;
                    $nama = "IX.";
                    break;
                
                default:
                    $tingkat = 7;
                    $nama = "VII.";
                    break;
            }
            for ($i=0; $i < $jumlah_kelas; $i++) { 
                DB::table('kelas')->insert([
                    'nama_kelas' => $nama.($i+1),
                    'tingkat' => str($tingkat),
                ]);
            }
        }

        //
    }
}
