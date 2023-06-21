@extends('layouts.dashboard')
@section('content')
@include('layouts.header', ['title' => 'Pengaturan'])

@if(Session::has('message'))
<div class="message">
    <div style="display:flex; justify-content: space-between ; background-color: #A5F2B1;border: 2px solid #479D39; color:#479D39; border-radius:5px; width:100%; height:50px; margin-top: 16px">
        <div style="align-self:center; margin-left:10px">
        {{ Session::get('message') }}
        </div>
        <span class="clickable" style="margin-right:10px; margin-top:10px" onclick="document.querySelector('.message').innerHTML =''">&#10006</span>
    </div>
</div>
@endif


<div class="modal hidden">
</div>
<div class="pengaturan-top flex-row" style="gap:20px">
    <div id="form-layout" class="card m-20" style="width: 700px">
        <div class="title-card">
            Pengaturan Akun
        </div>
        <form style="padding-bottom: 40px" action="{{ route('user.edit', ['id' => Auth::user()->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
        <div class="flex-row" style="margin-top: 15px; margin-left: 12px; gap:20px; align-items: center;">
            <div class="logo-smp" style="margin-top: 8px; overflow: hidden;"><img src="{{$user->foto_profil <> null ? asset('storage/'.$user->foto_profil) : asset('image/picture/Logo.png')}}" id="output" alt="" {{$user->foto_profil <> null ? '' : 'style="width: inherit; height: inherit"'}}></div>
            <div class="center-text button-secondary" id="upload_foto">
                Upload Foto Profil
            </div>
            <input type="file" id="file-input" name="foto_profil" style="display: none;" onchange="loadFile(event)" >
            <div class="title-card2" onclick="deleteImage()">
                Hapus
            </div>
        </div>
        <div class="form-area" style="margin-left: 12px;">

            <input type="hidden" name="_method" value="PATCH">
                <div class="flex-row" style="margin-top: 24px; gap:20px; align-items: center;">
                    <div class="pengaturan-username">
                        <label for="">Email</label>
                        <input type="email" placeholder="Masukan Email .." name="email" value="{{Auth::user()->email}}">
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

    document.querySelector('#upload_foto').addEventListener('click', function() {
        document.querySelector('#file-input').click();
    });

    window.onload = () => {
    var output = document.getElementById('output');
    output.onload = () => {
        output.style.width = "inherit";
        output.style.height = "inherit";
    };
    output.onerror = () => {
        output.style.display = "none";
    };
    if ("{{ $user->foto_profil }}" !== "") {
        output.src = "{{ asset('storage/' . $user->foto_profil) }}";
    } else {
        output.src = "{{ asset('image/picture/Logo.png') }}";
    }
    };


    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
        output.style.width = "inherit";
        output.style.height = "inherit";
    };

    function deleteImage() {
        var output = document.getElementById('output');
        document.getElementById('file-input').value = "";
        output.src = "{{asset('image/picture/Logo.png')}}";
        output.style.width = "auto";
        output.style.height = "auto";
    }

</script>

@endsection