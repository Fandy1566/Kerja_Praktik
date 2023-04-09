@php
    //Digunakan untuk setting menu pada sidebar
    //[nama,link,link gambar]
    $data = [
        ["Guru","guru",""],
        ["Hari","hari",""],
        ["Jadwal Kosong","jadwal_kosong",""],
        ["Jam Mengajar","jam_mengajar",""],
        ["Mata Pelajaran","mata_pelajaran",""],
        ["User","user",""]
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    @yield('head')
    <title>@yield('title')</title>
</head>
<body>
    <div class="sidebar">
        <ul>
            <h3>Dashboard</h3>
            <li class="item dashboard-item-1 {{(request()->is('')) ? 'active' : '' }}">
                <a href="/">
                    <span class="image"></span>
                    <span class="name">Dashboard</span>
                </a>
            </li>
            <h3>Data</h3>
            @for ($i = 0; $i < count($data); $i++)
                <li class="item data-item-{{$i}} {{(request()->is($data[$i][1])) ? 'active' : '' }}">
                    <a href="/{{$data[$i][1]}}">
                        <span class="image">{{$data[$i][2]}}</span>
                        <span class="name">{{$data[$i][0]}}</span>
                    </a>
                </li>
            @endfor
            <h3>Penjadwalan</h3>
            <li class="item dashboard-item-2 {{(request()->is('penjadwalan')) ? 'active' : '' }}">
                <a href="/penjadwalan">
                    <span class="image"></span>
                    <span class="name">Penjadwalan</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content">
        @yield('content')
    </div>
</body>
<script>
    const collection = document.getElementsByClassName("title-content");
    const active = document.getElementsByClassName("active");
    collection[0].innerHTML = active[0].querySelector('a .name').innerHTML;
</script>
@yield('script')
</html>