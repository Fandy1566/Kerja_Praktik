<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use DB;

class APIJadwalMengajarController extends Controller
{
    public function store(Request $request)
    {
        try {
            $jadwalMengajar = new JadwalMengajar;
            $increment = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='" . env('DB_DATABASE') . "' AND TABLE_NAME ='" . $jadwalMengajar->getTable() . "'")[0]->AUTO_INCREMENT;
            $jadwalMengajar->kode_jadwal_mengajar = "J".str_pad($increment,3,"0",STR_PAD_LEFT);
            $jadwalMengajar->id_hari = $request->id_hari;
            $jadwalMengajar->waktu_awal = $request->waktu_awal;
            $jadwalMengajar->waktu_akhir = $request->waktu_akhir;
            $jadwalMengajar->save();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'failed to save data',
                'error' => $e
            ], 400);
        }        
    }

    public function update(Request $request, string $id)
    {
        try {
            $jadwalMengajar = JadwalMengajar::find($id);
            if ($jadwalMengajar) {
                $jadwalMengajar->id_hari = $request->id_hari;
                $jadwalMengajar->waktu_awal = $request->waktu_awal;
                $jadwalMengajar->waktu_akhir = $request->waktu_akhir;
                $jadwalMengajar->save();
                return response()->json([
                    'status' => 200,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'failed to update data',
                ],400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'failed to update data',
                'error' => $e
            ],400);
        }
    }
}
