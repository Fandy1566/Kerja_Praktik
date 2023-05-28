@php

    $tingkat = [];
    for ($i=0; $i < count($kelas); $i++) { 
        if (!isset($tingkat[$kelas[$i]->tingkat])) {
            $tingkat[$kelas[$i]->tingkat] = 0;
        }
        $tingkat[$kelas[$i]->tingkat] += 1;
    }

@endphp

@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jadwal Mengajar'])

<div class="clickable prevent-select center-text btn" onclick="window.location = '{{ route('jadwal') }}'">
    Kembali
</div>

<div id="form-layout" class="card m-20" style="width: 55%">
    <div class="title-card">
        Tambah Penjadwalan
    </div>
    <div class="form-area">
        <form class="store" style="display: flex; flex-direction: row;">
            <div class="left-side-form">
                <div class="">
                    <label>Tahun</label>
                    <br>
                    <input type="text" name="tahun">
                </div>
                <div class="">
                    <label>Semester</label>
                    <br>
                    <input type="text" name="semester">
                </div>
            </div>
            <input class="clickable form-button title-card" type="button" value="Tambah" onclick="simpanJadwal()">
        </form>
    </div>
</div>

<div class="form-nav flex-row" style="gap: 12px; margin-right: 12px; margin-top: 16px; margin-left: 30px">
    <div data-table="7" class="center-text btn btn-7 btn-table-active" onclick="showTable7()">
        7
    </div>
    <div data-table="8" class="center-text btn btn-8" onclick="showTable8()">
        8
    </div>
    <div data-table="9" class="center-text btn btn-9" onclick="showTable9()">
        9
    </div>
</div>

