@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Mata Pelajaran'])
<div id="form-layout" class="card m-20" style="width: 600px">
    <div class="title-card">
        Input Mata Pelajaran
    </div>
    <div class="form-area">
        <form class="store">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="left-side-form">
                <label>Mata Pelajaran</label><br>
                <input type="text" name="nama_mata_pelajaran" placeholder="Masukkan nama Mata Pelajaran.."><br>
                <label>Total Jam</label> <br>
                <input type="text" name="banyak" placeholder="Masukkan Total Jam.."><br>
                <br>
            </div>
            <div class="right-side-form">
                <label>Kategori</label><br>
                <input type="checkbox" name="tingkat[]" checked value=7><label for="">Kelas VII</label><br>
                <input type="checkbox" name="tingkat[]" checked value=8><label for="">Kelas VIII</label><br>
                <input type="checkbox" name="tingkat[]" checked value=9><label for="">Kelas IX</label><br>
            </div>
            <input class="clickable form-button title-card" type="submit" value="Tambah" onclick="submitForm()">
        </form>
    </div>
</div>
<div class="card m-32">
    <div class="title-card">
        Mata Pelajaran
    </div>
    <div class="table-container">
        <table id="tbl">
            <thead>
                <tr>
                    <th><input type="checkbox" onchange="checkAll(this)"></th>
                    <th>ID Mata Pelajaran</th>
                    <th>Mata Pelajaran</th>
                    <th>Total Jam / Minggu</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
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
                    <td class="center-text"><input type="checkbox"></td>
                    <td>${element.id}</td>
                    <td>${element.nama_mata_pelajaran}</td>
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