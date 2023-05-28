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

<div class="card m-32 table-7 flex-row" style="width: 80vw; gap:20px">
    <div>
        <label for="">Tahun ajaran</label><br>
        <select name="tahun">
            <option value="">Pilih Tahun Ajaran</option>
            @foreach ($penjadwalan as $item)
                <option value="">{{$item->tahun_awal}}/{{$item->tahun_awal+1}}</option>
            @endforeach
        </select>

    </div>
    <div>
        <label for="">Semester</label><br>
        <select name="tahun">
            <option value="1">Gasal</option>
            <option value="0">Genap</option>
        </select>
    </div>
</div>
<table id="tbl" class="table-jadwal-saya">

</table>
@endsection
@section('script')
<script>
    const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};
    const url = window.location.origin+"/api/jadwal";

    let data = 

    function renderTable() {
        table = document.querySelector('#table-jadwal-saya tbody');

        table.innerHTML = `
            <tbody>

            </tbody>
        `;
    }

</script>
@endsection