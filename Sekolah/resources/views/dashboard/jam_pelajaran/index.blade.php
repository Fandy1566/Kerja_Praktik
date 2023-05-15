@extends('layouts.dashboard')
@section('head')
<link href="{{ asset('/css/modal.css') }}" rel="stylesheet">
@endsection
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jam Pelajaran'])
<div id="form-layout" class="card m-20" style="width: 55%">
    <div class="title-card">
        Input Jam Pelajaran
    </div>
    <div class="form-area">
        <form class="store">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="left-side-form">
                <div class="pengaturan-username">
                    <label>Hari</label>
                    <select name="id_hari" id="hari">
                    <option value="" style="display: none;">Pilih Hari</option>
                    @foreach ($hari as $item)
                        <option value="{{$item->id}}">{{$item->nama_hari}}</option>
                    @endforeach
                </select>
                </div>
                <div class="pengaturan-username" style="margin-top: 12px;">
                    <label>Jam Pembelajaran</label>
                    <div class="" style="display: flex;">
                    <input type="time" name="waktu_awal" style="margin-right: 12px;"> - <input type="time" name="waktu_akhir" style="margin-left: 12px;">
                    </div>
                </div>
            </div>
            <input class="clickable form-button title-card" type="submit" value="Tambah" onclick="submitForm()">
        </form>
    </div>
</div>

<div class="card m-32">
    <div class="title-card">
        Jam Pelajaran
    </div>
    <div class="table-top" style="margin-left: 12px;">
        <input class="search" style="width: 70%;" type="text" onkeyup="search('nama_hari')" placeholder="Cari Hari.." id="search">
        <button class="clickable-cari" onclick="search('nama_hari')">Cari</button>
        <button class="clickable-import">Import</button>
        <button class="clickable-export">Export</button>
        <button class="clickable-delete" onclick="deleteSelected('guru')">Delete</button>
    </div>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px;">
        <table id="tbl">
            <thead>
                <tr>
                    <th><input type="checkbox" onchange="checkAll(this)"></th>
                    {{-- <th>ID Jam Pelajaran</th> --}}
                    <th>Hari</th>
                    <th>Waktu Pelajaran</th>
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

    const url = window.location.origin+"/api/jadwal_mengajar";
    const formArea = document.querySelector('#form-layout');
    const formStore = formArea.innerHTML;

    window.onload = () => {
        getData();
    }

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
                    <td class="center-text"><input type="checkbox" nama="id_guru[]" value="${element.id}"></td>
                    <td id="nama_hari">${element.nama_hari}</td>
                    <td id="waktu">${element.waktu_awal} - ${element.waktu_akhir}</td>
                    <td>
                        <button onclick='Edit(${JSON.stringify(element)})'>Edit</button>
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

    function Edit(obj) {
        formArea.innerHTML = "";
        const formEdit = `
        <div class="title-card" style="padding-inline: 10px;">
            Edit Jam Pelajaran
        </div>
        <div class="form-area">
            <form class="edit">
                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                <div class="left-side-form">
                    <label>Hari</label><br>
                    <select name="id_hari" id="hari">
                        <option value="${obj.id}"style="display: none;">${obj.nama_hari}</option>
                        @foreach ($hari as $item)
                            <option value="{{$item->id}}">{{$item->nama_hari}}</option>
                        @endforeach
                    </select><br>
                    <label>Jam Pelajaran</label><br>
                    <input type="time" name="waktu_awal" value="${obj.waktu_awal}"> - <input type="time" name="waktu_akhir" value="${obj.waktu_akhir}">
                    <br>
                </div>
                <input class="clickable form-button title-card" type="submit" value="Simpan" onclick="updateData(${obj.id})">
            </form>
        </div>
        `;
        document.querySelector('.content').scrollTo({
            top: 0,
            behavior: "smooth"
        });
        formArea.innerHTML = formEdit;
    }

    function showFormStore() {
        formArea.innerHTML = formStore;
    }

    // insertAdjacentHTML
</script>
@endsection