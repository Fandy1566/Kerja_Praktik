@php
    //Digunakan untuk setting menu pada sidebar
    //[nama,link,link gambar]
    $data = [
        ["Dashboard","",asset('logo.png')],
        ["Guru","guru",""],
        ["Kelas","kelas",""],
        ["Jadwal Mengajar","jadwal_mengajar",""],
        ["Mata Pelajaran","mata_pelajaran",""],
        ["Penjadwalan","penjadwalan",""]
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font.css') }}" rel="stylesheet">
    @yield('head')
    <title>@yield('title')</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <div class="logo-border">
                <img src="{{ asset('logo.png') }}" alt="">
            </div>
            SMPN 23 Palembang
        </div>
        <ul>
            @for ($i = 0; $i < count($data); $i++)
                <li class="item data-item-{{$i}} {{(request()->is($data[$i][1])) ? 'active' : '' }}">
                    <a href="/{{$data[$i][1]}}">
                        <span class="image">
                            <img src="{{$data[$i][2]}}" style="width: 20px; height: 20px">
                        </span>
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