@extends('layouts.dashboard')
@section('head')
<script src="{{ asset('js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<script src="{{ asset('js/select2.min.js') }}"></script>
@endsection
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Guru'])
<div id="form-layout" class="card m-20" style="width: 100%">
    <div class="title-card">
        Input Guru
    </div>
    <div class="form-area">
        <form class="store">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="left-side-form">
                <label>Nama Guru</label><br>
                <input type="text" name="nama_guru" placeholder="Masukkan nama guru.."><br>
                <label>Mata Pelajaran</label> <br>
                <select id="select-mapel" name="mata_pelajaran[]" multiple="multiple" placeholder="Test" style="width: 100%">
                    
                </select>
                <br>
            </div>
            <div class="right-side-form">
                {{-- <label>Kelas</label><br>
                <label for="">Kelas VII</label><input type="number" name="kelas_7">
                <label for="">Kelas VIII</label><input type="number" name="kelas_8">
                <label for="">Kelas IX</label><input type="number" name="kelas_9"><br> --}}
                <label>Kategori</label><br>
                <input type="radio" name="kategori" id="" checked value="1"><label for="">Guru Tetap</label>
                <input type="radio" name="kategori" id="" value="0"><label for="">Guru Honorer</label><br>
            </div>
            <input class="clickable form-button title-card" type="submit" value="Submit" onclick="submitForm()">
        </form>
    </div>
</div>
<div class="card m-32">
    <div class="title-card">
        Guru
    </div>
    <input class="search" type="text" name="" id="" placeholder="Cari Guru">
    <button class="clickable">Cari</button>
    <button class="clickable">Import</button>
    <button class="clickable">Export</button>
    <button class="clickable" onclick="deleteSelected('guru')">Delete</button>
    <div class="table-container">
        <table id="tbl">
            <thead>
                <tr>
                    <th><input type="checkbox" onchange="checkAll()"></th>
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
            select.innerHTML = options;
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
                        <td class="center-text"><input type="checkbox" value="${element.id}"></td>
                        <td>${element.id}</td>
                        <td>${element.kode_guru}</td>
                        <td>${element.nama_guru}</td>
                        <td></td>
                        <td>
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