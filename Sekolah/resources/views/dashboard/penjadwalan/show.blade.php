
@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jadwal Mengajar'])

<div class="message"></div>

<div class="form-nav flex-row" style="gap: 12px; margin-right: 12px; margin-top: 16px;">
    <div class="clickable prevent-select center-text btn" onclick="window.location = window.location.origin+'/penjadwalan';">
        Jadwal
    </div>
    @can('guru')
    <div class="clickable prevent-select center-text btn" onclick="window.location = window.location.origin + '/penjadwalan/show';">
        Jadwal Saya
    </div>
    @endcan
    @can('Admin')
    <div class="clickable prevent-select center-text btn" onclick="window.location = window.location.origin + '/penjadwalan/show';">
        Jadwal Guru
    </div>
    <div class="clickable prevent-select center-text btn" onclick="window.location = window.location.origin + '/penjadwalan/show/kelas';">
        Jadwal Kelas
    </div>
    <div class="clickable prevent-select center-text btn" onclick="window.location = '{{ route('jadwal.create') }}'">
        Tambah Jadwal
    </div>
    @endcan
</div>
<form method="get" action="/penjadwalan/show">
    <div class="card m-32 table-7 flex-column" style="gap:20px">
        <div class="flex-row" style="gap:20px">
            <div>
                <label for="">Tahun ajaran</label><br>
                <select name="tahun_awal" id="tahun" class="select-style" onchange="renderSemester()">
                    <option value="">Pilih Tahun Ajaran</option>
                    @for ($i = 0; $i < count($penjadwalan); $i++)
                        @if ($i != 0 && ($penjadwalan[$i] != $penjadwalan[$i-1]))
                            <option {{($_GET['tahun_awal'] ?? 0) == $penjadwalan[$i]->tahun_awal ? 'selected' : ''}} value="{{$penjadwalan[$i]->tahun_awal}}">{{$penjadwalan[$i]->tahun_awal}}/{{$penjadwalan[$i]->tahun_awal+1}}</option>
                        @endif
                    @endfor
                </select>
            </div>
            <div>
                <label for="">Semester</label><br>
                <select name="is_gasal" id="is_gasal" class="select-style">
                    <option value="">Pilih Semester</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn" style="outline: none; border: none; width:100px; height: 30px; align-self:flex-end">Cari</button>
    </div>
</form>
<div id="select-guru" class="card hidden" style="margin-top: 16px;">
        <div class="flex-row" style="gap:20px">
            <div>
                <label for="">Guru</label><br>
                <select name="guru" id="guru" class="select-style" onchange="renderTable()">
                    <option value="">Pilih Guru</option>
                    @can('admin')
                        @foreach($guru as $item)
                            <option value="{{ $item->id }}">({{$item->id}}) {{ $item->name }}</option>
                        @endforeach
                    @endcan
                    @can('guru')
                        <option selected value="{{ Auth::user()->id }}">({{Auth::user()->id}}) {{ Auth::user()->name }}</option>
                    @endcan
                </select>
            </div>
        </div>
</div>

