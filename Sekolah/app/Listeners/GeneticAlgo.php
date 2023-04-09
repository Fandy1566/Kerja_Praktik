<?php

namespace App\Listeners;

use App\Events\Scheduling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Guru;


class GeneticAlgo
{
       
    /*
    bentuk kromosom adalah
    1. mata pelajaran (M)
    2. guru (G)
    3. ruang (K)
    4. jam pembelajaran (T)
    5. Hari (H)

    dimana 1-5 adalah alelnya sehingga bentuk kromosom adalah <M, G, K, T, H>
    */

    //kasus kelas tetap
    //crossover = T dan H
    //mutation = M

    //pilihan 2
    //crossover = G dan M
    //mutation = G dan M
    //T dan H statis

    // lima array yang diberikan
    protected $kode_matpel = ["M01", "M02", "M03", "M04", "M05", "M06", "M07", "M08", "M09", "M10"]; //0
    protected $kode_guru = ["G01", "G02", "G03", "G04", "G05", "G06", "G07", "G08", "G09", "G10"];//1
    protected $kode_kelas = ["K01", "K02", "K03", "K04", "K05", "K06", "K07", "K08", "K09", "K10"];//2
    protected $kode_jam_pelajaran = ["T01", "T02", "T03", "T04", "T05", "T06"];//3
    protected $kode_hari = ["H01","H02","H03","H04","H05","H06"];//4
    protected $jadwal;
    //jadwal kosong
    //0,0 artinya H01 dan T01
    protected $jadwal_kosong = [[0,0],[5,0]];
    //T02H01
    protected $list_alel, $nind, $Pc, $Pm, $ngener, $population;
    protected $total_conflict;

    public function __construct() {
        $this->jadwal = [];
        for ($i=0; $i < count($this->kode_kelas); $i++) { 
            for ($j=0; $j < count($this->kode_hari); $j++) { 
                for ($k=0; $k < count($this->kode_jam_pelajaran); $k++) { 
                    $is_jadwal_kosong = False;
                    for ($l=0; $l < count($this->jadwal_kosong); $l++) { 
                        if ($j == $this->jadwal_kosong[$l][0] && $k == $this->jadwal_kosong[$l][1]) {
                            $is_jadwal_kosong = True;
                            break;
                        }
                    }
                    if ($is_jadwal_kosong) {
                        continue;
                    }
                    $this->jadwal[] = [$this->kode_kelas[$i],$this->kode_hari[$j],$this->kode_jam_pelajaran[$k]];
                }
            }
        }
        
        $this->list_alel = [$this->kode_matpel, $this->kode_guru]; //panjang gen = 5 -> count($list_alel) + count($jadwal)
        // contoh output : M01 G02 K01 T01 H01

        // panjang kromosome adalah panjang gen
        $this->nind= count($this->jadwal);    // banyak populasi
        $this->Pc=0.75;     // kemungkinan crossover (usahakan pc ni nilainy besak) pc dk boleh kurang dr 0.1
        $this->Pm=0.1;   // kemungkinan mutasi (nilainy kecik)
        $this->ngener=100;  // jumlah generasi(iterasi)
    }

    // fungsi untuk membuat kromosom secara acak
    function generate_chromosome($i) {
        $chromosome = [];
        //looping per alel
        for ($j=0; $j < count($this->list_alel); $j++) {
            $chromosome[] = $this->list_alel[$j][array_rand($this->list_alel[$j])];
        }
        //memasukkan nilai kelas, hari,jam
        for ($j=0; $j < count($this->jadwal[$i]); $j++) {     
            $chromosome[] = $this->jadwal[$i][0];
            $chromosome[] = $this->jadwal[$i][1];
            $chromosome[] = $this->jadwal[$i][2];
        }
        return $chromosome;
    }

