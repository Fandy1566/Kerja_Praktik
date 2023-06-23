<?php

namespace Database\Seeders;

use App\Models\User;
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
            "Anitawati, S.Pd",
            "Sri Madacrni, S.Pd.",
            "Wulandari, S.Pd",
            "Asih Frakensi, M.Pd",
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
            "Amalia Amini, S.Pd",
            "Drs. Joko Wahyono",
            "Husni Roaina, S.Pd",
            "Sri Dewi Sartika Sari, ST",
            "Rama Hardiansyah, S.Pd",
            "Elfa Yuliana, S.Ag"
        ];

        foreach ($nama_guru as $i =>$nama) {
            DB::table('users')->insert([
                'name' => $nama,
                'email' => "guru".($i+1)."@smpn23.com",
                // 'password' => str_replace(",", "", explode(" ", $nama)[0]),
                'password' => bcrypt("1234567890"),
                'role' => 3,
            ]);
        }
        
        $user = User::find(2);
        $user->role = 2;
        $user->save();

        $user = User::find(3);
        $user->role = 2;
        $user->save();

        $user = User::find(4);
        $user->role = 2;
        $user->save();

        $user = User::find(1);
        $user->role = 1;
        $user->save();
    }
}
