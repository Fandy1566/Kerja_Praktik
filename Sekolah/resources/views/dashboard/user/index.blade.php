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
                <th>Nama Pegawai</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Gender</th>
                <th>Email</th>
                @can('Admin')
                <th>&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($pegawaiall as $key => $value)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$value->name}}</td>
                <td>{{$value->telp}}</td>
                <td>{{$value->alamat}}</td>
                <td>{{$value->gender}}</td>
                <td>{{$value->email}}</td>
                @can('Admin')
                <td>
                    <a class="btn edit" href="/dashboard/pegawai/edit/{{ $value->id}}" style="margin-bottom:5%">Edit</a>
                    <form action="{{ route('pegawai.delete', ['id' => $value->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="_method" value="delete">
                        <button id="btn_hapus" type="submit" class="btn delete">Hapus</button>
                    </form>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection