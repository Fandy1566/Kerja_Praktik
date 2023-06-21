@extends('layouts.dashboard')
@section('content')
@include('layouts.header', ['title' => 'Pengaturan'])

@if(Session::has('message'))
<div style="display:flex; justify-content: space-between ; background-color: #A5F2B1;border: 2px solid #479D39; color:#479D39; border-radius:5px; width:100%; height:50px; margin-top: 16px">
    <div style="align-self:center; margin-left:10px">
    {{ Session::get('message') }}
    </div>
    <span class="clickable" style="margin-right:10px; margin-top:10px" onclick="document.querySelector('.message').innerHTML =''">&#10006</span>
</div>
@endif


<div class="modal hidden">
</div>
<div class="pengaturan-top flex-row" style="gap:20px">
    <div id="form-layout" class="card m-20" style="width: 700px">
        <div class="title-card">
            Pengaturan Akun
        </div>
        <div class="flex-row" style="margin-top: 15px; margin-left: 12px; gap:20px; align-items: center;">
            <div class="logo-smp" style="margin-top: 8px;"><img src="{{asset('image/picture/Logo.png')}}" alt=""></div>
            <div class="center-text button-secondary">
                Upload Foto Profil
            </div>
            <div class="title-card2">
                Hapus
            </div>
        </div>
        <div class="form-area" style="margin-left: 12px;">
            <form style="padding-bottom: 40px" action="{{ route('user.edit', ['id' => Auth::user()->id]) }}" method="POST">
            @csrf
            @method('patch')
            <input type="hidden" name="_method" value="PATCH">
                <div class="flex-row" style="margin-top: 24px; gap:20px; align-items: center;">
                    <div class="pengaturan-username">
                        <label for="">Email</label>
                        <input type="email" placeholder="Masukan Email .." name="email">
                    </div>
                    <div class="pengaturan-username">
                        <label for="">password</label>
                        <input type="password" placeholder="Masukan password.." name="password"
                        style="border-radius: 10px;
                        border: 0.5px solid #587693;
                        width: 275px;
                        height: 30px;
                        padding-left: 5px;
                        color: #345678;
                        font-weight: 500;" minlength="8">
                    </div>
                </div>
                <input class="clickable form-button title-card" type="submit" value="Simpan">
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};

    if (isAdmin) {
        const url = window.location.origin+"/api/reset";
        function modalResetToggle(name = null) {
            const modal = document.querySelector('.modal');
            modal.classList.toggle('hidden');
            modal.innerHTML =`
            <div class="modal-content">
                <h2>Reset <table></table></h2>
                <p>Apakah kamu yakin ingin mereset tabel ini?</p>
                <div class="button">
                    <button id="batal" data-type="close" onclick="modalResetToggle()">Batal</button>
                    <button id="Keluar" data-type="reset" onclick="reset(${name})">Keluar</button>
                </div>
            </div>
            `;
        }
    }

</script>

@endsection