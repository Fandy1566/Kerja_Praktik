@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Kelas'])
@can('Admin')
    <div id="form-layout" class="card m-20" style="width: 55%">
        <div class="title-card">
            Input Kelas
        </div>
        <div class="form-area">
            <form class="store" style="display: flex; flex-direction: row;">
                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                <div class="left-side-form">
                    <label>Tambah Kelas</label>
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
                </div>
                <div class="right-side-form flex-column" style="margin-left: 64px; margin-top: 4px;">
                    <label for="" style="margin-bottom: 12px;">Lantai Kelas</label>
                    <input type="number" name="lantai" id="" min="1" placeholder="Masukan Lantai.." value="1">
                </div>
                <input class="clickable form-button title-card" type="submit" value="Tambah" onclick="submitForm()">
            </form>
        </div>
    </div>
@endcan

<div class="card m-32">
    <div class="title-card">
        Guru
    </div>
    <div class="table-top" style="margin-left: 12px;">
        <input data-col-name="nama_kelas" class="search" style="width: 70%;" type="text" onkeyup="renderTable()" placeholder="Cari Kelas" id="search">
        <button class="clickable cari" onclick="renderTable()">Cari</button>
        <button class="clickable import">Import</button>
        <button class="clickable export">Export</button>
        <button class="clickable delete" onclick="deleteSelected('guru')">Delete</button>
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
            <div class="title-card">
            Input Kelas
            </div>
            <div class="form-area">
                <form class="edit" style="display: flex; flex-direction: row;">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                    <div class="left-side-form">
                        <label>Tambah Kelas</label>
                            <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                                <input type="radio" name="tingkat" id="" ${obj.tingkat == 7?'checked':''} value="7">
                                <label for="" style="margin-left: 12px;">Kelas VII</label>
                            </div>
                            <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                                <input type="radio" name="tingkat" id="" ${obj.tingkat == 7?'checked':''} value="8">
                                <label for="" style="margin-left: 12px;">Kelas VIII</label>
                            </div>
                            <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                                <input type="radio" name="tingkat" id="" ${obj.tingkat == 7?'checked':''} value="9">
                                <label for="" style="margin-left: 12px;">Kelas IX</label>
                            </div>
                    </div>
                    <div class="right-side-form flex-column" style="margin-left: 64px; margin-top: 4px;">
                        <label for="" style="margin-bottom: 12px;">Lantai Kelas</label>
                        <input type="number" name="lantai" id="" min="1" placeholder="Masukan Lantai.." value="${obj.lantai}">
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

    window.onload = () => {
        getData();
    }
    const url = window.location.origin+"/api/kelas";

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
            });
        }

        data.filter((row, index) => {
            let start = (curPage - 1) * pageSize;
            let end = curPage * pageSize;
            if (index >= start && index < end) return true;
        }).forEach(element => {
            result += `
            <tr>
                <td class="center-text"><input type="checkbox"></td>
                <td>${element.id}</td>
                <td id="nama_kelas">${element.nama_kelas}</td>
                <td id="lantai">${element.lantai}</td>
                <td>
                <button onclick='Edit(${JSON.stringify(element)})'>Edit</button>
                </td>
            </tr>
            `;
            renderPagination();
        });

        tblBody.innerHTML = result;
    }

</script>
@endsection