<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use DB;

class APIMataPelajaranController extends Controller
{
    public function index()
    {
        try {
            $mataPelajaran = MataPelajaran::all();
            if ($mataPelajaran) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil ditampilkan',
                    'data' => $mataPelajaran
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
            $mataPelajaran = new MataPelajaran;
            $increment = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='" . env('DB_DATABASE') . "' AND TABLE_NAME ='" . $mataPelajaran->getTable() . "'")[0]->AUTO_INCREMENT;
            $mataPelajaran->kode_mata_pelajaran = "G".str_pad($increment,3,"0",STR_PAD_LEFT);
            $mataPelajaran->nama_mata_pelajaran = $request->nama_mata_pelajaran;
            $mataPelajaran->tingkat = $request->tingkat;
            $mataPelajaran->banyak = $request->banyak;
            $mataPelajaran->save();
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil di simpan',
                'data' => $mataPelajaran
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal di simpan',
                'error' => $e
            ], 400);
        }        
    }

    public function update(Request $request, string $id)
    {
        try {
            $mataPelajaran = MataPelajaran::find($id);
            if ($mataPelajaran) {
                $mataPelajaran->nama_mata_pelajaran = $request->nama_mata_pelajaran;
                $mataPelajaran->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil di update',
                    'data' => $mataPelajaran
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
            $mataPelajaran = MataPelajaran::find($id);
            if ($mataPelajaran) {
                $mataPelajaran->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil di update',
                    'data' => $mataPelajaran
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
