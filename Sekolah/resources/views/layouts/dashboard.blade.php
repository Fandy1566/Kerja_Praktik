@php
    $menu =[
        ["Dashboard", route('dashboard'), [asset('image/icon/dashboard.svg'), asset('image/icon/dashboard_active.svg')]],
        ["Guru", route('guru'), [asset('image/icon/guru.svg'), asset('image/icon/guru_active.svg')]],
        ["Kelas", route('kelas'), [asset('image/icon/kelas.svg'), asset('image/icon/kelas_active.svg')]],
        ["Mata Pelajaran", route('mapel'), [asset('image/icon/mapel.svg'), asset('image/icon/mapel_active.svg')]],
        ["Jam Pelajaran", route('jampel'), [asset('image/icon/jampel.svg'), asset('image/icon/jampel_active.svg')]],
        ["Jadwal Mengajar", route('jadwal'), [asset('image/icon/jadwal.svg'), asset('image/icon/jadwal_active.svg')]],
];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}"> 
    <link rel="stylesheet" href="{{asset('css/content.css')}}"> 
    <link rel="stylesheet" href="{{asset('css/modal.css')}}"> 

    <title>Document</title>
</head>
<body>
    <div class="modal hidden">
        <div class="modal-content">
            <span class="close" onclick="modalLogoutToggle()">&times;</span>
            <p>Some text in the Modal..</p>
        </div>
    </div>
    <div class="sidebar">
        <div class="sidebar-top">
            <div class="logo">
                <div class="logo-smp"><img src="{{asset('image/picture/Logo.png')}}" alt=""></div>
                <div class="judul">SMPN 23 PALEMBANG</div>
            </div>
            <div class="main-menu">
                <div class="main-menu-title">MAIN MENU</div>
                @for ($i = 0; $i < count($menu); $i++)
                    <div class="menu menu-{{$i}} {{(request()->url() == $menu[$i][1]) ? 'active' : '' }}">
                        <a href="{{ $menu[$i][1] }}">
                            <img src="{{(request()->url() == $menu[$i][1]) ? $menu[$i][2][1] : $menu[$i][2][0]}}" alt="">
                            {{$menu[$i][0]}}
                        </a>
                    </div>
                @endfor
            </div>
        </div>
        <div class="logout">
        <div class="menu menu-7 {{(request()->url() == route('pengaturan')) ? 'active' : '' }}"><a href="{{ route('pengaturan') }}">
                <img src="{{asset('image/icon/pengaturan.svg')}}" alt="">
                Pengaturan
            </a></div>
            <div class="menu menu-8 clickable" onclick="modalLogoutToggle()">
                <img src="{{asset('image/icon/logout.svg')}}" alt="">
                Logout
            </div>
        </div>
    </div>
    <div class="content">
        @yield('content')
    </div>
</body>
@yield('script')
<script>

    function formDataToObject(formData) {
        let object = {}

        const debug = (message) => {
            //console.log(message)
        }

        /**
         * Parses FormData key xxx`[x][x][x]` fields into array
         */
        const parseKey = (key) => {
            const subKeyIdx = key.indexOf('[');

            if (subKeyIdx !== -1) {
                const keys = [key.substring(0, subKeyIdx)]
                key = key.substring(subKeyIdx)

                for (const match of key.matchAll(/\[(?<key>.*?)]/gm)) {
                    keys.push(match.groups.key)
                }
                return keys
            } else {
                return [key]
            }
        }

        /**
         * Recursively iterates over keys and assigns key/values to object
         */
        const assign = (keys, value, object) => {
            const key = keys.shift()
            debug(key)
            debug(keys)

            // When last key in the iterations
            if (key === '' || key === undefined) {
                return object.push(value)
            }

            if (Reflect.has(object, key)) {
                debug('hasKey ' + key)
                // If key has been found, but final pass - convert the value to array
                if (keys.length === 0) {
                    if (!Array.isArray(object[key])) {
                        debug('isArray ' + object[key])
                        object[key] = [object[key], value]
                        return
                    }
                }
                // Recurse again with found object
                return assign(keys, value, object[key])
            }

            // Create empty object for key, if next key is '' do array instead, otherwise set value
            if (keys.length >= 1) {
                debug(`undefined '${key}' key: remaining ${keys.length}`)
                object[key] = keys[0] === '' ? [] : {}
                return assign(keys, value, object[key])
            } else {
                debug("set value: " + value)
                object[key] = value
            }
        }

        for (const pair of formData.entries()) {
            assign(parseKey(pair[0]), pair[1], object)
        }

        return object
    }

    async function submitForm() {
        event.preventDefault(); // prevent form submission
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const form = document.querySelector('form.store');
        const formData = new FormData(form);
        // console.log(JSON.stringify(formDataToObject(formData)));
        try {
            const response = await fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": csrfToken
                },
                method: "post",
                credentials: "same-origin",
                body: JSON.stringify(formDataToObject(formData))
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

    // async function deleteData(id) {
    //     try {
    //         const response = await fetch(url+"/"+id, {
    //             headers: {
    //                 "Content-Type": "application/json",
    //             },
    //             method: "delete",
    //             credentials: "same-origin",
    //         });
    //         const data = await response.json();
    //         await getData();
    //     } catch (error) {
    //         console.error(error);
    //     }
    // }

    async function deleteSelected(name) {
        try {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            const checkedCheckboxes = [];
            checkboxes.forEach(tbodyCheckBox  => {
                if (tbodyCheckBox.checked) {
                    checkedCheckboxes.push(tbodyCheckBox.value);
                }
            });
            // console.log(checkedCheckboxes);
            // console.log(JSON.stringify({ checkedCheckboxes }));

            if (checkedCheckboxes.length > 0) {
                const response = await fetch(window.location.origin+"/api/delete/"+name, {
                    headers: {
                        "Content-Type": "application/json",
                    },
                    method: "delete",
                    credentials: "same-origin",
                    body: JSON.stringify({ checkedCheckboxes })
                    // body: JSON.stringify({ id : checkedCheckboxes })
                });
                const data = await response.json();
                await getData();
                } else {
                //kalo kurang dari 1
            }
            
        } catch (error) {
            console.error(error);
        }
    }

    function checkAll() {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(tbodyCheckBox  => {
            tbodyCheckBox.checked = document.querySelector('thead input[type="checkbox"]').checked;
        });
    }

    function modalLogoutToggle() {
        const modal = document.querySelector('.modal');
        modal.classList.toggle('hidden');
    }

</script>
</html>