@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="title-card">
    <div class="title-content">
        
    </div>
</div>
<div class="card">
    <form class="store">
        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
        <h2>Form</h2>
        <label>Nama<span style="color:red">*</span></label> <br>
        <input type="text" name="nama_guru">
        <br>
        <label>Banyak Waktu Per Minggu</label>
        <input type="number" name="banyak">
        <label>Mata Pelajaran<span style="color:red">*</span></label> <br>
        <select name="id_mata_pelajaran[]" multiple onclick="toggleOptionSelection(event)">
            <option>123</option>
            <option>456</option>
            <option>789</option>
        </select>
        {{-- <div class="select-btn">
            <span class="select-btn-text">
                Pilih Mata Pelajaran
            </span>
            <span class="select-btn-arrow">
                <img src="{{ asset('arrow-down.svg')}}" alt="">
            </span>
        </div>
        <div class="list-select hide">
            <ul>
                @php
                    $list = ["IPA","IPS","MTK"]
                @endphp
                @foreach ($list as $item)
                <li class="item">
                    <span class="select-checkbox">
                        <img src="{{ asset('check.svg')}}" alt="" class="check-icon">
                    </span>
                    <span class="item-text">{{$item}}</span>
                </li>               
                @endforeach
            </ul>
        </div> --}}
        <br>
        <input type="submit" value="Submit" onclick="submitForm()">
    </form>
</div>
<div class="card">
    <div class="button">
        <button type="submit"></button>
    </div>
    <table id="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Mata Pelajaran yang diajar</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>

</div>
@endsection
@section('script')
<script>
    
    window.onload = async () => {
        await getData();
    }
    const url = window.location.origin+"/api/guru";

    const selectElement = document.querySelector('select');
    const selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
    console.log(selectedValues);

    function toggleOptionSelection(event) {
        if (event.target.tagName === 'OPTION') {
            event.target.selected = !event.target.selected;
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