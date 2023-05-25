@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jadwal Mengajar'])
<div id="form-layout" class="card1 m-20" style="width: 55%;">
    <div class="form-nav flex-row" style="gap: 12px; margin-right: 12px;">
        <div class="center-text1 button button-active" onclick="showSimple()" style="width: fit-content; padding-inline: 28px">
            Advance
        </div>
        <div class="center-text1 button" onclick="showAdvance()">
            Simple
        </div>
    </div>
    <h2 id="title-penjadwalan">Advance</h2>
    <div class="form-area">
        <form class="store flex-row" style="margin-top: 8px;">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            
            <div class="left-side-form" >
                <div class="pengaturan-username">
                    <label>Pc</label>
                    <input type="number" name="pc" step="any" placeholder="Masukan Probabilitas Crossover">
                </div>
                <div class="pengaturan-username" style="margin-top: 12px;">
                    <label>Pm</label>
                    <input type="number" name="pm" step="any" placeholder="Masukan Probabilitas Mutasi">
                    </select>
                </div>
            </div>
            <div class="right-side-form" style="margin-left: 32px;">
                <div class="pengaturan-username">
                    <label>Jumlah Generasi</label>
                    <input type="number" name="ngener" placeholder="Masukan Jumlah Generasi">
                </div>
                <div class="pengaturan-username" style="margin-top: 12px; margin-bottom: 12px;">
                    <label>Ukuran Populasi</label>
                    <input type="number" name="pop_size" placeholder="Masukan Ukuran Populasi">
                </div>
            </div>
            {{-- <input class="clickable form-button title-card" type="submit" value="Generate" id="submit" style="margin-bottom: 8px;"> --}}
        </form>
        <button class="clickable form-button title-card" type="button" id="submit">Generate</button>
    </div>
