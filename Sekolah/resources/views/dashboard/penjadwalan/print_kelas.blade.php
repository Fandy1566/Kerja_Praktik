@extends('layouts.print')
@section('title', 'Print Laporan Barang Masuk')
@section('content')
    <table class="table-check jadwal">
        
    </table>
    <script>
        const kelas_Id =  localStorage.getItem("kelasToPass");
        const jadwalDetails = <?php echo json_encode($jadwalDetails); ?>;
        let counts = {}

        const isAdmin = {{ auth()->user()->can('Admin') ? 'true' : 'false' }};
        const user = <?php echo json_encode(auth()->user()); ?>;
        let kelas = new Set();
        let jam = new Set();
        let hari = new Set();
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

        const max = Math.max(...Object.values(counts));

        const waktu = jam.filter(item=>item.id_hari=== 1)

        function renderTable() {
            if (jadwalDetails.length === 0) {
                const table = document.querySelector('.card-to-remove');
                table.remove();
                const element = `<div style="margin-top: 20px">Tidak ada data</div>`;
                document.querySelector('.content').insertAdjacentHTML('beforeend', element);
                return;
            } else {
                table_content = "";
        
                const table = document.querySelector('.table-check');
                table_content += `
                    <thead>
                        <tr>
                            <th scope="row" class="freeze-vertical freeze-horizontal">
                                Jam
                            </th>
                `
                hari.forEach(element => {
                    table_content += `
                            <th class="freeze-vertical">
                                ${element.nama_hari}
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
                                <div class="col-fixed" style="width: 100px">
                                    ${waktu[i].waktu_awal} - ${waktu[i].waktu_akhir}
                                </div>
                            </th>
                    `

                        hari.forEach((hariVal, j) => { //kolom
                            try {
                            table_content += `
                                <td>
                                    <div class="flex-column" style="align-items:center" style="width:200px">`
                                        jadwalDetails.filter(item => {return item.jam.id_hari == hariVal.id_hari && item.jam.id == jam[count+j].id}).forEach(element => {
                                            if (element.kelas && element.kelas.id ? (element.kelas.id == kelas_Id) : false) {
                                                table_content +=  `
                                                <div>
                                                    ${element.guru && element.guru.name ? element.guru.name : ''}
                                                </div>
                                                <div>
                                                    ${element.mata_pelajaran && element.mata_pelajaran.nama_mata_pelajaran ? element.mata_pelajaran.nama_mata_pelajaran : ''}
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

    </script>
@endsection