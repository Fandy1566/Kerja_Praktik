@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    @include('layouts.header', ['title' => 'Dashboard'])
    <div class="grid-container">
        <div class="container item-1">
            <div class="item-title">Jumlah guru</div>
            <div class="item-count" id="item-count-1"></div>
        </div>
        <div class="container item-2">
            <div class="item-title">Jumlah Kelas</div>
            <div class="item-count" id="item-count-2"></div>
        </div>
        <div class="container item-3">
            <div class="item-title">Mata Pelajaran</div>
            <div class="item-count" id="item-count-3"></div>
        </div>
        <div class="container item-4">
            <div class="item-title">Mata Pelajaran</div>
            <div class="item-count" id="item-count-4"></div>
        </div>
        <div class="container item-5">
            <div class="item-title">Jam Pelajaran</div>
            <div class="item-count" id="item-count-5"></div>
        </div>
        <div class="container item-6">
            <div class="item-title">Jumlah Jam Mengajar Guru</div>
            <div class="item-count" id="item-count-6"></div>
        </div>
        <div class="container item-7">
            <div class="item-title">Peringatan</div>
        </div>
    </div>
@endsection
@section('script')
<script>

</script>
@endsection