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
            "PAI",
            "PPKn",
            "Bhs. Indonesia",
            "Bhs. Inggris",
            "Matematika",
            "IPA Terpadu",
            "IPS Terpadu",
            "SBK",
            "PJOK",
            "Prakarya"
        ];
        // $tingkat = ["7","8","9"];

        foreach ($mapel as $mapel) {
            DB::table('mata_pelajaran')->insert([
                'nama_mata_pelajaran' => $mapel,
            ]);

        }
    }
}
