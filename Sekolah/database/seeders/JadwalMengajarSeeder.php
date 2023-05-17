<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use DateTime;
class JadwalMengajarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_jam_senin = [
            "07.40 - 08.20",
            "08.20 - 09.00",
            "09.00 - 09.40",
            "10.00 - 10.40",
            "10.40 - 11.20",
            "11.20 - 12.00",
            "12.40 - 13.20",
            "13.20 - 14.00"
        ];
        $id_hari = [2,3,4];
        $list_jam = [
            "07.00 - 07.40",
            "07.40 - 08.20",
            "08.20 - 09.00",
            "09.00 - 09.40",
            "10.00 - 10.40",
            "10.40 - 11.20",
            "11.20 - 12.00",
            "12.50 - 13.40",
        ];
        
        foreach ($list_jam_senin as $jam) {
            $times = explode(" - ", $jam);
            $start_time = DateTime::createFromFormat('H.i', $times[0])->format('H:i:s');
            $end_time = DateTime::createFromFormat('H.i', $times[1])->format('H:i:s');

            DB::table('jadwal_mengajar')->insert([
                'id_hari' => 1,
                'waktu_awal' =>  $start_time,
                'waktu_akhir' => $end_time
            ]);
        }
        foreach ($id_hari as $id_hari1) {
            foreach ($list_jam as $jam) {
                $times = explode(" - ", $jam);
                $start_time = DateTime::createFromFormat('H.i', $times[0])->format('H:i:s');
                $end_time = DateTime::createFromFormat('H.i', $times[1])->format('H:i:s');
    
                DB::table('jadwal_mengajar')->insert([
                    'id_hari' => $id_hari1,
                    'waktu_awal' => $start_time,
                    'waktu_akhir' => $end_time
                ]);
            }
        }

        for ($i=0; $i < 6; $i++) { 
            $times = explode(" - ", $list_jam[$i]);
            $start_time = DateTime::createFromFormat('H.i', $times[0])->format('H:i:s');
            $end_time = DateTime::createFromFormat('H.i', $times[1])->format('H:i:s');

            DB::table('jadwal_mengajar')->insert([
                'id_hari' => 5,
                'waktu_awal' => $start_time,
                'waktu_akhir' => $end_time
            ]);
        }
    }
}
