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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}"> 
    <link rel="stylesheet" href="{{asset('css/content.css')}}"> 
    <link rel="stylesheet" href="{{asset('css/modal.css')}}"> 
    @yield('head')

    <title>Document</title>
</head>
<body>
    <div class="modal hidden">
        <div class="modal-content">
            <h2>Keluar Akun</h2>
            <p>Apakah kamu yakin mau keluar dari akun?</p>
            <div class="button">
                <button onclick="modalLogoutToggle()">Batal</button>
                <button onclick="window.loc = '{{ route('logout') }}';">Keluar</button>
            </div>
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
<script>

    // Table Script
    function previousPage() {
        if(curPage > 1) curPage--;
        renderTable();
    }

    function nextPage() {
        if((curPage * pageSize) < table_data.length) curPage++;
        renderTable();
    }

    let sortCol;
    let sortAsc = false;
    
    let pageSize = 10;
    let curPage = 1;
    let totalData;

    let table_data = [];

    function sort(e) {
        let thisSort = e.target.dataset.sort;
        if(sortCol === thisSort) sortAsc = !sortAsc;
        sortCol = thisSort;
        table_data.sort((a, b) => {
            if(a[sortCol] < b[sortCol]) return sortAsc?1:-1;
            if(a[sortCol] > b[sortCol]) return sortAsc?-1:1;
            return 0;
        });
        renderTable();
    }

    function setCurrentPage(num){
        curPage = num;
        renderTable();
    }

    function getLengthPage(){
        const input = document.getElementById("search");
        let filter = input.value.toUpperCase();

        if (filter !=="" || filter !== null) {
            let totalData = table_data.filter(item => {
                const value = item[input.dataset.colName].toUpperCase();
                return value.includes(filter);
            }).length
            return Math.ceil(totalData/pageSize);
        }
        else{
            return Math.ceil(table_data/pageSize);
        }
    }

    function checkIfOffset() {
        if (curPage > getLengthPage()) {
            setCurrentPage(getLengthPage());
        }
    }

    function renderPagination(){
        const pagination = document.getElementById("pagination");
        let number = "";
        let pageLength = getLengthPage();
        if (pageLength >= 5) {
            let maxstart = curPage -2;
            let maxend = curPage + 2;
            let maxPage = 3;
            if (maxstart > 0  && maxend+1 <= pageLength) {
                for (let index = maxstart+1; index <= maxend-1; index++) {
                    number += `
                    <div class="prevent-select clickable ${index == curPage ? 'pagination-active':''}" onclick="setCurrentPage(${index})">${index}</div>
                    `;
                }
                number += `
                    <div> ... </div>
                    <div class="prevent-select clickable ${pageLength == curPage ? 'pagination-active':''}" onclick="setCurrentPage(${pageLength})">${pageLength}</div>
                    `;
            } else if (curPage+2 >= pageLength) {
                number += `
                    <div class="prevent-select clickable ${1 == curPage ? 'pagination-active':''}" onclick="setCurrentPage(${1})">${1}</div>
                    <div> ... </div>
                    `;
                for (let index = pageLength-3; index <= pageLength; index++) {
                    number += `
                    <div class="prevent-select clickable ${index == curPage ? 'pagination-active':''}" onclick="setCurrentPage(${index})">${index}</div>
                    `;
                }
            } else {
                for (let index = 1; index <= maxPage; index++) {
                    number += `
                    <div class="prevent-select clickable ${index == curPage ? 'pagination-active':''}" onclick="setCurrentPage(${index})">${index}</div>
                    `;
                }
                number += `
                    <div> ... </div>
                    <div class="prevent-select clickable ${pageLength == curPage ? 'pagination-active':''}" onclick="setCurrentPage(${pageLength})">${pageLength}</div>
                    `;
            }

        } else {
            for (let index = 1; index <= getLengthPage(); index++) {
                number += `
                <div class="prevent-select clickable ${index == curPage ? 'pagination-active':''}" onclick="setCurrentPage(${index})">${index}</div>
                `;
            }
        }
        pagination.innerHTML = number;
    }

    $(document).ready(function() {
        document.querySelectorAll('#tbl thead th:not(:first-child)').forEach(th => {
            th.addEventListener('click', sort, false);
        });
    });

</script>
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

    // function search(col_name) {
    //     const row = document.querySelectorAll('#tbl tbody tr');
    //     input = document.getElementById("search");
    //     filter = input.value.toUpperCase();
    //     for (i = 0; i < row.length; i++) {
    //         td = row[i].querySelector('td#'+col_name);
    //         if (td) {
    //             txtValue = td.textContent || td.innerText;
    //             if (txtValue.toUpperCase().indexOf(filter) > -1) {
    //                 row[i].style.display = "";
    //             } else {
    //                 row[i].style.display = "none";
    //             }
    //         }       
    //     }
    // }

    async function getData() {
        try {
            const response = await fetch(url);
            const data = await response.json();
            table_data = data.data;
            await renderTable();
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>
</html>