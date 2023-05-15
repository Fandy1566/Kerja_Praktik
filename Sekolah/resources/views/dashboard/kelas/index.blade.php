@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Kelas'])
<div id="form-layout" class="card m-20" style="width: 55%">
    <div class="title-card">
        Input Kelas
    </div>
    <div class="form-area">
        <form class="store" style="flex-direction: column;">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="pengaturan-rb">
                    <label>Tambah Kelas</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="tingkat" id="" checked value="7">
                    <label for="" style="margin-left: 12px;">Kelas VII</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="tingkat" id="" value="8">
                    <label for="" style="margin-left: 12px;">Kelas VIII</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="tingkat" id="" value="9">
                    <label for="" style="margin-left: 12px;">Kelas IX</label>
                </div>
            <input class="clickable form-button title-card" type="submit" value="Submit" onclick="submitForm()">
        </form>
    </div>
</div>

<div class="card m-32">
    <div class="title-card">
        Guru
    </div>
    <div class="table-top" style="margin-left: 12px;">
        <input class="search" style="width: 70%;" type="text" onkeyup="search('nama_kelas')" placeholder="Cari Kelas" id="search">
        <button class="clickable-cari" onclick="search('nama_kelas')">Cari</button>
        <button class="clickable-import">Import</button>
        <button class="clickable-export">Export</button>
        <button class="clickable-delete" onclick="deleteSelected('guru')">Delete</button>
    </div>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px;">
        <table id="tbl">
            <thead>
                <tr>
                    <th><input type="checkbox" onchange="checkAll()"></th>
                    <th>ID Kelas</th>
                    <th>Kelas</th>
                    <th>Lantai</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
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
                <td class="center-text"><input type="checkbox"></td>
                <td>${++idx}</td>
                <td id="nama_kelas">${element.nama_kelas}</td>
                <td></td>
                <td>
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