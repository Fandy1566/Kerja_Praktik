<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapel = [
            ["PAI", 3],
            ["PPKn", 3],
            ["Bhs. Indonesia", 6],
            ["Bhs. Inggris", 4],
            ["Matematika", 5],
            ["IPA Terpadu", 5],
            ["IPS Terpadu", 4],
            ["SBK", 3],
            ["PJOK", 3],
            ["Prakarya", 2]
        ];
        // $tingkat = ["7","8","9"];

        foreach ($mapel as $mapel) {
            DB::table('mata_pelajaran')->insert([
                'nama_mata_pelajaran' => $mapel[0],
                'tingkat' => "7",
                'banyak' => $mapel[1]
            ]);

        }
    }
}
