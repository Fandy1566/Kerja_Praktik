@php

    $jadwal_hari_map = [];
    for ($i=0; $i < count($jadwalMengajar); $i++) { 
        $jadwal_hari_map[] = $jadwalMengajar[$i]->id_hari;
    }

    $numbers = array_unique($jadwal_hari_map);
    $jam = [];
    for ($i=0; $i < count($jadwalMengajar); $i++) { 
        if (!isset($jam[$jadwalMengajar[$i]->id_hari])) {
            $jam[$jadwalMengajar[$i]->id_hari] = 0;
        }
        $jam[$jadwalMengajar[$i]->id_hari] += 1;
    }

    $maxCount = 0;



    foreach ($jam as $key => $value) {
        if ($value > $maxCount) {
            $maxCount = $value;
        }
    }
@endphp

@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jadwal Mengajar'])

<div class="form-nav flex-row" style="gap: 12px; margin-right: 12px; margin-top: 16px;">
    <div class="clickable prevent-select center-text btn btn-table-active">
        Jadwal Saya
    </div>
    <div class="clickable prevent-select center-text btn">
        Jadwal Seluruh
    </div>
    @can('Admin')
    <div class="clickable prevent-select center-text btn" onclick="window.location = '{{ route('jadwal.create') }}'">
        Tambah Jadwal
    </div>
    @endcan
</div>

<div class="card m-32 table-7" style="width: 80vw;">
    <label for="">Tahun ajaran</label><br>
    <select name="tahun">
        <option value="">Pilih Tahun Ajaran</option>
        @foreach ($penjadwalan as $item)
            <option value="">{{$penjawdalan->tahun_awal}}/{{$penjadwalan->tahun_awal+1}}</option>
        @endforeach
    </select>
</div>
<table id="tbl" class="table-jadwal-saya">
    <thead>
        <tr>
            <th>Hari</th>
            @for ($j = 0; $j < $maxCount; $j++)
            <th>Jam ke-{{$j+1}}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < count($numbers); $i++)
        <tr>
            <td></td>
        </tr>
        @endfor
    </tbody>
</table>
@endsection
@section('script')
<script>
    const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};
    const url = window.location.origin+"/api/jadwal";

    function renderTable() {
        table = document.querySelector('#table-jadwal-saya tbody');

        table.innerHTML = `

        `;
    }

</script>
@endsection