@php

    $tingkat = [];

    for ($i=0; $i < count($kelas); $i++) { 
        try {
            if (!isset($tingkat[$kelas[$i]->tingkat])) {
                $tingkat[$kelas[$i]->tingkat] = 0;
            }
            $tingkat[$kelas[$i]->tingkat] += 1;
        } catch (\Exception $e) {
            continue;
        }
    }

    $guru_kelas_7 = 0;
    for ($i=0; $i < count($guru); $i++) { 
        try {
            if ($guru[$i]->is_guru_kelas_7) {
                $guru_kelas_7 += 1;
            }
        } catch (\Exception $e) {
            continue;
        }
    }

    $guru_kelas_8 = 0;
    for ($i=0; $i < count($guru); $i++) { 
        try {
            if ($guru[$i]->is_guru_kelas_8) {
                $guru_kelas_8 += 1;
            }
        } catch (\Exception $e) {
            continue;
        }
    }

    $guru_kelas_9 = 0;
    for ($i=0; $i < count($guru); $i++) {
        try {
            if ($guru[$i]->is_guru_kelas_9) {
                $guru_kelas_9 += 1;
            }
        }
        catch (\Exception $e) {
            continue;
        }
    }
    $guru_kelas = [$guru_kelas_7, $guru_kelas_8, $guru_kelas_9];
@endphp

