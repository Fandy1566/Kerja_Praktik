@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jadwal Mengajar'])

@if(Session::has('message'))
<div class="message">
    <div style="display:flex; justify-content: space-between ; background-color: #A5F2B1;border: 2px solid #479D39; color:#479D39; border-radius:5px; width:100%; height:50px; margin-top: 16px">
        <div style="align-self:center; margin-left:10px">
        {{ Session::get('message') }}
        </div>
        <span class="clickable" style="margin-right:10px; margin-top:10px" onclick="document.querySelector('.message').innerHTML =''">&#10006</span>
    </div>
</div>
@endif


<div class="form-nav flex-row" style="gap: 12px; margin-right: 12px; margin-top: 16px;">
    <div class="clickable prevent-select center-text btn" onclick="window.location = window.location.origin+'/penjadwalan';">
        Jadwal
    </div>
    <div class="clickable prevent-select center-text btn" onclick="window.location = window.location.origin + '/penjadwalan/show';">
        Jadwal Saya
    </div>
    @can('Admin')
    <div class="clickable prevent-select center-text btn" onclick="window.location = '{{ route('jadwal.create') }}'">
        Tambah Jadwal
    </div>
    @endcan
</div>
<form method="get" action="/penjadwalan">
    <div class="card m-32 table-7 flex-row" style="gap:20px">
        <div>
            <label for="">Tahun ajaran</label><br>
            <select name="tahun_awal" id="tahun" class="select-style" onchange="renderSemeseter()">
                <option value="">Pilih Tahun Ajaran</option>
                @for ($i = 0; $i < count($penjadwalan); $i++)
                    @if ($i != 0 && ($penjadwalan[$i] != $penjadwalan[$i-1]))
                        <option value="{{$penjadwalan[$i]->tahun_awal}}">{{$penjadwalan[$i]->tahun_awal}}/{{$penjadwalan[$i]->tahun_awal+1}}</option>
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
        <button type="submit" class="btn" style="outline: none; border: none; width:100px; height: 30px; align-self:flex-end; cursor: pointer;">Cari</button>
    </div>
</form>
<div class="card m-32 card-to-remove">
    <div class="btn-group"  style="display: flex; gap: 16px; justify-content:space-between">
        @can('Admin')
            @if ($jadwalDetails[0] ?? 0)
            <form action="{{ route('jadwal.delete', ['id' => $jadwalDetails[0]->id_jadwal]) }}" method="post">
                @csrf
                @method('delete')
                <input type="hidden" name="_method" value="delete">
                <button id="btn_hapus" style="background-color: red; border: none; height:24px; cursor: pointer" type="submit" class="btn">Hapus</button>
            </form>
            @endif
        @endcan
        @can('kepala_sekolah')
            @if(!($jadwalDetails[0]->Jadwal->is_validated ?? false) )
                @if ($jadwalDetails[0] ?? false)
                    <form action="{{ route('jadwal.validasi', ['id' => $jadwalDetails[0]->id_jadwal]) }}" method="post">
                        @csrf
                        <button id="btn_hapus" style="border: none; height:24px; cursor: pointer" type="submit" class="btn">Validasi</button>
                    </form>
                @endif
            @endif
        @endcan
    </div>
    <div class="table-container" style="margin-left: 12px; margin-right: 12px; overflow-x: scroll;">
        <table class="table-check jadwal">
    
        </table>
    </div>
</div>
@endsection
@section('script')
<script>

    const jadwal =  <?php echo json_encode($penjadwalan); ?>;

    function renderSemeseter() {
        const tahun_awal = document.querySelector('#tahun').value;
        const is_gasal = document.querySelector('#is_gasal');

        getGasal = jadwal.filter(item => item.tahun_awal == tahun_awal)
        
        options = ""
        
        if (getGasal.map(item => item.is_gasal).includes(1)) {
            const isValidated = getGasal.filter(item => item.is_gasal === 1).map(item => item.is_validated);
            const optionText = isValidated[0] ? '' : '(Belum Divalidasi)';
            options += `<option value="1">Gasal ${optionText}</option>`;
        }
        if (getGasal.map(item => item.is_gasal).includes(0)){
            const isValidated = getGasal.filter(item => item.is_gasal === 0).map(item => item.is_validated);
            const optionText = isValidated[0] ? '' : '(Belum Divalidasi)';
            options += `<option value="0">Genap ${optionText}</option>`;
        }
        if (getGasal.length == 0) {
            options += `<option value="">Pilih Semester</option>`;
        }
        is_gasal.innerHTML = options;
    }
    renderSemeseter();
    
    const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};
    const url = window.location.origin+"/api/jadwal";
    const jadwalDetails = <?php echo json_encode($jadwalDetails); ?>;
    let kelas = new Set();
    let jam = new Set();

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
                            <td>
                                <div class="flex-column" style="align-items:center">
                                    <div>
                                        ${jadwalDetails[count].guru && jadwalDetails[count].guru.name ? jadwalDetails[count].guru.name : ''}
                                    </div>
                                    <div style ="font-size: 20px">
                                        ${jadwalDetails[count].guru && jadwalDetails[count].guru.id ? jadwalDetails[count].guru.id : ''}
                                    </div>
                                    <div>
                                        ${jadwalDetails[count].mata_pelajaran && jadwalDetails[count].mata_pelajaran.nama_mata_pelajaran ? jadwalDetails[count].mata_pelajaran.nama_mata_pelajaran : ''}
                                    </div>
                                </div>
                            </td>
                        `;
                        count++;
                    }
                });
            });
            table.innerHTML = table_content;
        }
    }
    renderTable();

    

</script>
@endsection