<div class="card card-to-remove" style="margin-top: 16px;">
    <button class="print" onclick="print()">Print</button>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px; overflow-x: scroll;">
        <table class="table-check jadwal">
            
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    const jadwal =  <?php echo json_encode($penjadwalan); ?>;
                
    let counts = {}

    function renderSemester() {
        const tahun_awal = document.querySelector('#tahun').value;
        const is_gasal = document.querySelector('#is_gasal');

        getGasal = jadwal.filter(item => item.tahun_awal == tahun_awal)
        options = ""
        
        if (getGasal.map(item => item.is_gasal).includes(1)) {
            const isValidated = getGasal.filter(item => item.is_gasal === 1).map(item => item.is_validated);
            const optionText = isValidated[0] ? '' : '(Belum Divalidasi)';
            options += `<option {{($_GET['is_gasal'] ?? 0) == 1 ? 'selected' : ''}} value="1">Gasal ${optionText}</option>`;
        }
        if (getGasal.map(item => item.is_gasal).includes(0)){
            const isValidated = getGasal.filter(item => item.is_gasal === 0).map(item => item.is_validated);
            const optionText = isValidated[0] ? '' : '(Belum Divalidasi)';
            options += `<option {{($_GET['is_gasal'] ?? 0) == 0 ? 'selected' : ''}} value="0">Genap ${optionText}</option>`;
        }
        if (getGasal.length == 0) {
            options += `<option value="">Pilih Semester</option>`;
        }
        is_gasal.innerHTML = options;
    }
    
    renderSemester();
    const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};
    const user = <?php echo json_encode(auth()->user()); ?>;
    const url = window.location.origin+"/api/jadwal";
    const jadwalDetails = <?php echo json_encode($jadwalDetails); ?>;
    // console.log(jadwalDetails);
    let kelas = new Set();
    let jam = new Set();
    let hari = new Set();
    let kelasId = new Set();
    let jamId = new Set();

    let max;
    let waktu;

    try {
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

        let hariId = new Set();
        jam.sort(function(a, b) {return a.id_hari - b.id_hari;}).forEach((element) =>{
            if (element.hari) {
                if (!hariId.has(element.hari.id)) {
                    hariId.add(element.hari.id);
                    hari.add({'nama_hari':element.hari.nama_hari, 'id_hari':element.hari.id});
                }
            }
        })

        hari = Array.from(hari);
        jam.forEach(item => {
            const id_hari = item.id_hari;
            if (counts[id_hari]) {
                counts[id_hari]++;
            } else {
                counts[id_hari] = 1;
            }
        }); 
        // console.log(counts);

        max = Math.max(...Object.values(counts));

        waktu = jam.filter(item=>item.id_hari=== 1)

    } catch (error) {
        
    }

    function renderTable() {
        if (jadwalDetails.length === 0 || jadwalDetails === false) {
            const table = document.querySelector('.card-to-remove');
            table.remove();
            const element = `<div style="margin-top: 20px">Tidak ada data</div>`;
            document.querySelector('.content').insertAdjacentHTML('beforeend', element);
            return;
        } else {
            table_content = "";
            if (isAdmin) {
                document.querySelector('#select-guru').classList.remove('hidden');
            }
            const table = document.querySelector('.table-check');
            table_content += `
                <thead>
                    <tr>
                        <th scope="row" class="freeze-vertical freeze-horizontal">
                        <div class="text-center">Jam</div>
                        </th>
            `
            hari.forEach(element => {
                table_content += `
                        <th class="freeze-vertical">
                        <div class="text-center"> ${element.nama_hari}</div>
                        </th>
                `;
            })
            table_content += `
                    </tr>
                </thead>
                <tbody>
            `

            let count = 0;
            for (let i = 0; i < max; i++) { // baris
                count = i;
                table_content += `
                    <tr>
                        <th scope="row" class="freeze-horizontal table-body">
                            <div class="col-fixed" style="width: 175px">
                                ${waktu[i].waktu_awal} - ${waktu[i].waktu_akhir}
                            </div>
                        </th>
                `
                
                    hari.forEach((hariVal, j) => { //kolom
                        try {
                        table_content += `
                            <td>
                                <div class="flex-column" style="align-items:center">`
                                    jadwalDetails.filter(item => {return item.jam.id_hari == hariVal.id_hari && item.jam.id == jam[count+j].id}).forEach(element => {
                                        if (element.guru && element.guru.id ? (element.guru.id == document.querySelector('#guru').value) : false) {
                                            table_content +=  `
                                            <div>
                                                ${element.mata_pelajaran && element.mata_pelajaran.nama_mata_pelajaran ? element.mata_pelajaran.nama_mata_pelajaran : ''}
                                            </div>
                                            <div>
                                                ${element.kelas && element.kelas.nama_kelas ? element.kelas.nama_kelas : ''}
                                            </div>
                                            `
                                        }
                                        
                                    });
                                    table_content += `</div>
                            </td>
                        `;
                        count = count + counts[j+1];
                        // console.log(i,counts[j+1]);
                        // console.log(count);
                        } catch (error) {

                        }
                    });
                

                
            }

            table.innerHTML = table_content;
        }
    }
    renderTable();

    function print() {
        const guruToPass = document.querySelector('#guru').value;
        localStorage.setItem("guruToPass", guruToPass);
        const guruToPrint = localStorage.getItem("guruToPass"); // Rename the variable
        console.log(guruToPrint);
        const newWindow = window.open("{{route('jadwal.guru.print', ['id' => $jadwalDetails[0]->id_jadwal ?? 0])}}");

    }


</script>
@endsection