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
<div class="card m-32" style="width: 80vw">
    <table id="tbl" style= "overflow: scroll">
        <thead>

        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script src="{{asset('js/ga.js')}}"></script>
<script>
    const baseUrl = window.location.origin;
    const submitBtn = document.getElementById("submit");
    const formArea = document.querySelector(".form-area")

    //genetic algorithm variables
    let pop_size, pc, pm, ngener;

    let lessons = [];

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
        // console.log("click");

        runAlgo()
          
        // if (guru.length >= kelas.length && guru.length != 0) {
            // const newPop = transpose(geneticAlgorithm());
            console.log(population[0]);
            
            tBody.innerHTML = row;
        });

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

    async function getData() {
        try {
            const data = await Promise.all([
                fetch(baseUrl+"/api/guru").then(response => response.json()),
                fetch(baseUrl+"/api/kelas").then(response => response.json()),
                fetch(baseUrl+"/api/jadwal_mengajar").then(response => response.json()),
                fetch(baseUrl+"/api/get_guru_mata_pelajaran").then(response => response.json()),
                fetch(baseUrl+"/api/get_guru_detail").then(response => response.json())
            ]);

            guru = data[0].data;
            kelas = data[1].data;
            jadwalMengajar = data[2].data;
            mata_pelajaran = data[3].data;
            guru_detail = data[4].data;

        } catch (error) {
            console.error('Error:', error);
        }
    }

    //data
    let guru, kelas, jadwalMengajar, mata_pelajaran, guru_detail;

    class lesson {
        constructor(id, course, teacher, studentGroup, duration, equipment) {
            this.id = id;
            this.course = course;
            this.teacher = teacher;
            this.duration = duration;
        }
    }
    
    //l = chromosome length
    //n = timespace slot number
    //s = population size
    function runAlgo(){
        lessons = [];
        count = 0;
        for (let i = 0; i < guru_detail.length; i++) {
            for (let count = 0; count < guru_detail[i].mata_pelajaran.banyak; count++) {
                lessons.push(new lesson(count, guru_detail[i].mata_pelajaran.id, guru_detail[i].guru.id, guru_detail[i].mata_pelajaran.banyak));
                count++;
            }
        }

        console.log(lessons);

        l = lessons.length;
        n = jadwalMengajar.length*kelas.length;
        s = pop_size;

        var initialPopulation = initialise(s, l, n);  //l = 10, n = 70
        population = [];
        initialPopulation.forEach(element => {
            population.push({ chromosome: element, fitness: fitness(element) });
        });
        evolve(population, l, n, s, pc, pm );
        for(generation = 0; generation < ngener; generation++){
            if(population[0].fitness<1)
                evolve(population, l, n, s, pc, pm );
            else break;
        }
        console.log("generation: ",generation, "best fitness: " ,population[0].fitness);
        
        console.log(population);
    }
</script>
@endsection
