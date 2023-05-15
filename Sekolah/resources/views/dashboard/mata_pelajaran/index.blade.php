@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Mata Pelajaran'])
<div id="form-layout" class="card m-20" style="width: 55%">
    <div class="title-card">
        Input Mata Pelajaran
    </div>
    <div class="form-area">
        <form class="store">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="left-side-form">
                <div class="pengaturan-username">
                    <label>Mata Pelajaran</label>
                    <input type="text" name="nama_mata_pelajaran" placeholder="Masukkan nama Mata Pelajaran..">
                </div>
                <div class="pengaturan-username" style="margin-top: 12px;">
                    <label>Total Jam</label>
                    <input type="text" name="banyak" placeholder="Masukkan Total Jam..">
                </div>
            </div>
            <div class="right-side-form" style="margin-left: 32px;">
                <div class="pengaturan-rb">
                    <label>Kategori</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="Checkbox" name="tingkat" id="" checked value="7">
                    <label for="" style="margin-left: 12px;">Kelas VII</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="Checkbox" name="tingkat" id="" value="8">
                    <label for="" style="margin-left: 12px;">Kelas VIII</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="Checkbox" name="tingkat" id="" value="9">
                    <label for="" style="margin-left: 12px;">Kelas IX</label>
                </div>
            </div>
            <input class="clickable form-button title-card" type="submit" value="Tambah" onclick="submitForm()">
        </form>
    </div>
</div>

<div class="card m-32">
    <div class="title-card">
        Mata Pelajaran
    </div>
    <div class="table-top" style="margin-left: 12px;">
        <input class="search" style="width: 70%;" type="text" onkeyup="search('nama_guru')" placeholder="Cari Mata Pelajaran" id="search">
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

@endsection
@section('script')
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
                    <td class="center-text"><input type="checkbox" value="${element.id}"></td>
                    <td>${element.id}</td>
                    <td>${element.nama_mata_pelajaran} (${(() => {
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
                    })()})</td>
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