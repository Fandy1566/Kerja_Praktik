<?php

namespace App\Listeners;

use App\Events\Scheduling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Guru;


class GeneticAlgo
{
    /*
    Penentuan untuk satu kelas (kasus dimana guru hanya mengajar di kelas tertentu)
    gene:
    hari
    jam
    mapel -> guru dan mapel saling terkait
    banyak_mapel_perminggu -> array(mapel, bnyk) <- bnyk = bnyk * jumlah kelas
    guru -> guru dan mapel saling terkait
    kelas
    jam_kosong -> tipe array(hari,jam) <- berguna untuk skip iterasi ketika pembuatan individu

    chromosome:
    [Mapel, Guru],[Mapel, Guru], sebanyak kelas

    individu: (sebanyak hari * jam - banyak jam kosong)
    [Mapel, Guru],[Mapel, Guru], sebanyak kelas
    [Mapel, Guru],[Mapel, Guru], sebanyak kelas
    [Mapel, Guru],[Mapel, Guru], sebanyak kelas
    ...
    
    sebanyak hari dan jam

    ...
    [Mapel, Guru],[Mapel, Guru], sebanyak kelas

    populasi: (sebanyak sampel yang dibutuhkan)

    individu 1
    individu 2
    ...
    individu n

    Hitung fitness
    aturan:
    1. Guru tidak bisa mengajar di kelas yang sama
    2. jumlah mapel tidak bisa lebih dari yang diputuskan
    3. 

    fitness chromosome:
    1/(1+penalty)

    fitness individu:
    1/(1+total_penalty_chromosome)

    Seleksi -> roulette wheel (seleksi antar individu bkn chromosome)
    crossover -> pertukaran antar individu
    mutasi -> random(dari banyak mata pelajaran) pada suatu kolom
    perhitungan fitness
    pemilihan individu dengan kromosom terbaik

    =========================================================================
    pop_size (banyak populasi)
    nind (banyak individu) 
    Pc (Probabilitas Crossover)
    Pm (Probabilitas mutasi)
    ngener (banyak generasi)
    */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Scheduling $event): void
    {
        //
    }
}
