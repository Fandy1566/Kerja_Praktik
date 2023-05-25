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
<div id="form-layout" class="card1 m-20" style="width: 55%;">
    <div class="form-nav flex-row" style="gap: 12px; margin-right: 12px;">
        <div class="center-text1 button button-active" style="width: fit-content; padding-inline: 28px" onclick="showTable7()">
            7
        </div>
        <div class="center-text1 button" onclick="showTable8()">
            8
        </div>
        <div class="center-text1 button" onclick="showTable9()">
            9
        </div>
    </div>
</div>

<div class="card m-32 table-7" style="width: 80vw;">
    <div class="title-card">
        Kelas 7
    </div>
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
                @foreach ($jadwalMengajar as $item)
                    <tr>
                        <td>{{$item->hari->nama_hari}}</td>
                        <td>{{$item->waktu_awal}} - {{$item->waktu_akhir}}</td>
                        @foreach ($filtered_7 as $item2)
                            <td>
                                <select class="clickable penjadwalan-select-guru" name="" id="">
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

<div class="card m-32 table-8" style="width: 80vw; display: none;">
    <div class="title-card">
        Kelas 8
    </div>
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
                @foreach ($jadwalMengajar as $item)
                    <tr>
                        <td>{{$item->hari->nama_hari}}</td>
                        <td>{{$item->waktu_awal}} - {{$item->waktu_akhir}}</td>
                        @foreach ($filtered_8 as $item2)
                        <td>
                            <select class="clickable penjadwalan-select-guru" name="" id="">
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

<div class="card m-32 table-9" style="width: 80vw;  display: none;">
    <div class="title-card">
        Kelas 9
    </div>
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
                @foreach ($jadwalMengajar as $item)
                    <tr>
                        <td>{{$item->hari->nama_hari}}</td>
                        <td>{{$item->waktu_awal}} - {{$item->waktu_akhir}}</td>
                        @foreach ($filtered_9 as $item2)
                        <td>
                            <select class="clickable penjadwalan-select-guru" name="" id="">
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
        const selectGurus = document.querySelectorAll("td select:nth-child(1)");
        selectGurus.forEach(select => {
            select.addEventListener("change", () => {
                console.log("diubah");
            });
        });

        // const rows = {{count($filtered_7)}};
        // const columns = {{count($jadwalMengajar)}}
        // const array_7 = [];

        // // Initialize the empty array
        // for (let i = 0; i < columns; i++) {
        //     array_7[i] = [];
        //     for (let j = 0; j < rows; j++) {
        //         array_7[i][j] = Math.random(); // You can assign any initial value you prefer
        //     }
        // }

        // for (let i = 0; i < array_7.length; i++) {
        //     for (let j = 0; j < array_7[i].length; j++) {
        //         array_7[i][j] = Math.random();
        //     }
        // }

        console.log(array_7);

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

    </script>
@endsection