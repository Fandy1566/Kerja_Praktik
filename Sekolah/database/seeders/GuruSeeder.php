<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nama_guru =[
            "Jani Suspandi, S.Pd.I.",
            "Rama Hardiansyah, S.Pd",
            "Elfa Yuliana, S.Ag",
            "Asih Frakensi, M.Pd",
            "Sri Madarni, S.Pd.",
            "Safiq Farisi Sayoga, S.Pd.",
            "Eulis Kurniati, S.Pd",
            "Hj. Dewi Muryani, S.Pd",
            "Andiyati",
            "Helga Amanda, S.Pd",
            "Weni Agustin, S.Pd",
            "Karina Balqis, M.Pd",
            "Maryati, S.Pd",
            "Hj. Nelyati, S.Pd",
            "M. Arif, S.Pd",
            "Erniwati, A.Md",
            "Hj. Yarnani, S.Pd",
            "Rahyuni, S.Pd",
            "Kartini, S.Pd",
            "Nadia Arisma, S.Pd",
            "Renawati, M.Pd",
            "Masniza, S.Pd",
            "Bun Yana, S.Pd",
            "Sriyati, S.Pd",
            "Chika Pramudya Putri, S.Pd",
            "Lista Oktaria Dwi P., S.Pd",
            "Amriyani, S.Pd",
            "Desna Puspitasari, S.Pd",
            "Celsi Cecilia, S.Pd",
            "Dewi Astuti, S.Pd",
            "Suharna, S.Pd",
            "Doni Daruri, S.Pd.",
            "Hafiiz Artama, S.Pd.",
            "Sri Hartanti, A.Ma",
            "Chandra Wijaya, S.Pd",
            "Anitawati, S.Pd",
            "Amalia Amini, S.Pd",
            "Drs. Joko Wahyono",
            "Husni Roaina, S.Pd",
            "Sri Dewi Sartika Sari, ST"
        ];

        foreach ($nama_guru as $nama) {
            DB::table('guru')->insert([
                'nama_guru' => $nama,
                'is_guru_tetap' => 1,
            ]);
        }
    }
}
