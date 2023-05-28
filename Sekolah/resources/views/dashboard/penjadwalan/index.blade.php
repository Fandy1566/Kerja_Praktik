@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@include('layouts.header', ['title' => 'Jadwal Mengajar'])

<div class="form-nav flex-row" style="gap: 12px; margin-right: 12px; margin-top: 16px;">
    <div class="clickable prevent-select center-text btn btn-table-active">
        Jadwal Saya
    </div>
    <div class="clickable prevent-select center-text btn">
        Jadwal Seluruh
    </div>
    @can('Admin')
    <div class="clickable prevent-select center-text btn" onclick="window.location = '{{ route('jadwal.create') }}'">
        Tambah Jadwal
    </div>
    @endcan
</div>

<div class="card m-32 table-7 flex-row" style="width: 80vw; gap:20px">
    <div>
        <label for="">Tahun ajaran</label><br>
        <select name="tahun" onchange="renderTable();">
            <option value="">Pilih Tahun Ajaran</option>
            @foreach ($penjadwalan as $item)
                <option value="">{{$item->tahun_awal}}/{{$item->tahun_awal+1}}</option>
            @endforeach
        </select>

    </div>
    <div>
        <label for="">Semester</label><br>
        <select name="tahun">
            <option value="1">Gasal</option>
            <option value="0">Genap</option>
        </select>
    </div>
</div>
<div class="table-container" style="margin-left: 12px; margin-right: 12px; overflow-x: scroll;">
    <table id="" class="table-check">

    </table>
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

    const groupedJadwal = jadwalDetails.reduce((result, jadwal) => {
        const { id_guru } = jadwal;
        const { id_mata_pelajaran } = jadwal;
        const guruObj = guru.find(c => c.id === id_guru);
        const mata_pelajaranObj = mata_pelajaran.find(c => c.id === id_mata_pelajaran);
        const jam = jadwal.id_jam;
        
        if (!result[jam]) {
            result[jam] = [];
        }
        
        result[jam].push({...jadwal, ...guruObj, ...mata_pelajaranObj });
        
        return result;
    }, {});

    console.log(groupedJadwal);

    const groupedJadwalLength = Object.keys(groupedJadwal).length;
    console.log(groupedJadwal);
    // let data;
    function renderTable() {
        console.log(groupedJadwalLength);

        table_content = "";

        const table = document.querySelector('.table-check');
        table_content += `
            <tbody>
        `;

        for (let i = 1; i <= Object.keys(groupedJadwal).length; i++) {
            table_content += `
                <tr>
                    `;
            for (let j = 0; j < Object.keys(groupedJadwal[i]).length; j++) {
                    console.log(groupedJadwal[i.toString()][j.toString()].id_guru);
                    table_content += `
                        <td>
                            ${groupedJadwal[i.toString()][j.toString()].name ?? ''}
                            ${groupedJadwal[i.toString()][j.toString()].id_guru ?? ''}
                            ${groupedJadwal[i.toString()][j.toString()].nama_mata_pelajaran ?? ''}
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

</script>
@endsection