@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    @include('layouts.header', ['title' => 'Dashboard'])
    <div class="grid-container">
        <div class="container item-1">
            <div class="item-title">
                <div class="title1">Jumlah Guru</div>
                <div class="item1">{{count($guru)}}</div>
                <img src="{{asset('image/icon/guru.svg')}}" style="bottom:10px" alt="">
            </div>
            <div class="item-bot">
                <a href="{{ route('guru')}}">Lihat Detail Guru</a>
            </div>
        </div>
        <div class="container item-2">
            <div class="item-title">
                <div class="title1">Jumlah Kelas</div>
                <div class="item1">{{count($kelas)}}</div>
                <img src="{{asset('image/icon/kelas.svg')}}" style="bottom:10px" alt="">
            </div>
            <div class="item-bot">
                <a href="{{ route('kelas')}}">Lihat Detail Kelas</a>
            </div>
        </div>
        <div class="container item-3">
            <div class="item-title2">
                <div class="left-item">
                    <div class="title2">Guru</div>
                    <div class="item2">{{count($guru)}}</div>
                </div>
                <div class="right-item">
                    {{-- <div class="pb-mapel" style="background-color: #A6CDE5;">
                        <div class="pb-mapel" style="background-color: #274B6F; width: 33.3%;">
                        <div class="pb-persen">33.3%</div>
                        </div>
                    </div> --}}
                    <div class="content-mapel" style="font-size: 15px">Capaian guru yang dibutuhkan tiap kelas</div>
                </div>
            </div>
            <div class="pb-all-mapel">
                <div class="pb-title" style="margin-top: 16px;">
                    Kelas VII
                    <div class="pb-mapel2" style="background-color: #FFAEAE; margin-top: 12px;">
                        <div class="pb-mapel2" style="background-color: #BB1818; width: {{(($guru_kelas[0] / ($tingkat["7"] ?? 0))*100 >= 100) ? '100' : (($guru_kelas[0] / ($tingkat["7"] ?? 0))*100)}}%;">
                        <div class="pb-persen2">{{($guru_kelas[0] / ($tingkat["7"] ?? 1))*100}}%</div>
                        </div>
                    </div>
                </div>
                <div class="pb-title" style="margin-top: 16px;">
                    Kelas VIII
                    <div class="pb-mapel2" style="background-color: #FFD95A; margin-top: 12px;">
                        <div class="pb-mapel2" style="background-color: #FCD552; width: {{(($guru_kelas[1] / ($tingkat["8"] ?? 0))*100 >= 100) ? '100' : (($guru_kelas[1] / ($tingkat["8"] ?? 0))*100)}}%;">
                        <div class="pb-persen2">{{($guru_kelas[1] / ($tingkat["8"] ?? 1))*100}}%</div>
                        </div>
                    </div>
                </div>
                <div class="pb-title" style="margin-top: 16px;">
                    Kelas IX
                    <div class="pb-mapel2" style="background-color: #A6CDE5; margin-top: 12px;">
                        <div class="pb-mapel2" style="background-color: #479D39; width: {{(($guru_kelas[2] / ($tingkat["9"] ?? 0))*100 >= 100) ? '100' : (($guru_kelas[2] / ($tingkat["9"] ?? 0))*100)}}%;">
                        <div class="pb-persen2">{{($guru_kelas[2] / ($tingkat["9"] ?? 1))*100}}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container item-4">
            <div class="item-title">
                <div class="title1">Mata Pelajaran</div>
                <div class="item1">{{$mataPelajaran}}</div>
                <img src="{{asset('image/icon/mapel.svg')}}" style="bottom:10px" alt="">
            </div>
            <div class="item-bot">
                <a href="{{ route('mapel')}}">Lihat Detail Mata Pelajaran</a>
            </div>
        </div>
        <div class="container item-5">
            <div class="item-title">
                <div class="title1">Jam Pelajaran</div>
                <div class="item1">{{$jadwalMengajar}}</div>
                <img src="{{asset('image/icon/jampel.svg')}}" style="bottom:10px" alt="">
            </div>
            <div class="item-bot">
                <a href="{{ route('jampel')}}">Lihat Detail Jam Pelajaran</a>
            </div>
        </div>
        <div class="container item-6">
            <div class="item-title2-1">
                <div class="title2">Jumlah Persebaran Guru</div>
                <div class="item2">{{count($guru)}}</div>
            </div>
            <div class="content-jam">
                <div class="content-jam-kelas">
                    <div class="dashboard-kelas">
                        Kelas VII
                    </div>
                    <div class="dashboard-jam-kelas">
                        {{$guru_kelas[0] ?? 0}}/{{$tingkat["7"] ?? 0}}
                    </div>
                </div>
                <div class="content-jam-kelas">
                <div class="dashboard-kelas">
                        Kelas VIII
                    </div>
                    <div class="dashboard-jam-kelas">
                        {{$guru_kelas[1] ?? 0}}/{{$tingkat["8"] ?? 0}}
                    </div>
                </div>
                <div class="content-jam-kelas">
                <div class="dashboard-kelas">
                        Kelas IX
                    </div>
                    <div class="dashboard-jam-kelas">
                        {{$guru_kelas[2] ?? 0}}/{{$tingkat["9"] ?? 0}}
                    </div>
                </div>
            </div>
            <div class="content-jam-bot">Note : Capai target jumlah guru agar mendapat hasil penjadwalan yang lebih baik</div>
        </div>
        <div class="container item-7">
            <div class="item-title3">
                <div class="title2">Peringatan!!</div>
            </div>
            @if (($guru_kelas[0] ?? 0) < ($tingkat["7"] ?? 0))
                <div class="content-peringatan">
                    Tambahkan Guru pada kelas 7 agar penjadwalan dapat bekerja lebih maksimal
                </div>
            @endif
            @if (($guru_kelas[1] ?? 0) < ($tingkat["8"] ?? 0))
                <div class="content-peringatan">
                    Tambahkan Guru pada kelas 8 agar penjadwalan dapat bekerja lebih maksimal
                </div>
            @endif
            @if (($guru_kelas[2] ?? 0) < ($tingkat["9"] ?? 0))
                <div class="content-peringatan">
                    Tambahkan Guru pada kelas 9 agar penjadwalan dapat bekerja lebih maksimal
                </div>
            @endif
            @if ((count($guru) ?? 0) < (count($kelas) ?? 0))
                <div class="content-peringatan">
                    Tambahkan Guru Baru
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
<script>

</script>
@endsection