@extends('layouts.dashboard')
@section('head')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<script src="{{ asset('js/select2.min.js') }}"></script>
@endsection
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Guru'])
@can('Admin')
<div class="message">

</div>

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
                    <input type="radio" name="role" id="" checked value="1">
                    <label for="" style="margin-left: 12px;">Kepala Sekolah</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="role" id="" checked value="2">
                    <label for="" style="margin-left: 12px;">Wakil Kepala Sekolah</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="role" id="" value="3">
                    <label for="" style="margin-left: 12px;">Admin</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="role" id="" value="4">
                    <label for="" style="margin-left: 12px;">Guru Tetap</label>
                </div>
                <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                    <input type="radio" name="role" id="" value="5">
                    <label for="" style="margin-left: 12px;">Guru Honorer</label>
                </div>
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
    <div class="table-top" style="margin-left: 12px; " >
        <input data-col-name="name" class="search" style="width: 70%;" type="text" onkeyup="renderTable('nama_guru')" placeholder="Cari Guru" id="search">
        <button class="clickable cari" onclick="renderTable('nama_guru')">Cari</button>
        @can('Admin')
        <button class="clickable delete" onclick="deleteSelected('guru')">Delete</button>
        @endcan
    </div>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px;">
        <table id="tbl">
            <thead>
                <tr>
                    <th class="freeze-vertical"style="width: 5%"><input type="checkbox" onchange="checkAll()"></th>
                    <th class="clickable prevent-select freeze-vertical" data-sort="id">ID  Guru</th>
                    <th class="clickable prevent-select freeze-vertical" data-sort="name">Nama Guru</th>
                    <th class="clickable prevent-select freeze-vertical" data-sort="guru_detail">Kelas</th>
                    <th class="clickable prevent-select freeze-vertical" data-sort="is_guru_tetap">Status</th>
                    @can('Admin')
                    <th class="freeze-vertical">Edit</th>
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
            <div class="title-card">
                Update Guru
            </div>
            <div class="form-area">
                <form class="edit flex-row">
                    <div class="left-side-form" >
                        <div class="pengaturan-username">
                            <label>Nama Guru</label>
                            <input type="text" name="nama_guru" placeholder="Masukkan nama guru.."  value ="${obj.name}">
                        </div>
                        <div class="pengaturan-username" style="margin-top: 12px;">
                            <label>Kelas</label>
                            <select id="select-multiple" name="kelas[]" multiple="multiple" placeholder="Masukan mata pelajaran..">
                                <option value="7" ${obj.is_guru_kelas_7 ? 'selected' : ''}>Kelas 7</option>
                                <option value="8" ${obj.is_guru_kelas_8 ? 'selected' : ''}>Kelas 8</option>
                                <option value="9" ${obj.is_guru_kelas_9 ? 'selected' : ''}>Kelas 9</option>
                            </select>
                        </div>
                    </div>
                    <div class="right-side-form" style="margin-left: 32px;">
                        <div class="pengaturan-rb">
                            <label>Kategori</label>
                            <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                                <input type="radio" name="role" id="" checked value="1">
                                <label for="" style="margin-left: 12px;">Kepala Sekolah</label>
                            </div>
                            <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                                <input type="radio" name="role" id="" value="2">
                                <label for="" style="margin-left: 12px;">Admin</label>
                            </div>
                            <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                                <input type="radio" name="role" id="" value="3">
                                <label for="" style="margin-left: 12px;">Guru Tetap</label>
                            </div>
                            <div class="" style="display: flex; align-items: center; margin-top: 12px;">
                                <input type="radio" name="role" id="" value="4">
                                <label for="" style="margin-left: 12px;">Guru Honorer</label>
                            </div>
                        </div>
                    </div>
                    <input class="clickable form-button title-card" type="submit" value="Edit" onclick="updateData(${obj.id})">
                </form>
            </div>
            `;
            document.querySelector('.content').scrollTo({
                top: 0,
                behavior: "smooth"
            });
            formArea.innerHTML = formEdit;
            $('#select-multiple').select2({
                placeholder: "Pilih Kelas.."
            });
        }

        function showFormStore() {
            formArea.innerHTML = formStore;
            $('#select-multiple').select2({
                placeholder: "Pilih Kelas.."
            });
        }
        
    }

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

        let data = table_data;

        if (filter !=="" || filter !== null) {
            data = table_data.filter(item => {
                const value = item[input.dataset.colName].toUpperCase();
                return value.includes(filter);
            });
        }
        
        data = table_data.filter(item => {
            if (item.role !== 6) {
                return item
            }
        });

        data.filter((row, index) => {
                let start = (curPage - 1) * pageSize;
                let end = curPage * pageSize;
                if (index >= start && index < end) return true;
            }).forEach(element => {
                result += `
                <tr>
                    <td class="center-text"><input type="checkbox" value="${element.id}"></td>
                    <td>${element.id}</td>
                    <td id="nama_guru">${element.name}</td>
                    <td>
                        ${[
                            element.is_guru_kelas_7 ? '7' : '',
                            element.is_guru_kelas_8 ? '8' : '',
                            element.is_guru_kelas_9 ? '9' : ''
                        ].filter(Boolean).join(', ')}
                    </td>
                    <td id="kode_guru">${getRole(element.role)}</td>
                    <td>
                        ${isAdmin ? `<button onclick='Edit(${JSON.stringify(element)})'>Edit</button>` : ''}
                    </td>
                </tr>
                `;
            });
            renderPagination();

        tblBody.innerHTML = result;
    }

    window.addEventListener('load', function() {
        getData();
    });

    function getRole(role) {
        switch (role) {
            case 1:
                return `
                <div class="status-guru-container kepala-sekolah">
                    Kepala Sekolah
                </div>
                `
                break;
            case 2:
                return `
                <div class="status-guru-container kepala-sekolah">
                    Wakil Kepala Sekolah
                </div>
                `
                break;
            case 3:
                return `
                <div class="status-guru-container admin">
                    Admin
                </div>
                `
                break;
            case 4:
                return `
                <div class="status-guru-container guru-tetap">
                    Guru Tetap
                </div>
                `
                break;
            case 5:
                return `
                <div class="status-guru-container guru-honorer">
                    Guru Honorer
                </div>
                `
                break;
        
            default:
                return ``
                break;
        }
    }

    const url = window.location.origin+"/api/guru";

</script>
@endsection