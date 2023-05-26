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

<div id="form-layout" class="card m-20" style="width: 55%">
    <div class="title-card">
        Tambah Penjadwalan
    </div>
    <div class="form-area">
        <form class="store" style="display: flex; flex-direction: row;">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="left-side-form">
                <div class="">
                    <label>Tahun</label>
                    <br>
                    <input type="text">
                </div>
                <div class="">
                    <label>Semester</label>
                    <br>
                    <input type="text">
                </div>
            </div>
            <input class="clickable form-button title-card" type="submit" value="Tambah" onclick="submitForm()">
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
                                <select class="clickable penjadwalan-select-guru" name="" id="select-{{$j}}-{{$i}}" onchange="select7({{$j}},{{$i}})">
                                    <option value="">Pilih Guru</option>
                                    @foreach ($guru as $item3)
                                        <option value="{{$item3->id}}">{{$item3->nama_guru}}</option>
                                    @endforeach
                                </select>
                                <select class="clickable penjadwalan-select-mata-pelajaran" name="" id="">
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
                                    <option value="{{$item3->id}}">{{$item3->nama_guru}}</option>
                                @endforeach
                            </select>
                            <select class="clickable penjadwalan-select-mata-pelajaran" name="" id="">
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
                                    <option value="{{$item3->id}}">{{$item3->nama_guru}}</option>
                                @endforeach
                            </select>
                            <select class="clickable penjadwalan-select-mata-pelajaran" name="" id="">
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
        const array_8 = [];
        const array_9 = [];

        // Initialize the empty array
        for (let i = 0; i < columns; i++) {
            array_7[i] = [];
            for (let j = 0; j < rows; j++) {
                array_7[i][j] = null;
            }
        }

        rows = {{count($filtered_8)}};

        for (let i = 0; i < columns; i++) {
            array_8[i] = [];
            for (let j = 0; j < rows; j++) {
                array_8[i][j] = null;
            }
        }

        rows = {{count($filtered_9)}};

        for (let i = 0; i < columns; i++) {
            array_9[i] = [];
            for (let j = 0; j < rows; j++) {
                array_9[i][j] = null;
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
            console.log(array_7,[i,j]);
            renderAllSelect(i)
        }

        function select8(i,j) {
            const tbl = document.querySelector(".table-8");
            array_8[i][j] = parseInt(tbl.querySelector(`#select-${i}-${j}`).value);
            console.log(array_8,[i,j]);
            renderAllSelect(i)
        }

        function select9(i,j) {
            const tbl = document.querySelector(".table-9");
            array_9[i][j] = parseInt(tbl.querySelector(`#select-${i}-${j}`).value);
            console.log(array_9,[i,j]);
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
                        ${element.nama_guru}
                    </option>
                `
            });
            select.innerHTML = options;
        }

        let guru = <?php echo json_encode($guru); ?>; 
    </script>
@endsection