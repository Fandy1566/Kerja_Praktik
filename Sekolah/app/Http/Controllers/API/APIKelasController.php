<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use DB;
class APIKelasController extends Controller
{
    public function index()
    {
        try {
            $kelas = DB::select("SELECT * FROM kelas ORDER BY tingkat ASC, nama_kelas ASC");
            if ($kelas) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil ditampilkan',
                    'data' => $kelas
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
            $kelas = new Kelas;
            $increment = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='" . env('DB_DATABASE') . "' AND TABLE_NAME ='" . $kelas->getTable() . "'")[0]->AUTO_INCREMENT;
            $kelas->kode_kelas = "K".str_pad($increment,3,"0",STR_PAD_LEFT);
            $count = DB::select("SELECT COUNT(tingkat) as Count FROM kelas WHERE tingkat = '".$request->tingkat."'")[0]->Count + 1;
            if ($request->tingkat == 7) {       
                $kelas->nama_kelas = "VII.".$count;
            } if ($request->tingkat == 8) {
                $kelas->nama_kelas = "VIII.".$count;
            } if ($request->tingkat == 9) {
                $kelas->nama_kelas = "IX.".$count;
            }
            $kelas->tingkat = $request->tingkat;
            $kelas->save();
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil di simpan',
                'data' => $kelas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal di simpan',
                'error' => $e
            ],400);
        }        
    }

    public function update(Request $request, string $id)
    {
        try {
            $kelas = Kelas::find($id);
            if ($kelas) {
                $kelas->nama_kelas = $request->nama_kelas;
                $kelas->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil di update',
                    'data' => $kelas
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
                'message' => 'Data gagal diupdate',
                'error' => $e
            ],400);
        }
    }

    public function destroy(string $id)
    {
        try {
            $kelas = Kelas::find($id);
            if ($kelas) {
                $kelas->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil di update',
                    'data' => $kelas
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
                'message' => 'Data gagal dihapus',
                'error' => $e
            ],400);
        }
        
    }
}