<div class="card m-32 tbl-jadwal table-7" style="width: 80vw;">
    <div class="table-container" style="margin-left: 12px; margin-right: 12px; overflow-x: scroll">
        <table id="tbl7" class="table-check">
            <thead>
                <tr>
                    <th rowspan="2">Hari</th>
                    <th rowspan="2">Waktu</th>
                    <th colspan ="{{$tingkat["7"]}}">Kelas</th>
                </tr>
                @php
                    $filtered_7 = $kelas->filter(function($item)
                    {
                        return $item->tingkat == "7"; 
                    });
                @endphp
                <tr>
                    @foreach ($filtered_7 as $item)
                        <th>{{$item->nama_kelas}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalMengajar as $j => $item)
                    <tr>
                        <td>{{$item->hari->nama_hari}}</td>
                        <td>{{$item->waktu_awal}} - {{$item->waktu_akhir}}</td>
                        @foreach ($filtered_7 as $i => $item2)
                            <td>
                                <div class="flex-column" style="gap:10px; padding-inline: 10px">
                                    <select class="clickable penjadwalan-select-guru" name="" id="select-{{$j}}-{{$i}}" onchange="select7({{$j}},{{$i}})">
                                        <option value="">Pilih Guru</option>
                                        @foreach ($guru as $item3)
                                            <option value="{{$item3->id}}">({{$item3->id}}) {{$item3->name}}</option>
                                        @endforeach
                                    </select>
                                    <select class="clickable penjadwalan-select-mata-pelajaran" id="select-mp-{{$j}}-{{$i}}" onchange="selectmp7({{$j}},{{$i}})">
                                        <option value="">Pilih Mata Pelajaran</option>
                                        @foreach ($mataPelajaran as $item3)
                                            <option value="{{$item3->id}}">{{$item3->nama_mata_pelajaran}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card m-32 tbl-jadwal table-8" style="width: 80vw; display: none;">
    <div class="table-container" style="margin-left: 12px; margin-right: 12px; overflow-x: scroll;">
        <table id="tbl8" class="table-check">
            <thead>
                <tr>
                    <th rowspan="2">Hari</th>
                    <th rowspan="2">Waktu</th>
                    <th colspan ="{{$tingkat["8"]}}">Kelas</th>
                </tr>
                @php
                    $filtered_8 = $kelas->filter(function($item)
                    {
                        return $item->tingkat == "8"; 
                    });
                @endphp
                <tr>
                    @foreach ($filtered_8 as $item)
                        <th>{{$item->nama_kelas}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalMengajar as $j => $item)
                    <tr>
                        <td>{{$item->hari->nama_hari}}</td>
                        <td>{{$item->waktu_awal}} - {{$item->waktu_akhir}}</td>
                        @foreach ($filtered_8 as $i => $item2)
                        <td>
                            <select class="clickable penjadwalan-select-guru" id="select-{{$j}}-{{$i}}" onchange="select8({{$j}},{{$i}})">
                                <option value="">Pilih Guru</option>
                                @foreach ($guru as $item3)
                                    <option value="{{$item3->id}}">({{$item3->id}}) {{$item3->name}}</option>
                                @endforeach
                            </select>
                            <select class="clickable penjadwalan-select-mata-pelajaran" id="select-mp-{{$j}}-{{$i}}" onchange="selectmp8({{$j}},{{$i}})">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($mataPelajaran as $item3)
                                    <option value="{{$item3->id}}">{{$item3->nama_mata_pelajaran}}</option>
                                @endforeach
                            </select>
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card m-32 tbl-jadwal table-9" style="width: 80vw;  display: none;">
    <div class="table-container" style="margin-left: 12px; margin-right: 12px; overflow-x: scroll;">
        <table id="tbl9" class="table-check" style= "overflow: scroll;">
            <thead>
                <tr>
                    <th rowspan="2">Hari</th>
                    <th rowspan="2">Waktu</th>
                    <th colspan ="{{$tingkat["9"]}}">Kelas</th>
                </tr>
                @php
                    $filtered_9 = $kelas->filter(function($item)
                    {
                        return $item->tingkat == "9"; 
                    });
                @endphp
                <tr>
                    @foreach ($filtered_9 as $item)
                        <th>{{$item->nama_kelas}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalMengajar as $j => $item)
                    <tr>
                        <td>{{$item->hari->nama_hari}}</td>
                        <td>{{$item->waktu_awal}} - {{$item->waktu_akhir}}</td>
                        @foreach ($filtered_9 as $i => $item2)
                        <td>
                            <select class="clickable penjadwalan-select-guru" id="select-{{$j}}-{{$i}}" onchange="select9({{$j}},{{$i}})">
                                <option value="">Pilih Guru</option>
                                @foreach ($guru as $item3)
                                    <option value="{{$item3->id}}">({{$item3->id}}) {{$item3->name}}</option>
                                @endforeach
                            </select>
                            <select class="clickable penjadwalan-select-mata-pelajaran" id="select-mp-{{$j}}-{{$i}}" onchange="selectmp9({{$j}},{{$i}})">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($mataPelajaran as $item3)
                                    <option value="{{$item3->id}}">{{$item3->nama_mata_pelajaran}}</option>
                                @endforeach
                            </select>
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
    <script>

        let rows = {{count($filtered_7)}};
        const columns = {{count($jadwalMengajar)}}
        const array_7 = [];
        const array_7_mp = [];
        const array_8 = [];
        const array_8_mp = [];
        const array_9 = [];
        const array_9_mp = [];

        // Initialize the empty array
        for (let i = 0; i < columns; i++) {
            array_7[i] = [];
            array_7_mp[i] = [];
            for (let j = 0; j < rows; j++) {
                array_7[i][j] = null;
                array_7_mp[i][j] = null;
            }
        }

        rows = {{count($filtered_8)}};

        for (let i = 0; i < columns; i++) {
            array_8[i] = [];
            array_8_mp[i] = [];
            for (let j = 0; j < rows; j++) {
                array_8[i][j] = null;
                array_8_mp[i][j] = null;
            }
        }

        rows = {{count($filtered_9)}};

        for (let i = 0; i < columns; i++) {
            array_9[i] = [];
            array_9_mp[i] = [];
            for (let j = 0; j < rows; j++) {
                array_9[i][j] = null;
                array_9_mp[i][j] = null;
            }
        }

        function showTable7() {
            document.querySelector(".table-7").style.display = "block";
            document.querySelector(".table-8").style.display = "none";
            document.querySelector(".table-9").style.display = "none";
        }

        function showTable8() {
            document.querySelector(".table-7").style.display = "none";
            document.querySelector(".table-8").style.display = "block";
            document.querySelector(".table-9").style.display = "none";
        }

        function showTable9() {
            document.querySelector(".table-7").style.display = "none";
            document.querySelector(".table-8").style.display = "none";
            document.querySelector(".table-9").style.display = "block";
        }

        function select7(i,j) {
            const tbl = document.querySelector(".table-7");
            array_7[i][j] = parseInt(tbl.querySelector(`#select-${i}-${j}`).value);
            // console.log(array_7,[i,j]);
            renderAllSelect(i)
        }

        function select8(i,j) {
            const tbl = document.querySelector(".table-8");
            array_8[i][j] = parseInt(tbl.querySelector(`#select-${i}-${j}`).value);
            // console.log(array_8,[i,j]);
            renderAllSelect(i)
        }

        function select9(i,j) {
            const tbl = document.querySelector(".table-9");
            array_9[i][j] = parseInt(tbl.querySelector(`#select-${i}-${j}`).value);
            // console.log(array_9,[i,j]);
            renderAllSelect(i)
        }

        function selectmp7(i,j) {
            const tbl = document.querySelector(".table-7");
            array_7_mp[i][j] = parseInt(tbl.querySelector(`#select-mp-${i}-${j}`).value);
            // console.log(array_7,[i,j]);
            renderAllSelect(i)
        }

        function selectmp8(i,j) {
            const tbl = document.querySelector(".table-8");
            array_8_mp[i][j] = parseInt(tbl.querySelector(`#select-mp-${i}-${j}`).value);
            // console.log(array_8,[i,j]);
            renderAllSelect(i)
        }

        function selectmp9(i,j) {
            const tbl = document.querySelector(".table-9");
            array_9_mp[i][j] = parseInt(tbl.querySelector(`#select-mp-${i}-${j}`).value);
            // console.log(array_9,[i,j]);
            renderAllSelect(i)
        }

        function renderAllSelect(i) {
            const tbl_jadwal = document.querySelectorAll(".tbl-jadwal");
            tbl_jadwal.forEach(table =>{
                table.querySelectorAll(`tr:nth-child(${i+1}) select:nth-child(1)`).forEach(select =>{
                    renderSelect(select, i)
                });
            })
        }

        function renderSelect(select,i){
            // console.log(array_7[i])
            let guru_mapped = guru.map(item=>item.id)
            let option = guru.filter(item=> !array_7[i].includes(item.id) && !array_8[i].includes(item.id) && !array_9[i].includes(item.id));
            let options ='';
            options +=`<option value="">Pilih Guru</option>`
            if (select.value !== '') {
                options +=`<option value="${select.value}" selected>${select.options[select.selectedIndex].text}</option>`
            }
            option.forEach((element) => {
                options +=`
                    <option value="${element.id}">
                        (${element.id}) ${element.name}
                    </option>
                `
            });
            select.innerHTML = options;
        }

        let guru = <?php echo json_encode($guru); ?>; 

        async function simpanJadwal() {

            const tahun = document.querySelector('input[name="tahun"]').value;
            const semester = document.querySelector('input[name="semester"]').value;
            // console.log(JSON.stringify({
            //     array7: array_7,
            //     array7_mp: array_7_mp,
            //     array8: array_8,
            //     array8_mp: array_8_mp,
            //     array9: array_9,
            //     array9_mp: array_9_mp,
            //     tahun_awal : tahun,
            //     is_gasal : semester,
            // }));
        try {
            const response = await fetch(window.location.origin+"/api/jadwal", {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": "{{ csrf_token() }}"
                },
                method: "post",
                credentials: "same-origin",
                body: JSON.stringify({
                    array7: array_7,
                    array7_mp: array_7_mp,
                    array8: array_8,
                    array8_mp: array_8_mp,
                    array9: array_9,
                    array9_mp: array_9_mp,
                    tahun_awal : tahun,
                    is_gasal : semester,
                })
            });
            const data = await response.json();
        } catch (error) {
            console.error(error);
        }
    }


    </script>
@endsection