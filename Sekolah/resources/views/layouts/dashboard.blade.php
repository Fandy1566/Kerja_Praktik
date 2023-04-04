@php
    //Digunakan untuk setting menu pada sidebar
    $data = [
        ["Guru",""],
        ["Siswa", ""],
        ["Mata Pelajaran",""],
        ["Jam Mengajar",""],
        ["User",""]
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
            <li class="item dashboard-item-1 {{(request()->is('dashboard')) ? 'active' : '' }}">
                <a href="/">
                    <span class="image"></span>
                    <span class="name">Dashboard</span>
                </a>
            </li>
            <h3>Data</h3>
            @for ($i = 0; $i < count($data); $i++)
            @php
                $properUrl = str_replace(" ", "_", strtolower($data[$i][0]));
            @endphp
                <li class="item data-item-{{$i}} {{(request()->is($properUrl)) ? 'active' : '' }}">
                    <a href="/{{$properUrl}}">
                        <span class="image">{{$data[$i][1]}}</span>
                        <span class="name">{{$data[$i][0]}}</span>
                    </a>
                </li>
            @endfor
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