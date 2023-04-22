@extends('layouts.dashboard')
@section('head')
<link href="{{ asset('/css/modal.css') }}" rel="stylesheet">
@endsection
@section('title', 'Dashboard')
@section('content')
<div class="title-content">
    
</div>
<div class="container">
    <div class="alert-box">

    </div>
    <form class="store">
        <label>Waktu Mengajar<span style="color:red">*</span></label> <br>
        <input type="text" name="waktu_awal"> - <input type="text" name="waktu_akhir"><br>
        <label>Hari<span style="color:red">*</span></label> <br>
        <input type="text" name="id_hari">
        <br>
        <br>
        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
        <input type="submit" onclick="submitForm()">
    </form>

    <table id="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Waktu</th>
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

    const url = window.location.origin+"/api/jadwal_mengajar";

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
                <td>${++idx}</td>
                <td>${element.nama_hari}</td>
                <td>${element.waktu_awal} - ${element.waktu_akhir}</td>
                <td></td>
                <td></td>
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

    function submitForm() {
        event.preventDefault(); // prevent form submission
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const form = document.querySelector('form.store');
        const formData = new FormData(form);

        fetch(url, {
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(getData)
        .catch(error => console.error(error));
    }

</script>
@endsection