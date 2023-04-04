@extends('layouts.dashboard')
@section('head')
<link href="{{ asset('/css/modal.css') }}" rel="stylesheet">
@endsection
@section('title', 'Dashboard')
@section('content')
<div id="modal" class="modal" style="{{(request()->is('*/edit*'))? 'display:block':''}}">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>{{(request()->is('*/edit*'))? 'Edit Data':'Input Data'}}</h2>
        </div>
        <div class="card-form">
            <form action="{{route('jam_mengajar.store')}}" method="POST" style="padding-top: 0px">
                @csrf
                <div class="input-more break">
                    <label>Waktu Mengajar<span style="color:red">*</span></label> <br>
                    <input type="text" name="waktu_awal"> - <input type="text" name="waktu_akhir">
                    <br>
                    <br>
                    <input type="submit">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="title-content">
    
</div>
<div class="card">
    <button type="button" onclick="alert('Hello world!')" id="add">
        Tambah Jadwal
    </button>
    <table id="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
            </tr>
        </thead>
        @foreach ($collection as $idx =>$item)
        <tbody>
            <td>{{++$idx}}</td>
            <td>{{$item->waktu_jam_mengajar}}</td>
        </tbody>
        @endforeach
    </table>
</div>
@endsection
@section('script')
<script>
    var modal = document.getElementById("modal");
    var btn = document.getElementById("add");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
    modal.style.display = "block";
    }
    span.onclick = function() {
    modal.style.display = "none";
    }
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    }
</script>
@endsection