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
                <div class="menu menu-1 {{(request()->url() == route('dashboard')) ? 'active' : '' }}"><a href="{{ route('dashboard')}}">
                    <img src="{{asset('image/icon/dashboard.svg')}}" alt="">
                    Dashboard
                </a></div>
                <div class="menu menu-2 {{(request()->url() == route('guru')) ? 'active' : '' }}"><a href="{{ route('guru')}}">
                    <img src="{{asset('image/icon/guru.svg')}}" alt="">
                    Guru
                </a></div>
                <div class="menu menu-3 {{(request()->url() == route('kelas')) ? 'active' : '' }}"><a href="{{ route('kelas')}}">
                    <img src="{{asset('image/icon/kelas.svg')}}" alt="">
                    Kelas
                </a></div>
                <div class="menu menu-4 {{(request()->url() == route('mapel')) ? 'active' : '' }}"><a href="{{ route('mapel')}}">
                    <img src="{{asset('image/icon/mapel.svg')}}" alt="">
                    Mata Pelajaran
                </a></div>
                <div class="menu menu-5 {{(request()->url() == route('jampel')) ? 'active' : '' }}"><a href="{{ route('jampel')}}">
                    <img src="{{asset('image/icon/jampel.svg')}}" alt="">
                    Jam Pelajaran
                </a></div>
                <div class="menu menu-6 {{(request()->url() == route('jadwal')) ? 'active' : '' }}"><a href="{{ route('jadwal')}}">
                    <img src="{{asset('image/icon/jadwal.svg')}}" alt="">
                    Jadwal Mengajar
                </a></div>
            </div>
        </div>
        <div class="logout">
        <div class="menu menu-7 {{(request()->url() == route('pengaturan')) ? 'active' : '' }}"><a href="{{ route('pengaturan') }}">
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
</script>
</html>