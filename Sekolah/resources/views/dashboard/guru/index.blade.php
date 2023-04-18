@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="title-card">
    <div class="title-content">
        
    </div>
</div>
<div class="card">
    <form action="{{route('guru.store')}}" method="POST" style="padding-top: 0px">
        @csrf
        <h2>Form</h2>
        <label>Nama<span style="color:red">*</span></label> <br>
        <input type="text" name="nama_guru">
        <br>
        <label>Jenis Kelamin<span style="color:red">*</span></label> <br>
        <input type="text" name="gender_guru">
        <br>
        <label>No Telepon<span style="color:red">*</span></label> <br>
        <input type="text" name="no_telp_guru">
        <br>
        <label>Alamat<span style="color:red">*</span></label> <br>
        <input type="text" name="alamat_guru">
        <br>
        <label>Mata Pelajaran<span style="color:red">*</span></label> <br>
        <input type="text" name="waktu_awal">
        <br>
        <label>Jam Mengajar<span style="color:red">*</span></label> <br>
        <input type="text" name="waktu_awal">
        <br>
        <br>
        <input type="submit" value="Submit">
    </form>
</div>
<div class="card">
    <div class="button">
        <button type="submit"></button>
    </div>
    <table id="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Mata Pelajaran yang diajar</th>
                <th>Jam Mengajar</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collection as $idx => $item)
            <tr>
                <td>{{++$idx}}</td>
                <td>{{$item->kode_guru}}</td>
                <td>{{$item->nama_guru}}</td>
                <td></td>
                <td></td>
                <td>Edit || Hapus</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
@section('script')
<script>
     
</script>
@endsection