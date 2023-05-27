@extends('layouts.dashboard')
@section('head')
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
        <form class="store flex-row">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="left-side-form" >
                <div class="pengaturan-username">
                    <label>Nama Guru</label>
                    <input type="text" name="nama_guru" placeholder="Masukkan nama guru..">
                </div>
                <div class="pengaturan-username" style="margin-top: 12px;">
                    <label>Kelas</label>
                    <select id="select-multiple" name="kelas[]" multiple="multiple" placeholder="Masukan mata pelajaran..">
                        <option value="7">Kelas 7</option>
                        <option value="8">Kelas 8</option>
                        <option value="9">Kelas 9</option>
                    </select>
                </div>
            </div>
            <div class="right-side-form" style="margin-left: 32px;">
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
            <input class="clickable form-button title-card" type="submit" value="Tambah" onclick="submitForm()">
        </form>
    </div>
</div>


<div class="card m-32">
    <div class="title-card">
        Guru
    </div>
    <div class="table-top" style="margin-left: 12px;" >
        <input data-col-name="name" class="search" style="width: 70%;" type="text" onkeyup="renderTable('nama_guru')" placeholder="Cari Guru" id="search">
        <button class="clickable cari" onclick="renderTable('nama_guru')">Cari</button>
        <button class="clickable import">Import</button>
        <button class="clickable export">Export</button>
        <button class="clickable delete" onclick="deleteSelected('guru')">Delete</button>
    </div>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px;">
        <table id="tbl">
            <thead>
                <tr>
                    <th><input type="checkbox" onchange="checkAll()"></th>
                    <th data-sort="id">ID  Guru</th>
                    <th data-sort="name">Nama Guru</th>
                    <th data-sort="guru_detail">Kelas</th>
                    <th data-sort="is_guru_tetap">Status</th>
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

    document.querySelector('#nextButton').addEventListener('click', nextPage, false);
    document.querySelector('#prevButton').addEventListener('click', previousPage, false);

    const formArea = document.querySelector('#form-layout');
    const formStore = formArea.innerHTML;

    $(document).ready(function() {
        $('#select-multiple').select2({
            placeholder: "Pilih Kelas.."
        });
    });

    function renderTable() {
        const tblBody = document.querySelector('#tbl tbody');
        const input = document.getElementById("search");
        let filter = input.value.toUpperCase();
        let result = '';
        checkIfOffset()

        if (filter !=="" || filter !== null) {
            table_data.filter(item => {
                const value = item[input.dataset.colName].toUpperCase();
                return value.includes(filter);
            }).filter((row, index) => {
                let start = (curPage - 1) * pageSize;
                let end = curPage * pageSize;
                if (index >= start && index < end) return true;
            }).forEach(element => {
                result += `
                <tr>
                    <td class="center-text"><input type="checkbox" value="${element.id}"></td>
                    <td>${element.id}</td>
                    <td id="nama_guru">${element.name}</td>
                    <td>${element.guru_detail.map(mp => mp.kelas).join(', ')}</td>
                    <td id="kode_guru">${element.is_guru_tetap ? 'Guru Tetap' : 'Guru Honorer'}</td>
                    <td>
                    <button onclick='Edit(${JSON.stringify(element)})'>Edit</button>
                    </td>
                </tr>
                `;
            });
            renderPagination();
        } else {
            // Render table without filtering
            table_data.filter((row, index) => {
                let start = (curPage - 1) * pageSize;
                let end = curPage * pageSize;
                if (index >= start && index < end) return true;
            }).forEach(element => {
                result += `
                <tr>
                    <td class="center-text"><input type="checkbox" value="${element.id}"></td>
                    <td>${element.id}</td>
                    <td id="nama_guru">${element.name}</td>
                    <td>${element.guru_detail.map(mp => mp.kelas).join(', ')}</td>
                    <td id="kode_guru">${element.is_guru_tetap ? 'Guru Tetap' : 'Guru Honorer'}</td>
                    <td>
                    <button onclick='Edit(${JSON.stringify(element)})'>Edit</button>
                    </td>
                </tr>
                `;
            });
            renderPagination();
        }

        tblBody.innerHTML = result;
    }

    window.addEventListener('load', function() {
        getData();
        // getMapel();
    });

    const url = window.location.origin+"/api/guru";

    // async function getMapel() {
    //     try {
    //         const response = await fetch(window.location.origin+"/api/mata_pelajaran");
    //         const data = await response.json();
    //         const select = document.querySelector('#select-multiple');
    //         let options = "";
    //         data.data.forEach(element => {
    //             const newOption = `
    //                 <option value="${element.id}">${element.nama_mata_pelajaran} (${(() => {
    //                     switch (element.tingkat) {
    //                     case "7":
    //                         return "VII";
    //                     case "8":
    //                         return "VIII";
    //                     case "9":
    //                         return "IX";
    //                     default:
    //                         return "?";
    //                 }
    //                 })()})</option>
    //             `;
    //             options += newOption;
    //         });
    //         select.innerHTML = options;
    //     } catch (error) {
    //         console.error('Error:', error);
    //     }
    // }

    function Edit(obj) {
        formArea.innerHTML = "";
        const formEdit = `
        <div class="title-card">
        Edit Guru
        </div>
        <div class="form-area">
            <form class="edit flex-row">
                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                <div class="left-side-form" >
                    <div class="pengaturan-username">
                        <label>Nama Guru</label>
                        <input type="text" name="nama_guru" placeholder="Masukkan nama guru.." value ="${obj.nama_guru}">
                    </div>
                    <div class="pengaturan-username" style="margin-top: 12px;">
                        <label>Mata Pelajaran</label>
                        <select id="select-multiple" name="id_mata_pelajaran[]" multiple="multiple" placeholder="Masukan mata pelajaran..">
                        </select>
                    </div>
                </div>
                <div class="right-side-form" style="margin-left: 32px;">
                    <div class="pengaturan-rb">
                        <label>Kategori</label>
                    </div>
                    <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                        <input type="radio" name="is_guru_tetap" id="" ${obj.is_guru_tetap == 1?'checked':''} value="1">
                        <label for="" style="margin-left: 12px;">Guru Tetap</label>
                    </div>
                    <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                        <input type="radio" name="is_guru_tetap" id="" ${obj.is_guru_tetap == 0?'checked':''}  value="0">
                        <label for="" style="margin-left: 12px;">Guru Honorer</label>
                    </div>
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

</script>
@endsection