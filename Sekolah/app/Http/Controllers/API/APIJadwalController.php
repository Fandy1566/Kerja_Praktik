<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JadwalDetail;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use DB;

class APIJadwalController extends Controller
{
    public function show(Request $request)
    {
        try {
            $jadwal = Jadwal::find($request->id);
            if ($jadwal) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil ditampilkan',
                    'data' => $jadwal
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal ditampilkan',
            ],400);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction(); 
        
            $jadwal = new jadwal;
            $increment = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='" . env('DB_DATABASE') . "' AND TABLE_NAME ='" . $jadwal->getTable() . "'")[0]->AUTO_INCREMENT;
            $jadwal->nama_jadwal = $request->nama_jadwal;
            $jadwal->is_jadwal_tetap = $request->is_jadwal_tetap;
            $jadwal->save();

            //input kelas 7
            for ($i=0; $i < count($request->array7); $i++) { 
                for ($j=0; $j < count($request->array7[$i]); $j++) { 
                    $jadwalDetail = new JadwalDetail;
                    $jadwalDetail->id_jadwal = $increment;
                    $jadwalDetail->id_jam = ($i+1);
                    $jadwalDetail->id_guru = $request->array7[$i][$j];
                    $jadwalDetail->id_mata_pelajaran = $request->array7_mp[$i][$j];
                    $jadwalDetail->id_kelas = ($j+1);
                    $jadwalDetail->save();
                }
            }

            $count8 = count($request->array8);
            //input kelas 8
            for ($i=0; $i < $count8; $i++) { 
                for ($j=0; $j < count($request->array8[$i]); $j++) { 
                    $jadwalDetail = new JadwalDetail;
                    $jadwalDetail->id_jadwal = $increment;
                    $jadwalDetail->id_jam = ($i+1);
                    $jadwalDetail->id_guru = $request->array8[$i][$j];
                    $jadwalDetail->id_mata_pelajaran = $request->array8_mp[$i][$j];
                    $jadwalDetail->id_kelas = ($j+1+$count8); // slh
                    $jadwalDetail->save();
                }
            }

            $count9 = count($request->array9);
            //input kelas 9
            for ($i=0; $i < $count9; $i++) { 
                for ($j=0; $j < count($request->array9[$i]); $j++) { 
                    $jadwalDetail = new JadwalDetail;
                    $jadwalDetail->id_jadwal = $increment;
                    $jadwalDetail->id_jam = ($i+1);
                    $jadwalDetail->id_guru = $request->array9[$i][$j];
                    $jadwalDetail->id_mata_pelajaran = $request->array9_mp[$i][$j];
                    $jadwalDetail->id_kelas = ($j+1+$count8+$count9);
                    $jadwalDetail->save();
                }
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil di simpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 400,
                'message' => 'Data gagal di simpan',
                'error' => $e,
            ], 400);
        }        
    }
}
