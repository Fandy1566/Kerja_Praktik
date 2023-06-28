@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jadwal Mengajar'])

<div class="message">
    
</div>

<div id="form-layout" class="card m-20" style="width: 55%">
    <div class="title-card">
        Edit Penjadwalan
    </div>
    <div class="form-area">
        <form class="store" style="display: flex; flex-direction: row;">
            <div class="left-side-form">
                <div class="">
                    <label>Tahun</label>
                    <br>
                    <input name="tahun" type="number" min="1900" max="2099" step="1" value="2016" style="width:300px" readonly/>
                </div>
                <div class="">
                    <label for="">Semester</label><br>
                    <select name="semester" class="select-style" readonly>
                        <option value="1">Gasal</option>
                        <option value="0">Genap</option>
                    </select>
                </div>
            </div>
            <input class="clickable form-button title-card" type="button" value="Update" onclick="updateJadwal()">
        </form>
    </div>
</div>

<div class="card m-32 tbl-jadwal card-to-remove">
    <div class="table-container" style="margin-left: 12px; margin-right: 12px; overflow-x: scroll;">
        <table class="table-check jadwal" id="tbl-edit">
    
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};
    const url = window.location.origin+"/api/jadwal";
    const jadwalDetails = <?php echo json_encode($jadwalDetails); ?>;
    console.log(jadwalDetails);
    const guru = <?php echo json_encode($guru); ?>;
    const mataPelajaran = <?php echo json_encode($mataPelajaran); ?>;
    let kelas = new Set();
    let jam = new Set();

    let array = [];
    let array_mp = [];
    let array_id = [];

    console.log(array);

    function renderTable() {
        if (jadwalDetails.length === 0) {
            const table = document.querySelector('.card-to-remove');
            table.remove();
            const element = `<div style="margin-top: 20px">Tidak ada data</div>`;
            document.querySelector('.content').insertAdjacentHTML('beforeend', element);
            return;
        } else {
            let kelasId = new Set();
            let jamId = new Set();
            
            jadwalDetails.forEach((element) => {
                if (element.kelas) {
                    if (!kelasId.has(element.kelas.id)) {
                        kelasId.add(element.kelas.id);
                        kelas.add(element.kelas);
                    }
                }
                if (element.jam) {
                    if (!jamId.has(element.jam.id)) {
                        jamId.add(element.jam.id);
                        jam.add(element.jam);
                    }
                }
            });

            kelas = Array.from(kelas);
            jam = Array.from(jam);

            let count = 0;
            for (let i = 0; i < jam.length; i++) {
                array[i] = [];
                array_mp[i] = [];
                array_id[i] = [];
                for (let j = 0; j < kelas.length; j++) {
                    array[i][j] = jadwalDetails[count].guru && jadwalDetails[count].guru.id ? jadwalDetails[count].guru.id : null;
                    array_mp[i][j] = jadwalDetails[count].mata_pelajaran && jadwalDetails[count].mata_pelajaran.id ? jadwalDetails[count].mata_pelajaran.id : null;
                    array_id[i][j] = jadwalDetails[count].id;
                    count++;
                }
            }

            array_id = array_id.flat();

            console.log('array', array);
            console.log('array mp', array_mp);

            console.log('Kelas:', kelas);
            console.log('Jam:', jam);

            table_content = "";
    
            const table = document.querySelector('.table-check');
            table_content += `
                <thead>
                    <tr>
                        <th scope="row" class="freeze-vertical freeze-horizontal">
                            Hari
                        </th>
                        <th scope="row" class="freeze-vertical freeze-horizontal" style="left: 102px">
                            Jam
                        </th>
            `
            kelas.forEach(element => {
                table_content += `
                        <th class="freeze-vertical">
                            ${element.nama_kelas}
                        </th>
                `;
            })
            table_content += `
                    </tr>
                </thead>
                <tbody>
            `
            count = 0;
            jam.forEach((jamVal, i) => {
                table_content += `
                    <tr>
                        <th scope="row" class="freeze-horizontal table-body">
                            <div class="col-fixed" style="width: 100px">
                            ${jamVal.hari.nama_hari}
                            </div>
                        </th>
                        <th scope="row" style="left: 102px" class="freeze-horizontal table-body">
                            <div class="col-fixed" style="width: 150px">
                            ${jamVal.waktu_awal} - ${jamVal.waktu_akhir}
                            </div>
                        </th>
                `
                kelas.forEach((kelasVal, j) => {
                    if (jadwalDetails[count].kelas.id == kelasVal.id && jadwalDetails[count].jam.id == jamVal.id) {
                        table_content += `
                            <td style="height: 120px">
                                <div class="flex-column" style="gap:10px; padding-inline: 10px">
                                    <select class="clickable penjadwalan-select-guru" id="select-${i}-${j}" onchange="select(${i},${j})">
                                        <option value="">Pilih Guru</option>`
                                        guru.forEach(guruVal => {
                                            table_content += `<option ${guruVal.id == (jadwalDetails[count].guru && jadwalDetails[count].guru.id ? jadwalDetails[count].guru.id : '') ? 'selected' : ''} value="${guruVal.id}">(${guruVal.id}) ${guruVal.name}</option>`
                                        })
                                        table_content += `
                                    </select>
                                    <select class="clickable penjadwalan-select-mata-pelajaran" id="select-mp-${i}-${j}" onchange="selectmp(${i},${j})">
                                        <option value="">Pilih Mata Pelajaran</option>`
                                        mataPelajaran.forEach(mataPelajaranVal => {
                                            table_content += `<option ${mataPelajaranVal.id == (jadwalDetails[count].mata_pelajaran && jadwalDetails[count].mata_pelajaran.id ? jadwalDetails[count].mata_pelajaran.id : '') ? 'selected' : ''} value="${mataPelajaranVal.id}">(${mataPelajaranVal.id}) ${mataPelajaranVal.nama_mata_pelajaran}</option>`
                                        })
                                        table_content += `
                                    </select>
                                </div>
                            </td>
                        `;
                        count++;
                    }
                });
            });
            table.innerHTML = table_content;

            for (let i = 0; i < jam.length; i++) {
                renderAllSelect(i)
            }
        }
    }
    renderTable();

    function select(i,j) {
        const tbl = document.querySelector("#tbl-edit");
        array[i][j] = parseInt(tbl.querySelector(`#select-${i}-${j}`).value);
        renderAllSelect(i)
    }

    function selectmp(i,j) {
        const tbl = document.querySelector("#tbl-edit");
        array_mp[i][j] = parseInt(tbl.querySelector(`#select-mp-${i}-${j}`).value);
        renderAllSelect(i)
    }

    function renderAllSelect(i) {
        const tbl_jadwal = document.querySelectorAll(".tbl-jadwal");
        tbl_jadwal.forEach(table =>{
            table.querySelectorAll(`tr:nth-child(${i+1}) select:nth-child(1)`).forEach(select =>{
                renderSelect(select, i)
            });
        })
    }

    function renderSelect(select,i){
        // console.log(array_7[i])
        let guru_mapped = guru.map(item=>item.id)
        let option = guru.filter(item=> !array[i].includes(item.id) );
        let options ='';
        options +=`<option value="">Pilih Guru</option>`
        if (select.value !== '') {
            options +=`<option value="${select.value}" selected>${select.options[select.selectedIndex].text}</option>`
        }
        option.forEach((element) => {
            options +=`
                <option value="${element.id}">
                    (${element.id}) ${element.name}
                </option>
            `
        });
        select.innerHTML = options;
    }

    async function updateJadwal() {
        try {
            const response = await fetch(window.location.origin+"/api/jadwal/update", {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": "{{ csrf_token() }}"
                },
                method: "post",
                credentials: "same-origin",
                body: JSON.stringify({
                    array: array.flat(),
                    array_mp: array_mp.flat(),
                    array_id: array_id.flat(),
                })
            });
            const data = await response.json();
            getMessage(data.message? data.message : getError());
            console.log(data);
            } catch (error) {
            console.error(error);
        }
    }

</script>
@endsection