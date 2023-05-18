@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jadwal Mengajar'])
<div id="form-layout" class="card m-20">
    <div class="form-nav flex-row">
        <div class="center-text button button-active" onclick="showSimple()" style="width: fit-content; padding-inline: 28px">
            Simple
        </div>
        <div class="center-text button" onclick="showAdvance()">
            Advance
        </div>
    </div>
    <h2>Advance</h2>
    <div class="form-area">
        <form class="store flex-row">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            
            <div class="left-side-form" >
                <div class="pengaturan-username">
                    <label>Pc</label>
                    <input type="number" name="pc" placeholder="Masukan Probabilitas Crossover">
                </div>
                <div class="pengaturan-username" style="margin-top: 12px;">
                    <label>Pm</label>
                    <input type="number" name="pm" placeholder="Masukan Probabilitas Mutasi">
                    </select>
                </div>
            </div>
            <div class="right-side-form" style="margin-left: 32px;">
                <div class="pengaturan-username">
                    <label>Jumlah Generasi</label>
                    <input type="number" name="ngener" placeholder="Masukan Jumlah Generasi">
                </div>
                <div class="pengaturan-username" style="margin-top: 12px;">
                    <label>Ukuran Populasi</label>
                    <input type="number" name="ngener" placeholder="Masukan Ukuran Populasi">
                </div>
            </div>
            <input class="clickable form-button title-card" type="submit" value="Generate" id="submit">
        </form>
    </div>
