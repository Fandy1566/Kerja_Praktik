@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Mata Pelajaran'])
<div class="title-content">
    
</div>
<div class="card">
    <form class="store">
        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
        <label>Nama</label> <br>
        <input type="text" name="nama_mata_pelajaran"> <br>
        <label>Banyak per minggu</label> <br>
        <input type="text" name="banyak"> <br>
        <label>Tingkat</label>
        <select name="tingkat">
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
        </select>
        <br><br>
        <input type="submit" value="Tambah" onclick="submitForm()">
    </form>
</div>
<div class="card">
    <table id="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>tingkat</th>
                <th>Banyak</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>
    window.onload = () => {
        getData();
    }
    const url = window.location.origin+"/api/mata_pelajaran";

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
                <td>${element.kode_mata_pelajaran}</td>
                <td>${element.nama_mata_pelajaran}</td>
                <td>${element.tingkat}</td>
                <td>${element.banyak}</td>
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