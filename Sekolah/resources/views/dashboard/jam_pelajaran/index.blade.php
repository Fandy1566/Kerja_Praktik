@extends('layouts.dashboard')
@section('head')
<link href="{{ asset('/css/modal.css') }}" rel="stylesheet">
@endsection
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jam Pelajaran'])
@can('Admin')
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
@endcan

<div class="card m-32">
    <div class="title-card">
        Jam Pelajaran
    </div>
    <div class="table-top" style="margin-left: 12px;">
        <input data-col-name="nama_hari" class="search" style="width: 70%;" type="text" onkeyup="renderTable('nama_hari')" placeholder="Cari Hari.." id="search">
        <button class="clickable cari" onclick="renderTable()">Cari</button>
        <button class="clickable import">Import</button>
        <button class="clickable export">Export</button>
        <button class="clickable delete" onclick="deleteSelected('guru')">Delete</button>
    </div>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px;">
        <table id="tbl">
            <thead>
                <tr>
                    <th><input type="checkbox" onchange="checkAll(this)"></th>
                    {{-- <th>ID Jam Pelajaran</th> --}}
                    <th>Hari</th>
                    <th>Waktu Pelajaran</th>
                    @can('Admin')
                    <th>Edit</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="page">
        <button class="clickable" id="prevButton" ><img src="{{asset('image/icon/back.svg')}}" alt=""></button>
        <div id="pagination" class="flex-row" style = "font-size: 12px; color: #587693; font-weight:500; align-items: center; gap: 12px;">
        </div>
        <button class="clickable" id="nextButton"><img src="{{asset('image/icon/next.svg')}}" alt=""></button>
    </div> 
</div>
@endsection
@section('script')
<script>
    const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};

    document.querySelector('#nextButton').addEventListener('click', nextPage, false);
    document.querySelector('#prevButton').addEventListener('click', previousPage, false);

    if (isAdmin) {
        const formArea = document.querySelector('#form-layout');
        const formStore = formArea.innerHTML;

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
        
    }
    const url = window.location.origin+"/api/jadwal_mengajar";

    window.onload = () => {
        getData();
    }

    function renderTable() {
        const tblBody = document.querySelector('#tbl tbody');
        const input = document.getElementById("search");
        let filter = input.value.toUpperCase();
        let result = '';
        checkIfOffset()

        let data = table_data;

        if (filter !=="" || filter !== null) {
            data = table_data.filter(item => {
                const value = item[input.dataset.colName].toUpperCase();
                return value.includes(filter);
            })
        }
            
        data.filter((row, index) => {
            let start = (curPage - 1) * pageSize;
            let end = curPage * pageSize;
            if (index >= start && index < end) return true;
        }).forEach(element => {
            result += `
            <tr>
                <td class="center-text"><input type="checkbox" nama="id_guru[]" value="${element.id}"></td>
                <td id="nama_hari">${element.nama_hari}</td>
                <td id="waktu">${element.waktu_awal} - ${element.waktu_akhir}</td>
                <td>
                    ${isAdmin ? `<button onclick='Edit(${JSON.stringify(element)})'>Edit</button>` : ''}
                </td>
            </tr>
            `;
            renderPagination();
        });

        tblBody.innerHTML = result;
    }

    // insertAdjacentHTML
</script>
@endsection