</div>
<div class="card m-32">
    {{-- <p>guru >= kelas</p>
    <p>waktu_mata_pelajaran >= jumlah jadwal_mengajar</p> --}}
    {{-- total banyak jam guru >= kelas * count($jumlah_jadwal) --}}
    <table id="tbl" style="overflow: scroll; ">
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
    let guru, kelas, jadwalMengajar, mata_pelajaran;

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
            console.log(newPop);

            result = [];
            // for(let i = 0; i < newPop.length; i++){
            //     newArr = [];
            //     for (let j = 0; j < guru.length; j++) {
            //         // if (newPop[i].includes(guru[j].id)) {
            //         //     newArr.push([guru[j].id, guru[j].nama_guru]);
            //         // }
            //         newArr.push(newPop[i][j]);
            //     }
            //     result.push(newArr);
            // }
            
            // console.log(result);

            // newArr = [];
            // while (result.length) {
            //     newArr.push(result.splice(0,kelas.length));
            // }
    
            tBody = document.querySelector("tbody")
            let row = `<tr>`;
            jadwalMengajar.forEach((element, i) => {
                let newRow = `
                    <td>${element.nama_hari}</td>
                    <td>${element.waktu_awal} - ${element.waktu_akhir}</td>
                `
                newPop[i].forEach(element2 => {
                    newRow += `
                        <td style="width:200px">${element2}</td>
                    `
                });
                row += newRow;
                row +=`</tr>`;
            });
            
            tBody.innerHTML = row;
        } else {
            alert("BANYAK GURU Tidak Boleh Kurang dari BANYAK KELAS")
        }
        // const newPop = geneticAlgorithm();
        // console.log(newPop);
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
            // console.log(fitnesses);
            const selected = selection(population, fitnesses);
            const offspring = crossover(selected);
            const mutated = mutate(offspring);
            population = replacement(population, mutated)
        }
        console.log(fitness_evaluation(population));
        return population[0];
        // return population;
    }

    async function getData() {
        try {
            const data = await Promise.all([
                fetch(baseUrl+"/api/guru").then(response => response.json()),
                fetch(baseUrl+"/api/kelas").then(response => response.json()),
                fetch(baseUrl+"/api/jadwal_mengajar").then(response => response.json()),
                fetch(baseUrl+"/api/mata_pelajaran").then(response => response.json())
            ]);

            guru = data[0].data;
            kelas = data[1].data;
            jadwalMengajar = data[2].data;
            mata_pelajaran = data[3].data;

            // console.log(mata_pelajaran);

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
            for (let j = 0; j < kelas.length; j++) {
                //chromosome
                let chromosome = [];
                let genes = randomizeArray(guru);
                // console.log(genes);
                for (let k = 0; k < jadwalMengajar.length; k++) {
                    const randomIndex = Math.floor(Math.random() * genes.length);
                    // console.log([genes[randomIndex], randomIndex, genes.length, k]);
                    //genes
                    chromosome.push(genes[randomIndex].id);
                    genes.splice(randomIndex, 1)[0];
                    // console.log({k});
                }
                individual.push(chromosome);
            }
            population.push(transpose(individual));
        }
        // console.log(population);
        return population;
    }

    function fitness_evaluation(population) {
        let fitnesses_ind = [];

        populationT = transpose(population)
        // console.log(populationT);

        for (let i = 0; i < population.length; i++) {
            let penalty = 0;
            const individualT = transpose[population[i]];
            const individual = population[i];

            for (let j = 0; j < populationT[i].length; j++) {
                let fitnesses_chrom = [];
                let counts = {};
                for (let k = 0; k < populationT[i][j].length; k++) {
                    let val = populationT[i][j][k];
                    counts[val] = (counts[val] || 0) + 1;
                        // for (let i = 0; i < data.length; i++) {
                        //     for (let j = i + 1; j < data.length; j++) {
                        //         if (data[i][0] === data[j][0] && data[i][1] !== data[j][1]) {
                        //         console.log(`Found elements with the same value at index [${i}][0] but different values at index [${i}][1]:`);
                        //         console.log(data[i]);
                        //         console.log(data[j]);
                        //     }
                        // }
                }
                for (let k = 0; k < populationT[i][j].length; k++) {
                    let val = populationT[i][j][k];
                    if (counts[val] >= 3 && counts[val] == 1) {
                        penalty += 1;
                        // duplicates.push(k); // ambil index
                    }
                }
            }
            // console.log(penalty);

            for (let j = 0; j < individual.length; j++) {
                let chromosome = individual[j];

                let seen = new Set();

                for (let k = 0; k < chromosome.length; k++) {
                    if (seen.has(chromosome[k])) {
                        penalty += 3; //3
                    } else {
                        seen.add(chromosome[k]);
                    }
                }

                //tambah untuk perhitungan jumlah jam guru tidak kurang dari yang ditentukan //1
                //tambah untuk perhitungan jumlah mapel tidak kurang dari yang ditentukan //2
                //tambah untuk perhitungan mapel harus diajar di waktu berikutnya  //2
            }
            console.log(penalty);
            fitnesses_ind.push(1/(1+penalty));
        }
        console.log(fitnesses_ind);
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
                        // if (counts[val] >= 2) {
                        //     const excludedValues = offspring[i][j];
                        //     const data = guru.map(obj => obj.id);
                        //     const filteredArray = data.filter(val => !excludedValues.includes(val));
                        //     const randomIndex = Math.floor(Math.random() * filteredArray.length);
                        //     const randomValue = filteredArray[randomIndex];
                            
                        //     offspring[i][j][k] = randomValue;

                        //     // duplicates.push(k); // ambil index
                        // }

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

    function swapMutation(individual) {
        // Iterate over the genes of the individual's chromosome
        for (let i = 0; i < individual.length; i++) { //tambah loop lg karna mutasinya blm dalam
            // Randomly decide whether to apply mutation based on mutation rate
            if (Math.random() < pm) {
            // Generate two random positions to swap
            const position1 = Math.floor(Math.random() * individual.length);
            const position2 = Math.floor(Math.random() * individual.length);
            console.log(individual[i]);
            console.log([individual[i][position1],individual[i][position2]]);
            // Swap the values at the two positions
            const temp = individual[i][position1];
            individual[i][position1] = individual[i][position2];
            individual[i][position2] = temp;
            }
        }
    return individual;
    }

    function mutate(population) {
        // if (Math.random() <= 0.5) {
        population = mutation(population);
        // } else {
        //     for (let i = 0; i < population.length; i++) {
        //         population[i] = swapMutation(population[i]);
        //     }
        // }
        return population;
    }

    function replacement(population, mutants) {
        // console.log(mutants);
        const combinedPopulation = mutants.concat(population);
        const fitnesses = fitness_evaluation(combinedPopulation);
        const sortedPopulation = combinedPopulation.sort((a, b) => fitnesses[population.indexOf(b)] - fitnesses[population.indexOf(a)]).slice(0,population.length);
        // const sortedPopulation = combinedPopulation.sort((a, b) => {
        //     // Replace `fitnessFunction` with your fitness evaluation code here
        //     const fitnessA = fitness_evaluation(a);
        //     const fitnessB = fitness_evaluation(b);
        //     return fitnessB - fitnessA;
        // }).slice(0, population.length);
        // console.log(sortedPopulation);
        return sortedPopulation;
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

    function transpose(matrix) {
        return matrix[0].map((col, i) => matrix.map(row => row[i]));
    }

</script>
{{-- <script src="{{asset('js/penjadwalan.js')}}"> --}}
@endsection