@extends('layouts.dashboard')
@section('head')
<script src="{{ asset('js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<script src="{{ asset('js/select2.min.js') }}"></script>
@endsection
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Guru'])
<div id="form-layout" class="card m-20" style="width: 55%">
    <div class="title-card">
        Input Guru
    </div>
    <div class="form-area">
        <form class="store">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="left-side-form" >
                <div class="pengaturan-username">
                    <label>Nama Guru</label>
                    <input type="text" name="nama_guru" placeholder="Masukkan nama guru..">
                </div>
                <div class="pengaturan-username" style="margin-top: 12px;">
                    <label>Mata Pelajaran</label>
                    <select id="select-multiple" name="id_mata_pelajaran[]" multiple="multiple" placeholder="Masukan mata pelajaran..">
                    </select>
                </div>
            </div>
            <div class="right-side-form" style="margin-left: 32px;">
                {{-- <label>Kelas</label><br>
                <label for="">Kelas VII</label><input type="number" name="kelas_7">
                <label for="">Kelas VIII</label><input type="number" name="kelas_8">
                <label for="">Kelas IX</label><input type="number" name="kelas_9"><br> --}}
                <div class="pengaturan-rb">
                    <label>Kategori</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="is_guru_tetap" id="" checked value="1">
                    <label for="" style="margin-left: 12px;">Guru Tetap</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="is_guru_tetap" id="" value="0">
                    <label for="" style="margin-left: 12px;">Guru Honorer</label>
                </div>
            </div>
            <input class="clickable form-button title-card" type="submit" value="Submit" onclick="submitForm()">
        </form>
    </div>
</div>


<div class="card m-32">
    <div class="title-card">
        Guru
    </div>
    <div class="table-top" style="margin-left: 12px;" >
        <input class="search" style="width: 70%;" type="text" onkeyup="search('nama_guru')" placeholder="Cari Guru" id="search">
        <button class="clickable cari" onclick="search('nama_guru')">Cari</button>
        <button class="clickable import">Import</button>
        <button class="clickable export">Export</button>
        <button class="clickable delete" onclick="deleteSelected('guru')">Delete</button>
    </div>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px;">
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
      $('#select-multiple').select2({
        placeholder: "Pilih Mata Pelajaran.."
      });
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
            const select = document.querySelector('#select-multiple');
            let options = "";
            data.data.forEach(element => {
                const newOption = `
                    <option value="${element.id}">${element.nama_mata_pelajaran} (${(() => {
                        switch (element.tingkat) {
                        case "7":
                            return "VII";
                        case "8":
                            return "VIII";
                        case "9":
                            return "IX";
                        default:
                            return "?";
                    }
                    })()})</option>
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
                        <td id="nama_guru">${element.nama_guru}</td>
                        <td>${element.guru_mata_pelajaran.map(mp => mp.mata_pelajaran.nama_mata_pelajaran).join(', ')}</td>
                        <td id="kode_guru">${element.is_guru_tetap ? 'Guru Tetap': 'Guru Honorer'}</td>
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