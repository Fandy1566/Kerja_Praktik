<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use App\Models\Hari;
use DB;

class APIJadwalMengajarController extends Controller
{
    public function index()
    {
        try {
            $jadwalMengajar = DB::SELECT("SELECT jadwal_mengajar.*, hari.nama_hari
            FROM (jadwal_mengajar INNER JOIN hari ON jadwal_mengajar.id_hari = hari.id)
            ORDER BY jadwal_mengajar.id_hari ASC, jadwal_mengajar.waktu_awal ASC;");
            if ($jadwalMengajar) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil ditampilkan',
                    'data' => $jadwalMengajar
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data tidak ditemukan',
                ],400);
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
            $jadwalMengajar = new JadwalMengajar;
            $jadwalMengajar->id_hari = $request->id_hari;
            $jadwalMengajar->waktu_awal = $request->waktu_awal;
            $jadwalMengajar->waktu_akhir = $request->waktu_akhir;
            $jadwalMengajar->save();
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil di simpan',
                'data' => $jadwalMengajar
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
                    'message' => 'Berhasil mengupdate data',
                    'data' => $jadwalMengajar,
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
                'data' => $request,
                'error' => $e
            ],400);
        }
    }
    public function destroy(Request $request)
    {
        try {
            $berhasil = [];
            $gagal = [];
            $i = 0;
            $j = 0;
            foreach ($request->checkedCheckboxes as $value) {
                $jadwalMengajar = JadwalMengajar::find($value);
                if ($jadwalMengajar) {
                    $jadwalMengajar->isDeleted = 1;
                    $jadwalMengajar->save();
                    $berhasil[$i] = $value;
                    $i++;
                } else {
                    $gagal[$j] = $value;
                    $j++;
                }
            }

            if ($i > 0) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil dihapus',
                    'data' => array(
                        "Berhasil" => $berhasil,
                        "Gagal" => $gagal
                    )
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data gagal dihapus',
                ],400);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal dihapus',
                'error' => $e
            ],400);
        }
        
    }

    public function reset()
    {
        try {
            $jadwalMengajar = new JadwalMengajar;
            DB::delete('DELETE FROM '.$jadwalMengajar->getTable().';');
            DB::statement('ALTER TABLE '.$jadwalMengajar->getTable().' AUTO_INCREMENT = 1;');
            return response()->json([
                'status' => 200,
                'message' => 'Semua data berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal dihapus',
                'error' => $e
            ],400);
        }
    }
}