</div>
<div class="card m-32">
    {{-- <p>guru >= kelas</p>
    <p>waktu_mata_pelajaran >= jumlah jadwal_mengajar</p> --}}
    {{-- total banyak jam guru >= kelas * count($jumlah_jadwal) --}}
    <table id="tbl">
        <thead>

        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    const baseUrl = window.location.origin;
    const submitBtn = document.getElementById("submit");
    const formArea = document.querySelector(".form-area")

    //data
    let guru, kelas, jadwalMengajar;

    //genetic algorithm variables
    let pop_size, pc, pm, ngener;

    function showSimple() {

    }

    function showAdvance() {
        
    }

    main();

    submitBtn.addEventListener("click", () => {
        pop_size = document.getElementsByName("pop_size")[0].value;
        pc = document.getElementsByName("pc")[0].value;
        pm = document.getElementsByName("pm")[0].value;
        ngener = document.getElementsByName("ngener")[0].value;
        
        if (guru.length >= kelas.length && guru.length != 0) {
            const newPop = geneticAlgorithm();
    
            result = [];
            for(let i = 0; i < newPop.length; i++){
                for (let j = 0; j < guru.length; j++) {
                    if (newPop[i].includes(guru[j].id)) {
                        result.push([guru[j].id, guru[j].nama_guru]);
                    }
                }
            }
    
            newArr = [];
            while (result.length) {
                newArr.push(result.splice(0,kelas.length));
            }
    
            tBody = document.querySelector("tbody")
            let row = `<tr>`;
            jadwalMengajar.forEach((element, i) => {
                let newRow = `
                    <td>${element.nama_hari}</td>
                    <td>${element.waktu_awal} - ${element.waktu_akhir}</td>
                `
                newArr[i].forEach(element2 => {
                    newRow += `
                        <td>${element2[1]}</td>
                    `
                });
                row += newRow;
                row +=`</tr>`;
            });
            
            tBody.innerHTML = row;
        } else {
            alert("BANYAK GURU Tidak Boleh Kurang dari BANYAK KELAS")
        }

    })

    // ==========================================================================
    

    async function main() {
        await getData();

        tHead = document.querySelector("thead");
        let col = `
        <tr>
            <th rowspan="2">Hari</th>
            <th rowspan="2">Waktu</th>
            <th colspan ="${kelas.length}">Kelas</th>
        </tr>
        <tr>`;
        kelas.forEach(element => {
            let newCol = `
                <th>${element.nama_kelas}</th>
            `
            col += newCol;
        });
        col+= `</tr>`
        tHead.innerHTML = col;

        tBody = document.querySelector("tbody")
        let row = `<tr>`;
        jadwalMengajar.forEach(element => {
            let newRow = `
                <td>${element.nama_hari}</td>
                <td>${element.waktu_awal} - ${element.waktu_akhir}</td>
            `
            kelas.forEach(element2 => {
                newRow += `
                    <td></td>
                `
            });
            row += newRow;
            row +=`</tr>`;
        });
        
        tBody.innerHTML = row;
        
    }

    function geneticAlgorithm() {
        let population = createPopulation();
        for (let i = 0; i < ngener; i++) {
            const fitnesses = fitness_evaluation(population);
            const selected = selection(population, fitnesses);
            const offspring = crossover(selected);
            const mutated = mutation(offspring);
            population = replacement(population, mutated)
        }
        return population[0];
    }

    async function getData() {
        try {
            const data = await Promise.all([
                fetch(baseUrl+"/api/guru").then(response => response.json()),
                fetch(baseUrl+"/api/kelas").then(response => response.json()),
                fetch(baseUrl+"/api/jadwal_mengajar").then(response => response.json())
            ]);

            guru = data[0].data;
            kelas = data[1].data;
            jadwalMengajar = data[2].data;
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function createPopulation() {
        //population
        let population = [];
        for (let i = 0; i < pop_size; i++) {
            //individual
            let individual = [];
            for (let j = 0; j < jadwalMengajar.length; j++) {
                //chromosome
                let chromosome = [];
                let genes = randomizeArray(guru);
                for (let k = 0; k < kelas.length; k++) {
                    //genes
                    chromosome.push(genes[k].id);
                    // console.log({k});
                }
                individual.push(chromosome);
            }
            population.push(individual);
        }
        console.log(population);
        return population;
    }

    function fitness_evaluation(population) {
        let fitnesses_ind = [];

        for (let i = 0; i < population.length; i++) {
            let individual = population[i];
            let fitnesses_chrom = [];

            for (let j = 0; j < individual.length; j++) {
                let chromosome = individual[j];


                //search O(n^2)
                // for (let k = 0; k < chromosome.length; k++) {
                //     for (let l = 0; l < chromosome.length; l++) {
                //         if (k !== l) {
                //             if (chromosome[k] == chromosome[l]) {
                                
                //                 penalty += 1;
                //             }
                //         }
                //     }
                // }

                let seen = new Set();
                let penalty = 0;

                for (let i = 0; i < chromosome.length; i++) {
                    if (seen.has(chromosome[i])) {
                        penalty += 3; //3
                    } else {
                        seen.add(chromosome[i]);
                    }
                }

                //tambah untuk perhitungan jumlah jam guru tidak kurang dari yang ditentukan //1
                //tambah untuk perhitungan jumlah mapel tidak kurang dari yang ditentukan //2
                //tambah untuk perhitungan mapel harus diajar di waktu berikutnya  //2

                fitnesses_chrom.push(1 / (1 + penalty));
            }

            const sum = fitnesses_chrom.reduce((acc, val) => acc + val, 0);
            const avg = sum / fitnesses_chrom.length;

            fitnesses_ind.push(avg);
        }
        // console.log(fitnesses_ind);
        return fitnesses_ind;
    }

    function rouletteWheelSelection(population, fitness) {
        let sum = fitness.reduce((acc, val) => acc + val, 0);
        let pick = Math.random() * sum;
        let current = 0;

        for (let i = 0; i < population.length; i++) {
            current += fitness[i];
            if (current > pick) {;
                return i;
            }
        }
    }

    function selection(population, fitness) {
        const selectionSize = pc * population.length;
        let selected = [];

        for (let i = 0; i < selectionSize; i++) {
            let parents = [];

            for (let j = 0; j < 2; j++) {
                let index = rouletteWheelSelection(population, fitness);
                parents.push(population[index]);
            }

            selected.push(parents);
        }

        return selected;
    }

    function singlePointCrossover(parent1, parent2) {
        // Select a random crossover point
        const crossoverPoint = Math.floor(Math.random() * parent1.length);
        // ubah jadi ordered crossover

        // Create two empty child arrays
        const child1 = new Array(parent1.length);
        const child2 = new Array(parent2.length);

        // Copy the first part of the parents into the children
        for (let i = 0; i < crossoverPoint; i++) {
            child1[i] = parent1[i];
            child2[i] = parent2[i];
        }

        // Copy the second part of the parents into the opposite children
        for (let i = crossoverPoint; i < parent1.length; i++) {
            child1[i] = parent2[i];
            child2[i] = parent1[i];
        }
        // Return the two child arrays as a pair
        return [child1, child2];
    }

    function crossover(parents) {
        const offspring = [];
        // Perform crossover on the selected parents to generate new offspring
        for (let i = 0; i < parents.length; i++) {
            const parent1 = parents[i][0];
            const parent2 = parents[i][1];
            const child = singlePointCrossover(parent1, parent2);
            offspring.push(child);
        }
        return offspring.flatMap(obj1 => obj1.map(obj2 => obj2));
    }

    function mutation(offspring) {
        for (let i = 0; i < offspring.length; i++) {
            for (let j = 0; j < offspring[i].length; j++) {
                if (Math.random() <= pm) {
                    let counts = {};
                    let duplicates = [];

                    for (let k = 0; k < offspring[i][j].length; k++) {
                        let val = offspring[i][j][k];
                        counts[val] = (counts[val] || 0) + 1;
                        // for (let l = 0; l < array.length; l++) {
                            
                        // }
                        if (counts[val] >= 2) {
                            const excludedValues = offspring[i][j];
                            const data = guru.map(obj => obj.id);
                            const filteredArray = data.filter(val => !excludedValues.includes(val));
                            const randomIndex = Math.floor(Math.random() * filteredArray.length);
                            const randomValue = filteredArray[randomIndex];
                            
                            offspring[i][j][k] = randomValue;

                            // duplicates.push(k); // ambil index
                        }

                        if (Math.random() <= pm) {
                            const excludedValues = offspring[i][j];
                            const data = guru.map(obj => obj.id);
                            const filteredArray = data.filter(val => !excludedValues.includes(val));
                            const randomIndex = Math.floor(Math.random() * filteredArray.length);
                            const randomValue = filteredArray[randomIndex];
                            offspring[i][j][k] = randomValue;
                        }
                    }
                }
            }
            
        }
        return offspring;
    }

    function replacement(population, mutants) {
        // console.log(mutants);
        const combinedPopulation = population.concat(mutants);
        const fitnesses = fitness_evaluation(combinedPopulation);
        const sortedPopulation = combinedPopulation.sort((a, b) => fitnesses[population.indexOf(b)] - fitnesses[population.indexOf(a)]);
        const newPopulation = sortedPopulation.slice(0, population.length);

        return newPopulation;
    }

    function randomizeArray(arr) {
        // Make a copy of the original array
        const arrCopy = arr.slice();
        // Loop through the array
        for (let i = arrCopy.length - 1; i > 0; i--) {
            // Generate a random index from 0 to i
            const j = Math.floor(Math.random() * (i + 1));
            // Swap the current element with the randomly selected one
            [arrCopy[i], arrCopy[j]] = [arrCopy[j], arrCopy[i]];
        }
        // Return the randomized array
        return arrCopy;
    }

</script>
{{-- <script src="{{asset('js/penjadwalan.js')}}"> --}}
@endsection