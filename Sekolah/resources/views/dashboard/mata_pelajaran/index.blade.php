@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="title-content">
    
</div>
<div class="card">
    <table id="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collection as $idx => $item)
            <tr>
                <td>{{++$idx}}</td>
                <td>{{$item->nama_mata_pelajaran}}</td>
                <td>Edit || Hapus</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection