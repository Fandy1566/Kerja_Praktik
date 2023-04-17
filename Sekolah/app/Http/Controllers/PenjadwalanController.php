<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\Guru;
use DB;

class PenjadwalanController extends Controller
{
    protected $guru, $mataPelajaran, $nind, $pop_size, $Pc, $Pm, $ngener, $ngenes;
    public function __construct()
    {
        $this->guru = Guru::all();
        $this->mataPelajaran = MataPelajaran::all();
        $this->nind = DB::table('jadwal_mengajar')->count();
        $this->pop_size = 20;
        $this->Pc=0.75;  // kemungkinan crossover (usahakan pc ni nilainy besak) pc dk boleh kurang dr 0.1
        $this->Pm=0.5;   // kemungkinan mutasi (nilainy kecik)
        $this->ngener=1000; //generasi
        $this->ngenes= (DB::table('kelas')->count())-1; //jumlah genes dalam chromosome
    }

    public function index()
    {
        return view('dashboard.penjadwalan.index');
    }

    public function main()
    {
        for ($i=0; $i < $this->ngener; $i++) { 
            if ($i > 0) {
                $population = $newPopulation;
            } else {
                $population = $this->create_population();
            }
            $fitnesses = $this->fitness_evaluation($population);
            $newIndividual = $this->selection($fitnesses, $population);
            $crossover = $this->crossover($newIndividual);
            $mutation = $this->mutate($crossover);
            $newPopulation = $this->generate_new_population($population, $mutation);
        }
    }

    /*
    digunakan untuk membuat chromosome
    bentuknya sebagai berikut:
    [G01,M01][G02,M02][G03,M03][G04,M01]
    */
    public function create_chromosome()
    {
        $chromosome = [];
        $guru = DB::table('guru')->pluck('kode_guru')->inRandomOrder()->get();
        for ($i=0; $i < $this->ngenes; $i++) { 
            // $id = DB::table('guru')->where('kode_guru', $guru[$i])->value('id');
            $chromosome[] = $guru[$i];
        }
        return $chromosome;
    }

    /*
    digunakan untuk membuat individu
    individu adalah gabungan dari chromosome
    */
    public function create_individual()
    {
        return array_fill(0, $this->nind, $this->create_chromosome());
    }

    /*
    digunakan untuk membuat populasi
    populasi adalah gabungan dari individu
    */
    public function create_population()
    {
        return array_fill(0, $this->pop_size, $this->create_individual());
    }

    public function fitness_evaluation(array $population)
    {
        $population_fitnesses = [];
        for ($i=0; $i < $this->pop_size; $i++) {
            $total_penalty = 0;
            $individual_fitnesses = [];
            //melakukan perbandingan perchromosome
            for ($i=0; $i < $this->nind; $i++) { 
                $chromosome = $population[$i];
                $fitness = [];
                $penalty = 0;
                for ($j=0; $j < $this->nind; $j++) {
                    $jumlah = 1; // utk menghitung jumlah mk
                    if ($i !== $j) {
                        $chromosome2 = $population[$j];
                        //cek guru sama pada jam yang sama
                        if ($chromosome[0] == $chromosome2[0]) {
                            $penalty += 1;
                        }
                        //kalau jam tidak mau bersebelahan cek idx jam ny +1
                    }
                }
                $fitnesses[] = 1/(1+$penalty);
                $total_penalty += $penalty;
            }
            $individual_fitnesses[] = $fitnesses;
            $population_fitnesses[] = array_sum($fitnesses)/count($fitnesses);
        }
        return $population_fitnesses;
    }

    public function selection(array $fitnesses, array $population)
    {
        $probability = [];
        //menghitung probabilitas
        foreach ($fitnesses as $f_score) { 
            $probability[] = $f_score/array_sum($fitnesses);
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
        $newIndividual =[];
        for ($i = 0; $i < count($fitnesses); $i++) {
            $rand = mt_rand() / mt_getrandmax();
            for ($j = 0; $j < count($cum_probabilities); $j++) {
                if ($rand <= $cum_probabilities[$j]) {
                    $newIndividual[] = $population[$j];
                    break;
                }
            }
        }
        return $newIndividual;
    }
    public function crossover(array $newIndividual)
    {
        $idx = [];
        //mengambil index dari kromosom
        for ($i=0; $i <count($newIndividual) ; $i++) { 
            $rand = mt_rand() / mt_getrandmax();
            if ($rand <= $this->Pc) {
                $idx[] = $i;
            }
        }

        //crossover antar chromosome di dalam individu
        $temp = $newIndividual[0];
        $crossover_point = mt_rand(0, $this->ngenes-1);
        for ($i=$crossover_point; $i < $this->ngenes; $i++) { 
            for ($j=0; $j <count($idx) ; $j++) { 
                if ($j < count($idx)-1) {
                    $newIndividual[$idx[$j]][$i] = $newIndividual[$idx[$j+1]][$i];
                } else {
                    $newIndividual[$idx[$j]][$i] = $temp;
                }
            }
        }
        return $newIndividual;
    }
    public function mutation(array $newIndividual)
    {
        // $mutate = [];
        // $idx = [];
        for ($i=0; $i < $this->nind; $i++) {
            // $row = [];
            for ($j=0; $j < $this->ngenes; $j++) {
                // $row[] = mt_rand() / mt_getrandmax();
                $rand = mt_rand() / mt_getrandmax();
                if ($rand <= $this->Pm) {
                    // $idx[] = [$i,$j];
                    $newIndividual[$i][$j] = DB::table('guru')->whereNotIn('kode_guru', $newIndividual[$i][$j])->inRandomOrder()->value('kode_guru')[0];
                }
            }
            // $mutate[] = $row;
        }

        // for ($j=0; $j <count($idx) ; $j++) { 
        //     $newIndividual[$idx[0]][$idx[1]] = DB::table('guru')->whereNotIn('kode_guru', $newIndividual[$idx[0]][$idx[1]])->inRandomOrder()->value('kode_guru')[0];
        // }
        return $newIndividual;
    }
    public function generate_new_population(array $population, array $newIndividual)
    {
        $combined_individual = array_unique($population + $newIndividual);

        $fitness = $this->fitness_evaluation($combined_individual);

        sort($fitness);

        $newPopulation = [];
        $arrlength = count($fitness);
        for($i = $arrlength; $i >= $arrlength-$this->nind; $i--) {
            $newPopulation[] = $combined_individual[array_search($fitness[$i], $fitness)];
        }
        return $newPopulation;
    }
}
