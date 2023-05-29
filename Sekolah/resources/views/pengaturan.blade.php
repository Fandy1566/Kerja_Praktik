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
                        font-weight: 500;">
                    </div>
                </div>
                <input class="clickable form-button title-card" type="submit" value="Simpan" onclick="submitForm()">
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
    }

</script>

@endsection