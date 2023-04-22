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
        set_time_limit(0);
        $this->guru = Guru::all();
        $this->mataPelajaran = MataPelajaran::all();
        // $this->nind = DB::table('jadwal_mengajar')->count();
        $this->nind = 37;
        $this->pop_size = 20;
        $this->Pc=0.9;  // kemungkinan crossover (usahakan pc ni nilainy besak) pc dk boleh kurang dr 0.1
        $this->Pm=0.5;   // kemungkinan mutasi (nilainy kecik)
        $this->ngener=300; //generasi
        $this->ngenes= (DB::table('kelas')->count()); //jumlah genes dalam chromosome
    }

    public function index()
    {
        $penjadwalan = $this->main();
        dd($penjadwalan);
        return view('dashboard.penjadwalan.index', compact('penjadwalan'));
    }

    public function main()
    {
        $population = $this->create_population();
        // for ($i=0; $i < $this->pop_size; $i++) { 
        //     for ($j=0; $j < $this->nind; $j++) { 
        //         for ($k=0; $k < $this->ngenes; $k++) { 
        //             print_r($population[$i][$j][$k]);
        //         }
        //         echo "<br/>";
        //     }
        //     echo "<br/>";

        // }
        for ($i=0; $i < $this->ngener; $i++) { 
            if ($i > 0) {
                // echo "Generasi - ".$i."<br/>";
                $population = $newPopulation[0];
            }
            $fitnesses = $this->fitness_evaluation($population);
            // foreach ($fitnesses as $key => $value) {
            //     echo $value."<br/>";
            // }
            // if ($i > 0) {
            //     dd($fitnesses);
            // }
            $newIndividual = $this->selection($fitnesses, $population);
            $crossover = $this->crossover($newIndividual);
            $mutation = $this->mutation($crossover);
            $newPopulation = $this->generate_new_population($population, $mutation);
            
        }
        return $newPopulation;
    }

    /*
    digunakan untuk membuat chromosome
    bentuknya sebagai berikut:
    [G01,M01][G02,M02][G03,M03][G04,M01]
    */
    public function create_chromosome()
    {
        $chromosome = [];
        $guru = DB::select("select distinct kode_guru from guru order by RAND()");
        // $guru = DB::table('guru')->pluck('kode_guru')->inRandomOrder()->get();
        for ($i=0; $i < $this->ngenes; $i++) { 
            // $id = DB::table('guru')->where('kode_guru', $guru[$i])->value('id');
            $chromosome[] = DB::select('SELECT kode_guru FROM guru ORDER BY RAND() LIMIT 1')[0]->kode_guru;
        }
        // for ($i=0; $i < $this->ngenes; $i++) { 
        //     // $id = DB::table('guru')->where('kode_guru', $guru[$i])->value('id');
        //     $chromosome[] = $guru[$i]->kode_guru;
        // }
        return $chromosome;
    }

    /*
    digunakan untuk membuat individu
    individu adalah gabungan dari chromosome
    */
    public function create_individual()
    {
        for ($i=0; $i < $this->nind; $i++) { 
            $individual[] = $this->create_chromosome();
        }
        return $individual;
    }

    /*
    digunakan untuk membuat populasi
    populasi adalah gabungan dari individu
    */
    public function create_population()
    {
        for ($i=0; $i < $this->pop_size; $i++) { 
            $population[] = $this->create_individual();
        }
        return $population;
    }

    public function fitness_evaluation(array $population)
    {
        $individual = [];
        $chromosome = [];
        $fitnesses_individual = [];
        $fitnesses_population = [];
        for ($i = 0; $i < count($population); $i++) {
            $individual = $population[$i];
            $fitnesses_chromosome = [];
            for ($j = 0; $j < count($individual); $j++) {
                $chromosome = $individual[$j];
                $penalty = 0;
        
                for ($k = 0; $k < count($chromosome); $k++) {
                    for ($l = $k + 1; $l < count($chromosome); $l++) {
                        
                        //genes
                        if ($k !== $l) {
                            // dd($k,$l,[$chromosome[$k], $chromosome[$l]], $chromosome);
                            if ($chromosome[$k] == $chromosome[$l]) {
                                $penalty += 1;
                            }
                        }
                    }
                }
                $fitnesses_chromosome[] = 1 / (1 + $penalty);
            }
            $fitnesses_individual[] = array_sum($fitnesses_chromosome) / count($fitnesses_chromosome);
            // dd($chromosome, $penalty, $fitnesses_individual);
        }
        $fitnesses_population = $fitnesses_individual ;
        return $fitnesses_population;
        
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
        for ($i=0; $i < $this->pop_size ; $i++) {
            for ($j=0; $j < $this->nind; $j++) { 
                $rand = mt_rand() / mt_getrandmax();
                if ($rand <= $this->Pc) {
                    $idx[] = [$i,$j];
                }
            }
        }

        //crossover antar chromosome di dalam individu
        $temp = $newIndividual[0][0][0];
        $crossover_point = mt_rand(0, $this->ngenes-1);
        for ($i=$crossover_point; $i < $this->ngenes; $i++) { 
            for ($j=0; $j <count($idx) ; $j++) { 
                if ($j < count($idx)-1) {
                    $newIndividual[$idx[$j][0]][$idx[$j][1]][$i] = $newIndividual[$idx[$j+1][0]][$idx[$j+1][1]][$i];
                } else {
                    $newIndividual[$idx[$j][0]][$idx[$j][1]][$i] = $temp;
                }
            }
        }
        return $newIndividual;
    }
    public function mutation(array $newIndividual)
    {
        try {

            
            // $mutate = [];
            // $idx = [];
            for ($k=0; $k < $this->pop_size; $k++) { 
                for ($i=0; $i < $this->nind; $i++) {
                    // $row = [];
                    //uniform mutation
                    try {
                        $rand = mt_rand() / mt_getrandmax();
                        if ($rand <= $this->Pm) {
                            $unique = array_unique($newIndividual[$k][$i]);
                            foreach ($unique as $key => $val) {
                                if (!array_key_exists($key,$unique)) unset($array2[$key]);
                            }
                            //get non unique keys index
                            $array_non_unique_index = array_keys(array_diff_key($newIndividual[$k][$i],$unique));
                            for ($j=0; $j < count($array_non_unique_index); $j++) {
                                $newIndividualValueQuery = implode(',', array_map(function ($value) {
                                    return "'" . $value . "'";
                                }, $newIndividual[$k][$i]));
                                $newIndividual[$k][$i][$array_non_unique_index[$j]] = DB::select("SELECT kode_guru FROM guru WHERE kode_guru NOT IN (?) ORDER BY RAND() LIMIT 1", [$newIndividualValueQuery])[0]->kode_guru;
                            }
                        }
                    } catch (\Exception $e) {
                        dd($unique, $array_non_unique_index, $newIndividual[$k][$i]);

                    }
                }
            }
        } catch (\Exception $e) {
            dd([$k,$this->pop_size],[$i,$this->nind],[$j,$this->ngenes], $newIndividual[$k][$i][$j]);
        }
        return $newIndividual;
    }
    public function generate_new_population(array $population, array $newIndividual)
    {
        try {
            $combined_individual = array_merge($population, $newIndividual);
            $fitness = $this->fitness_evaluation($combined_individual);
            $keys = array_keys($fitness);
            array_multisort($fitness, SORT_DESC, $keys);
            // print_r($keys);
            // dd($fitness, $keys);
            $newPopulation = [];
            $arrlength = count($fitness);
            for ($i=0; $i < $this->pop_size; $i++) { 
                $newPopulation[] = $combined_individual[$keys[$i]];
            }
            // dd($newPopulation);
            return [$newPopulation,array_slice($fitness, 0 , count($newPopulation))];
        } catch (\Exception $e) {
            dd($arrlength, $combined_individual, $i);
        }
        
    }
}
