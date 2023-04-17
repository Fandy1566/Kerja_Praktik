<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $totalGuru = 40;
    protected $totalSubject = 25;

    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < $this->totalGuru; $i++) {
            DB::table('guru')->insert([
                'kode_guru' => "G". str_pad($i+1, 3, 0, STR_PAD_LEFT),
                'nama_guru' => $faker->name,
                // 'gender_guru' => $faker->randomElement(['L','P','?']),
                // 'no_telp_guru' => $faker->phoneNumber,
                // 'alamat_guru' => $faker->address,
                'is_active_guru' => 1
            ]);
        }

        for ($i = 0; $i < $this->totalSubject; $i++) {
            DB::table('mata_pelajaran')->insert([
                'kode_mata_pelajaran' => "M". str_pad($i+1, 3, 0, STR_PAD_LEFT),
                'nama_mata_pelajaran' => $faker->sentence($nbWords = 3, $variableNbWords = true)
            ]);
        }

        for ($i=0; $i < 30; $i++) { 
            DB::table('ruang')->insert([
                'kode_ruang' => "R". str_pad($i+1, 3, 0, STR_PAD_LEFT),
                'nama_ruang' => 'Ruang '.$i
            ]);
        }
    }
}
