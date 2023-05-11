<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}"> 
    <link rel="stylesheet" href="{{asset('css/content.css')}}"> 
    @yield('head')

    <title>Document</title>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-top">
            <div class="logo">
                <div class="logo-smp"><img src="{{asset('image/picture/Logo.png')}}" alt=""></div>
                <div class="judul">SMPN 23 PALEMBANG</div>
            </div>
            <div class="main-menu">
                <div class="main-menu-title">MAIN MENU</div>
                <div class="menu menu-1"><a href="{{ route('dashboard')}}">
                    <img src="{{asset('image/icon/dashboard.svg')}}" alt="">
                    Dashboard
                </a></div>
                <div class="menu menu-2"><a href="{{ route('guru')}}">
                    <img src="{{asset('image/icon/guru.svg')}}" alt="">
                    Guru
                </a></div>
                <div class="menu menu-3"><a href="{{ route('kelas')}}">
                    <img src="{{asset('image/icon/kelas.svg')}}" alt="">
                    Kelas
                </a></div>
                <div class="menu menu-4"><a href="{{ route('mapel')}}">
                    <img src="{{asset('image/icon/mapel.svg')}}" alt="">
                    Mata Pelajaran
                </a></div>
                <div class="menu menu-5"><a href="{{ route('jampel')}}">
                    <img src="{{asset('image/icon/jampel.svg')}}" alt="">
                    Jam Pelajaran
                </a></div>
                <div class="menu menu-6"><a href="{{ route('jadwal')}}">
                    <img src="{{asset('image/icon/jadwal.svg')}}" alt="">
                    Jadwal Mengajar
                </a></div>
            </div>
        </div>
        <div class="logout">
        <div class="menu menu-7"><a href="">
                    <img src="{{asset('image/icon/pengaturan.svg')}}" alt="">
                    Pengaturan
                </a></div>
                <div class="menu menu-8"><a href="">
                    <img src="{{asset('image/icon/logout.svg')}}" alt="">
                    Logout
                </a></div>
        </div>
    </div>
    <div class="content">
        @yield('content')
    </div>
</body>
@yield('script')
<script>
    async function submitForm() {
        event.preventDefault(); // prevent form submission
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const form = document.querySelector('form.store');
        const formData = new FormData(form);
        console.log(formData);
        try {

            const response = await fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": csrfToken
                },
                method: "post",
                credentials: "same-origin",
                body: JSON.stringify(Object.fromEntries(formData))
            });
            const data = await response.json();
            await getData();
        } catch (error) {
            console.error(error);
        }
    }

    async function updateData(id) {
        event.preventDefault(); // prevent form submission
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const form = document.querySelector('form.edit');
        const formData = new FormData(form);
        try {
            const response = await fetch(url+"/"+id, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": csrfToken
                },
                method: "post",
                credentials: "same-origin",
                body: JSON.stringify(Object.fromEntries(formData))
            });
            const data = await response.json();
            await getData();
            showFormStore();
        } catch (error) {
            console.error(error);
        }
    }

    async function deleteData(id) {
        try {
            const response = await fetch(url+"/"+id, {
                headers: {
                    "Content-Type": "application/json",
                },
                method: "delete",
                credentials: "same-origin",
            });
            const data = await response.json();
            await getData();
        } catch (error) {
            console.error(error);
        }
    }
</script>
</html>