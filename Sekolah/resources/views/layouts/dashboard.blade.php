@php
    //Digunakan untuk setting menu pada sidebar
    //[nama,link,link gambar]
    $sidebarItem = [
        ["Dashboard","dashboard",[asset('image/icon/dashboard_active.svg'), asset('image/icon/dashboard_default.svg')]],
        ["Guru","guru",[asset('image/icon/guru_active.svg'), asset('image/icon/guru_default.svg')]],
        ["Kelas","kelas",[asset('image/icon/kelas_active.svg'), asset('image/icon/kelas_default.svg')]],
        ["Mata Pelajaran","mata_pelajaran",[asset('image/icon/mata_pelajaran_active.svg'), asset('image/icon/mata_pelajaran_default.svg')]],
        ["Jam Pelajaran","jam_pelajaran",[asset('image/icon/jam_active.svg'), asset('image/icon/jam_default.svg')]],
        ["Jadwal Mengajar","jadwal_mengajar",[asset('image/icon/jadwal_active.svg'), asset('image/icon/jadwal_default.svg')]]
    ];

    $sidebarItemAdditional = [
        ["Pengaturan","pengaturan",asset('image/icon/dashboard_active.svg')],
        ["Keluar","keluar",asset('image/icon/dashboard_active.svg')],
    ]
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/content.css') }}" rel="stylesheet">
    @yield('head')
    <title>@yield('title')</title>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-container">
                {{-- <img src="{{ asset('/image/picture/logo.png')}}" alt=""> --}}
            </div>
            <div class="logo-text">
                SMPN 23 PALEMBANG
            </div>
        </div>
        <div class="sidebar-top-menu">
            <div class="text">
                MAIN MENU
            </div>
            <ul>
                @foreach ($sidebarItem as $item)
                    <li class="sidebar-item {{(request()->is($item[1])) ? 'active' : '' }}">
                        <a href="/{{$item[1]}}">
                            <img src="{{(request()->is($item[1])) ? $item[2][0] : $item[2][1] }}" alt="">
                            <div class="text">
                                {{$item[0]}}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="sidebar-bottom-menu">
            <ul>
                @foreach ($sidebarItemAdditional as $item)
                    <li class="sidebar-item {{(request()->is($item[1])) ? 'active' : '' }}">
                        <a href="/{{$item[1]}}">
                            <img src="{{$item[2]}}" alt="">
                            <div class="text">
                                {{$item[0]}}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="content">
        @yield('content')
    </div>
<script>
    async function submitForm() {
        event.preventDefault(); // prevent form submission
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const form = document.querySelector('form.store');
        const formData = new FormData(form);

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
@yield('script')

</html>