    //fungsi untuk membuat populasi
    function generate_population() {
        $population = [];
        //looping per chromosome
        for ($i=0; $i < $this->nind; $i++) { 
            $population[] = $this->generate_chromosome($i);
        }
        return $population;
    }

    // membuat populasi
    public function create_population() {
        $this->population = $this->generate_population();
    }

    // print populasi
    public function print_population() {
        $population = $this->population;
        $output = '';
        for ($i=0; $i < count($population); $i++) { 
            for ($j=0; $j < count($this->list_alel)+count($this->jadwal[0]); $j++) { 
                $output .= $population[$i][$j];
            }
            $output .= "<br />";
        }
        return $output;
    }

    /*
    menghitung jumlah conflict dengan aturan :
    1. Guru atau kelas tidak boleh dijadwalkan lebih dari satu kali di waktu dan hari yang sama
    2. 
    */

    public function calculate_conflict($i) {
        $population = $this->population;
        $conflict = 0;
        $chromosome = $population[$i];
        for ($j=0; $j < count($population); $j++) { 
            //kondisi ketika population[$i] !== population[$j]
            if ($i !== $j) {
                $chromosome2 = $population[$j];
                //kondisi ketika waktu dan hari sama
                if ($chromosome[3] == $chromosome2[3] && $chromosome[4] == $chromosome2[4]) {
                    //aturan 1
                    if ($chromosome[1] == $chromosome2[1] || $chromosome[2] == $chromosome2[2] ) {
                        $conflict += 1;
                        break;
                    }
                    // //guru tidak boleh mengajar di waktu yang sama
                    // if ($chromosome[1] == $chromosome2[1]) {
                    //     $conflict += 1;
                    //     break;
                    // }
                    // //guru tidak boleh dijadwalkan di waktu yang sama
                    // if ($chromosome[2] == $chromosome2[2]) {
                    //     $conflict += 1;
                    // }
                }
            }
        }
        $this->total_conflict += $conflict;
        return $conflict;
    }

    /*
    rumus fitness yang digunakan
    fitness = 1/(1+(conflict_c_1+conflict_c_2+...+conflict_c_n))
    */

    public function fitness_evaluation() {
        $fitness = [];
        for ($i=0; $i < count($this->population); $i++) { 
            $fitness[] = 1/(1+$this->calculate_conflict($i));
        }
        return $fitness;
    }

    //function untuk mengambil total konflik
    public function get_total_conflict() {
        return $this->total_conflict;
    }

    //selection
    public function roulette_wheel(){
        $fitness = $this->fitness_evaluation();
        $probability = [];
        //menghitung probabilitas
        foreach ($fitness as $f_score) { 
            $probability[] = $f_score/array_sum($fitness);
        }

        //utk menyimpan nilai kumulatif
        $cum_probabilities = [];
        //utk 1 pertambahan kumulatif
        $cum_probability = 0;
        //perhitungan nilai probabilitas kumulatif
        foreach ($probability as $value) {
            $cum_probability += $value;
            $cum_probabilities[] = $cum_probability;
        }
        
        $newChrom = [];
        for ($i = 0; $i < count($this->population); $i++) {
            $rand = mt_rand() / mt_getrandmax();
            for ($j = 0; $j < count($cum_probabilities); $j++) {
                if ($rand <= $cum_probabilities[$j]) {
                    $newChrom[] = $this->population[$j];
                    break;
                }
            }
        }
        return $newChrom;
    }

    // crossover (two point crossover)
    public function crossover()
    {
        $newChrom = $this->roulette_wheel();
        $idx = [];
        //mengambil index dari kromosom
        for ($i=0; $i <count($newChrom) ; $i++) { 
            $rand = mt_rand() / mt_getrandmax();
            if ($rand <= $this->Pc) {
                $idx[] = $i;
            }
        }
        //fungsi untuk menukar nilai


    }

    /**
     * Handle the event.
     */
    public function handle(Scheduling $event): void
    {
        //
    }
}
