@extends('layouts.dashboard')
@section('content')
@include('layouts.header', ['title' => 'Pengaturan'])
    <div id="form-layout" class="card m-20" style="width: 620px">
        <div class="title-card">
            Pengaturan Akun
        </div>
        <div class="flex-row" style="margin-top: 15px; gap:20px; align-items: center;">
            <div class="logo-smp"><img src="{{asset('image/picture/Logo.png')}}" alt=""></div>
            <div class="center-text button-secondary">
                Upload Foto Profil
            </div>
            <div class="title-card">
                Hapus
            </div>
        </div>
        <div class="form-area">
            <form action="" style="padding-bottom: 40px">
                <div class="flex-row">
                    <div>
                        <label for="">Username</label><br>
                        <input type="text" name="username">
                    </div>
                    <div>
                        <label for="">Email</label><br>
                        <input type="email" name="email">
                    </div>
                </div>
                <input class="clickable form-button title-card" type="submit" value="Tambah" onclick="submitForm()">
            </form>
        </div>
    </div>
@endsection