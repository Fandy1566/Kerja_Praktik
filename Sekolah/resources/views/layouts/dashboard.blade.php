<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}"> 
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
                <div class="menu menu-1"><a href="">
                    <img src="{{asset('image/icon/dashboard.svg')}}" alt="">
                    Dashboard
                </a></div>
                <div class="menu menu-2"><a href="">
                    <img src="{{asset('image/icon/guru.svg')}}" alt="">
                    Guru
                </a></div>
                <div class="menu menu-3"><a href="">
                    <img src="{{asset('image/icon/kelas.svg')}}" alt="">
                    Kelas
                </a></div>
                <div class="menu menu-4"><a href="">
                    <img src="{{asset('image/icon/mapel.svg')}}" alt="">
                    Mata Pelajaran
                </a></div>
                <div class="menu menu-5"><a href="">
                    <img src="{{asset('image/icon/jampel.svg')}}" alt="">
                    Jam Pelajaran
                </a></div>
                <div class="menu menu-6"><a href="">
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
</html>