@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Kelas'])
<div class="title-card">
    <div class="title-content">
        
    </div>
</div>
<div class="card">
    <form class="store">
        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
        <label>Tambah Kelas</label> <br>
        <input type="radio" id="html" name="tingkat" value=7>
        <label>Kelas 7</label><br>
        <input type="radio" id="css" name="tingkat" value=8>
        <label>Kelas 8</label><br>
        <input type="radio" id="javascript" name="tingkat" value=9>
        <label>Kelas 9</label><br><br>
        <input type="submit" value="Tambah" onclick="submitForm()">
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
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>

</div>
@endsection
@section('script')
<script>
    
    window.onload = () => {
        getData();
    }
    const url = window.location.origin+"/api/kelas";

    function getData() {
        fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const tblBody = document.querySelector('#tbl tbody');
            let row = "";
            data.data.forEach((element, idx) => {
                const newRow = `
                <tr>
                <td>${++idx}</td>
                <td>${element.kode_kelas}</td>
                <td>${element.nama_kelas}</td>
                <td>
                    <button onclick="deleteData(${element.id})">Delete</button>
                    <button onclick="updateData(${element.id})">Update</button>
                </td>
                </tr>
            `;
            row += newRow;
            });
            tblBody.innerHTML = row
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
@endsection