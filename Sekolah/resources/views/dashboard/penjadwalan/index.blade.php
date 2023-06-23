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
            <select name="id" class="select-style ">
                <option value="">Pilih Tahun Ajaran</option>
                @foreach ($penjadwalan as $item)
                    <option value="{{$item->id}}">{{$item->tahun_awal}}/{{$item->tahun_awal+1}} ({{$item->is_validated ? "Telah divalidasi": "Belum divalidasi"}})</option>
                @endforeach
            </select>

        </div>
        <div>
            <label for="">Semester</label><br>
            <select name="tahun" class="select-style">
                <option value="1">Gasal</option>
                <option value="0">Genap</option>
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
            @if(!($jadwalDetails[0]->Jadwal->is_validated ?? 0) )
                @if ($jadwalDetails[0] ?? 0)
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

    const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};
    const url = window.location.origin+"/api/jadwal";
    const jadwalDetails = <?php echo json_encode($jadwalDetails); ?>;
    const jadwalMengajar = <?php echo json_encode($jadwalMengajar); ?>;
    const guru = <?php echo json_encode($guru); ?>;
    const mata_pelajaran = <?php echo json_encode($mataPelajaran); ?>;
    const hari = <?php echo json_encode($hari); ?>;
    const kelas = <?php echo json_encode($kelas); ?>;
    // let data;

    if (jadwalDetails.length != 0) {
        function renderTable() {
    
            const groupedJadwal = jadwalDetails.reduce((result, jadwal) => {
                const { id_guru, id_mata_pelajaran, id_jam, } = jadwal;
                const guruObj = guru.find(c => c.id === id_guru);
                const mata_pelajaranObj = mata_pelajaran.find(c => c.id === id_mata_pelajaran);
                const jadwalMengajarObj = jadwalMengajar.find(c => c.id === id_jam);
                const { id_hari } = jadwalMengajarObj;
                const hariObj = hari.find(c => c.id === id_hari);
                const jam = jadwal.id_jam;
    
                if (!result[jam]) {
                    result[jam] = [];
                }
    
                result[jam].push({ ...jadwal, ...guruObj, ...mata_pelajaranObj, ...jadwalMengajarObj, hari: hariObj });
    
                return result;
            }, {});
    
            const kelasUnique = [...new Set(jadwalDetails.map(jadwal => jadwal.id_kelas))];
    
            const groupedKelas = kelasUnique.reduce((result, kelas2) => {
                const kelasObj = kelas.find(c => c.id === kelas2);
    
                if (!result[kelas2]) {
                    result[kelas2] = { ...kelasObj };
                }
    
                return result;
            }, {});
    
            const groupedJadwalLength = Object.keys(groupedJadwal).length;
    
            table_content = "";
    
            const table = document.querySelector('.table-check');
            table_content += `
                <thead>
                    <tr>
                        <th scope="row" style="left: 0px"rowspan="2">Hari</th>
                        <th scope="row" style="left: 101px" rowspan="2">Waktu</th>
            `
            for (let i = 1; i <= Object.keys(groupedKelas).length; i++) {
                table_content +=`
                        <th>
                            ${groupedKelas[i.toString()].nama_kelas}
                        </th>
                `;
            }
            table_content += `
                    </tr>
                </thead>
            `
            table_content += `
                <tbody>
            `;
    
            for (let i = 1; i <= Object.keys(groupedJadwal).length; i++) {
                table_content += `
                    <tr>
                        `;
                    table_content += `
                        <th scope="row">
                            <div class="col-fixed" style="width: 100px">
                            ${groupedJadwal[i.toString()][0].hari.nama_hari ?? ''}
                            </div>
                        </th>
                        <th scope="row" style="left: 101px">
                            <div class="col-fixed" style="width: 150px">
                            ${groupedJadwal[i.toString()][0].waktu_awal ?? ''} -
                            ${groupedJadwal[i.toString()][0].waktu_akhir ?? ''}
                            </div>
                        </th>
                        `;
    
                for (let j = 0; j < Object.keys(groupedJadwal[i]).length; j++) {
                        console.log(groupedJadwal[i.toString()][j.toString()].id_guru);
                        table_content += `
                            <td>
                                <div class="flex-column" style="align-items:center">
                                    <div>
                                        ${groupedJadwal[i.toString()][j.toString()].name ?? ''}
                                    </div>
                                    <div style ="font-size: 20px">
                                        ${groupedJadwal[i.toString()][j.toString()].id_guru ?? ''}
                                    </div>
                                    <div>
                                        ${groupedJadwal[i.toString()][j.toString()].nama_mata_pelajaran ?? ''}
                                    </div>
                                </div>
                            </td>
                        `;
                }
                table_content += `
                    </tr>
                `;
            };
            table_content += `
                </tbody>
            `;
            table.innerHTML = table_content;
        }
    } else {
        function renderTable() {
            const table = document.querySelector('.card-to-remove');
            table.remove();
            element = `
            <div style ="margin-top:20px">
                Tidak ada data
            </div>
            `;
            document.querySelector('.content').insertAdjacentHTML('beforeend', element);
        }
    }
    renderTable();

    async function deleteItem(id) {
    try {
        const response = await fetch(window.location.origin + "/api/jadwal/delete/" + id, {
            headers: {
                "Content-Type": "application/json",
            },
            method: "delete",
            credentials: "same-origin",
        });
        const data = await response.json();
        getMessage(data.message? data.message : getError());
        // Handle the response data as needed
    } catch (error) {
        console.error(error);
        // Handle the error condition
    }
}

</script>
@endsection