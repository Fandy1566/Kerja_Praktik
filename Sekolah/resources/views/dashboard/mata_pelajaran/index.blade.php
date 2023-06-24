@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Mata Pelajaran'])
<div class="message">
    
</div>
@can('Admin')
<div id="form-layout" class="card m-20" style="width: 55%">
    <div class="title-card">
        Input Mata Pelajaran
    </div>
    <div class="form-area">
        <form class="store flex-row">
            <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
            <div class="left-side-form">
                <div class="pengaturan-username">
                    <label>Mata Pelajaran</label>
                    <input type="text" name="nama_mata_pelajaran" placeholder="Masukkan nama Mata Pelajaran..">
                </div>
                {{-- <div class="pengaturan-username" style="margin-top: 12px;">
                    <label>Total Jam</label>
                    <input type="text" name="banyak" placeholder="Masukkan Total Jam..">
                </div> --}}
            </div>
            {{-- <div class="right-side-form" style="margin-left: 32px;">
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
            </div> --}}
            <input class="clickable form-button title-card" type="submit" value="Tambah" onclick="submitForm()">
        </form>
    </div>
</div>
@endcan

<div class="card m-32">
    <div class="title-card">
        Mata Pelajaran
    </div>
    <div class="table-top" style="margin-left: 12px;">
        <input data-col-name="nama_mata_pelajaran" class="search" style="width: 70%;" type="text" onkeyup="renderTable()" placeholder="Cari Mata Pelajaran" id="search">
        <button class="clickable cari" onclick="renderTable()">Cari</button>
        @can('Admin')
        <button class="clickable delete" onclick="deleteSelected('mata_pelajaran')">Delete</button>
        @endcan
    </div>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px;">
        <table id="tbl">
            <thead>
                <tr>
                    <th class="freeze-vertical"><input type="checkbox" onchange="checkAll()"></th>
                    <th class="freeze-vertical">ID Mata Pelajaran</th>
                    <th class="freeze-vertical">Mata Pelajaran</th>
                    {{-- <th>Total Jam / Minggu</th> --}}
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
    const url = window.location.origin+"/api/mata_pelajaran";

    window.onload = () => {
        getData();
    }

    document.querySelector('#nextButton').addEventListener('click', nextPage, false);
    document.querySelector('#prevButton').addEventListener('click', previousPage, false);

    if (isAdmin) {
        const formArea = document.querySelector('#form-layout');
        const formStore = formArea.innerHTML;

        function Edit(obj) {
            formArea.innerHTML = "";
            const formEdit = `
            <div class="title-card">
            Input Mata Pelajaran
            </div>
            <div class="form-area">
                <form class="edit flex-row">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                    <div class="left-side-form">
                        <div class="pengaturan-username">
                            <label>Mata Pelajaran</label>
                            <input type="text" name="nama_mata_pelajaran" placeholder="Masukkan nama Mata Pelajaran.." value ="${obj.nama_mata_pelajaran}">
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
    }

    function renderTable() {
        const tblBody = document.querySelector('#tbl tbody');
        const input = document.getElementById("search");
        let filter = input.value.toUpperCase();
        let result = '';
        checkIfOffset();

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
                <td class="center-text"><input type="checkbox" value="${element.id}"></td>
                <td>${element.id}</td>
                <td>${element.nama_mata_pelajaran}</td>
                <td>
                    ${isAdmin ? `<button onclick='Edit(${JSON.stringify(element)})'>Edit</button>` : ''}
                </td>
            </tr>
            `;
            renderPagination();
        });
        tblBody.innerHTML = result;
    }
</script>
@endsection