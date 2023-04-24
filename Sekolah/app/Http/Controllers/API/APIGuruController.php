<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GuruMapelDetail;
use Illuminate\Http\Request;
use App\Models\Guru;
use DB;

class APIGuruController extends Controller
{
    public function index()
    {
        try {
            $guru = Guru::all();
            if ($guru) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil ditampilkan',
                    'data' => $guru
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
            $guru = new Guru;
            $increment = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='" . env('DB_DATABASE') . "' AND TABLE_NAME ='" . $guru->getTable() . "'")[0]->AUTO_INCREMENT;
            $guru->kode_guru = "G".str_pad($increment,3,"0",STR_PAD_LEFT);
            $guru->nama_guru = $request->nama_guru;
            $guru->save();

            // foreach ($request->id_mata_pelajaran as $key => $value) {
            //     $guruMapelDetail = new GuruMapelDetail;
            //     $guruMapelDetail->id_guru = $increment;
            //     $guruMapelDetail->id_mata_pelajaran = $value[$key];
            //     $guruMapelDetail->save();
            // }

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil di simpan',
                'data' => $guru
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
            $guru = Guru::find($id);
            if ($guru) {
                $guru->nama_guru = $request->nama_guru;
                $guru->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil di update',
                    'data' => $guru
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
            $guru = Guru::find($id);
            if ($guru) {
                $guru->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil di update',
                    'data' => $guru
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

    public function destroyAll()
    {
        try {
            $guru = new Guru;
            DB::table($guru->getTable())->truncate();
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
