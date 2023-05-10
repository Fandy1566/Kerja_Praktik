@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    @include('layouts.header', ['title' => 'Dashboard'])
    <div class="grid-container">
        <div class="container item-1">
            <div class="item-title">
                <div class="title1">Jumlah Guru</div>
                <div class="item1">30</div>
                <img src="{{asset('image/icon/guru.svg')}}" style="bottom:10px" alt="">
            </div>
            <div class="item-bot">
                <a href="">Lihat Detail Guru</a>
            </div>
        </div>
        <div class="container item-2">
            <div class="item-title">
                <div class="title1">Jumlah Kelas</div>
                <div class="item1">23</div>
                <img src="{{asset('image/icon/kelas.svg')}}" style="bottom:10px" alt="">
            </div>
            <div class="item-bot">
                <a href="">Lihat Detail Kelas</a>
            </div>
        </div>
        <div class="container item-3">
            <div class="item-title2">
                <div class="left-item">
                    <div class="title2">Mata Pelajaran</div>
                    <div class="item2">54</div>
                </div>
                <div class="right-item">
                    <div class="pb-mapel">
                        <div class="pb"></div>
                    </div>
                    <div class="content-mapel">Capaian mata pelajaran yang dibutuhkan tiap kelas</div>
                </div>
            </div>
        </div>
        <div class="container item-4">
            <div class="item-title">
                <div class="title1">Mata Pelajaran</div>
                <div class="item1">54</div>
                <img src="{{asset('image/icon/mapel.svg')}}" style="bottom:10px" alt="">
            </div>
            <div class="item-bot">
                <a href="">Lihat Detail Mata Pelajaran</a>
            </div>
        </div>
        <div class="container item-5">
            <div class="item-title">
                <div class="title1">Jam Pelajaran</div>
                <div class="item1">37</div>
                <img src="{{asset('image/icon/jampel.svg')}}" style="bottom:10px" alt="">
            </div>
            <div class="item-bot">
                <a href="">Lihat Detail Jam Pelajaran</a>
            </div>
        </div>
        <div class="container item-6">
            <div class="item-title2-1">
                <div class="title2">Jumlah Jam Mengajar Guru</div>
                <div class="item2">37</div>
            </div>
            <div class="content-jam">
                <div class="content-jam-kelas"></div>
                <div class="content-jam-kelas"></div>
                <div class="content-jam-kelas"></div>
            </div>
            <div class="content-jam-bot">Note : Capai 37 jam mengajar agar mendapat hasil penjadwalan yang lebih baik</div>
        </div>
        <div class="container item-7">
            <div class="item-title3">
                <div class="title2">Peringatan!!</div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>

</script>
@endsection