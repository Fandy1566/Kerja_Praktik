@extends('layouts.dashboard')
@section('content')
@include('layouts.header', ['title' => 'Pengaturan'])
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
            <form style="padding-bottom: 40px">
                <div class="flex-row" style="margin-top: 24px; gap:20px; align-items: center;">
                    <div class="pengaturan-username">
                            <label for="">Username</label>
                            <input type="text" placeholder="Masukan Username.." name="username">
                    </div>
                    <div class="pengaturan-username">
                        <label for="">Email</label>
                        <input type="email" placeholder="Masukan Email .." name="email">
                    </div>
                </div>
                <input class="clickable form-button title-card" type="submit" value="Simpan" onclick="submitForm()">
            </form>
        </div>
    </div>

    <div id="form-layout" class="card m-20" style="width: 400px; height: fit-content">
        <div class="title-card">
            Reset Tabel
        </div>
        <div class="form-area">
            <form style="margin-top: 12px; margin-left: 12px; margin-right:12px; padding-bottom: 40px;">
                <div class="reset-table">
                    Reset Semua Tabel
                    <div class="reset-table-content" style="margin-top: 8px;">
                    Kamu bisa mereset tabel secara permanen dengan menekan tombol reset dibawah ini.
                    </div>
                </div>
                <input class="clickable form-button title-card-reset" type="submit" value="reset" onclick="reset('guru'); reset('jadwal_mengajar'); reset('mata_pelajaran'); reset('user')">
            </form>
        </div>
    </div>
</div>

<div class="grid-container-pengaturan" style="margin-top: 24px">
    <div id="form-layout" class="container card pengaturan-1" style="width: 400px; height: fit-content">
        <div class="title-card">
        Reset Tabel
        </div>
            <div class="form-area reset">
                <div class="reset-table">
                    Reset Tabel Guru
                    <div class="reset-table-content" style="margin-top: 8px;">
                    Kamu bisa mereset tabel Guru secara permanen dengan menekan tombol reset dibawah ini.
                    </div>
                </div>
                <input class="clickable form-button title-card-reset" type="submit" value="reset" onclick="modalResetToggle('guru')">
            </div>
    </div>
    <div id="form-layout" class="container card pengaturan-2" style="width: 400px; height: fit-content">
        <div class="title-card">
        Reset Tabel
        </div>
            <div class="form-area reset">
                <div class="reset-table">
                    Reset Tabel Jam Pembelajaran
                    <div class="reset-table-content" style="margin-top: 8px;">
                    Kamu bisa mereset tabel jam pembelajaran secara permanen dengan menekan tombol reset dibawah ini.
                    </div>
                </div>
                <input class="clickable form-button title-card-reset" type="submit" value="reset" onclick="modalResetToggle('jadwal_mengajar')">
            </div>  
    </div>
    <div id="form-layout" class="container card pengaturan-3" style="width: 400px; height: fit-content">
        <div class="title-card">
        Reset Tabel
        </div>
            <div class="form-area reset">
                <div class="reset-table">
                    Reset Tabel Mata Pelajaran
                    <div class="reset-table-content" style="margin-top: 8px;">
                    Kamu bisa mereset tabel mata pelajaran secara permanen dengan menekan tombol reset dibawah ini.
                    </div>
                </div>
                <input class="clickable form-button title-card-reset" type="submit" value="reset" onclick="modalResetToggle('mata_pelajaran')">
            </div>
    </div>
    <div id="form-layout" class="container card pengaturan-4" style="width: 400px; height: fit-content">
        <div class="title-card">
        Reset Tabel
        </div>
            <div class="form-area reset">
                <div class="reset-table">
                    Reset Tabel User
                    <div class="reset-table-content" style="margin-top: 8px;">
                    Kamu bisa mereset tabel user secara permanen dengan menekan tombol reset dibawah ini.
                    </div>
                </div>
                <input class="clickable form-button title-card-reset" type="submit" value="reset" onclick="modalResetToggle('user')">
            </div>
    </div>

</div>
@endsection

@section('script')

<script>
    const url = window.location.origin+"/api/reset";
    console.log(url);

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
    
    async function reset(name) {
        event.preventDefault(); // prevent form submission
        try {
            const response = await fetch(url+"/"+name, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": "{{ csrf_token() }}"
                },
                method: "delete",
                credentials: "same-origin",
            });
            const data = await response.json();
        } catch (error) {
            console.error(error);
        }
    }
</script>

@endsection