@extends('layouts.dashboard')
@section('head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Guru'])
<div class="card m-20">
    <div class="title-card">
        Input Guru
    </div>
    <form class="store">
        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
        <div class="left-side-form">
            <label>Nama Guru</label><br>
            <input type="text" name="nama_guru" placeholder="Masukkan nama guru.."><br>
            <label>Mata Pelajaran</label> <br>
            <select id="select-mapel" name="mata_pelajaran[]">
                <option value="">Pilih Mata Pelajaran</option>
            </select>
            <br>
        </div>
        <div class="right-side-form">
            <label>Kelas</label><br>
            <input type="checkbox" name="id_kelas[]" id="" value="7"><label for="">Kelas VII</label>
            <input type="checkbox" name="id_kelas[]" id="" value="8"><label for="">Kelas VIII</label>
            <input type="checkbox" name="id_kelas[]" id="" value="9"><label for="">Kelas IX</label><br>
            <label>Kategori</label><br>
            <input type="checkbox" name="kategori" id=""><label for="">Guru Tetap</label>
            <input type="checkbox" name="kategori" id=""><label for="">Guru Honorer</label><br>
            
        </div>
        <input class="clickable form-button title-card" type="submit" value="Submit" onclick="submitForm()">
    </form>
</div>
<div class="card m-32">
    <div class="title-card">
        Guru
    </div>
    <input class="search" type="text" name="" id="" placeholder="Cari Guru">
    <button class="clickable">Cari</button>
    <button class="clickable">Import</button>
    <button class="clickable">Export</button>
    <button class="clickable">Delete</button>
    <table id="tbl">
        <thead>
            <tr>
                <th><input type="checkbox" id="check-all"></th>
                <th>ID  Guru</th>
                <th>Nama Guru</th>
                <th>Mata Pelajaran</th>
                <th>Status</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
      $('#select-mapel').select2();
    });
    
    window.addEventListener('load', function() {
        getData();
        getMapel();
    });

    const url = window.location.origin+"/api/guru";

    const selectElement = document.querySelector('select');
    const selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
    console.log(selectedValues);

    function toggleOptionSelection(event) {
        if (event.target.tagName === 'OPTION') {
            event.target.selected = !event.target.selected;
        }
    }

    async function getMapel() {
        try {
            const response = await fetch(window.location.origin+"/api/mata_pelajaran");
            const data = await response.json();
            const select = document.querySelector('#select-mapel');
            let options = "";
            data.data.forEach(element => {
                const newOption = `
                    <option value="${element.id}">${element.nama_mata_pelajaran}</option>
                `;
                options += newOption;
            });
            tblBody.innerHTML = options;
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function getData() {
        try {
            const response = await fetch(url);
            const data = await response.json();
            const tblBody = document.querySelector('#tbl tbody');
            let row = "";
            data.data.forEach((element, idx) => {
                const newRow = `
                    <tr>
                    <td>${++idx}</td>
                    <td>${element.kode_guru}</td>
                    <td>${element.nama_guru}</td>
                    <td></td>
                    <td>
                        <button class="delete-button" onclick="deleteData(${element.id})">Delete</button>
                        <button onclick="updateData(${element.id})">Update</button>
                    </td>
                    </tr>
                `;
                row += newRow;
            });
            tblBody.innerHTML = row;
        } catch (error) {
            console.error('Error:', error);
        }
    }

</script>
@endsection