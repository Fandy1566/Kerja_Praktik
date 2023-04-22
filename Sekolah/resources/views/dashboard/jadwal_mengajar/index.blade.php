@extends('layouts.dashboard')
@section('head')
<link href="{{ asset('/css/modal.css') }}" rel="stylesheet">
@endsection
@section('title', 'Dashboard')
@section('content')
<div class="title-content">
    
</div>
<div class="card">
    <form>
        <div class="input-more break">
            <label>Waktu Mengajar<span style="color:red">*</span></label> <br>
            <input type="text" name="waktu_awal"> - <input type="text" name="waktu_akhir"><br>
            <label>Hari<span style="color:red">*</span></label> <br>
            <input type="text" name="id_hari">
            <br>
            <br>
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <input type="submit" onclick="submitForm()">
        </div>
    </form>

    <table id="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        @foreach ($collection as $idx =>$item)
        <tbody>
            <td>{{++$idx}}</td>
            <td>{{$item->id_hari}}</td>
            <td>{{$item->waktu_awal}}</td>
            <td>{{$item->waktu_akhir}}</td>

            <td>&nbsp;</td>
        </tbody>
        @endforeach
    </table>
</div>
@endsection
@section('script')
<script>

    console.log(window.location.origin);

    function submitForm() {
        event.preventDefault(); // prevent form submission

        const csrfToken = document.querySelector('input[name="_token"]').value;
        const val_id_hari = document.getElementsByName("id_hari")[0].value;
        const val_waktu_awal = document.getElementsByName("waktu_awal")[0].value;
        const val_waktu_akhir = document.getElementsByName("waktu_akhir")[0].value;
        const url = window.location.origin+"/api/jadwal_mengajar";

        fetch(base_url+webpage, {
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
            id_hari: val_id_hari,
            waktu_awal: val_waktu_awal,
            waktu_akhir: val_waktu_akhir
        })
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error(error));
    }
</script>
@endsection