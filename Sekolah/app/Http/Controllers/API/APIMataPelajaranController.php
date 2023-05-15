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
            foreach ($request->tingkat as $value) {
                $mataPelajaran = new MataPelajaran;
                $mataPelajaran->nama_mata_pelajaran = $request->nama_mata_pelajaran;
                $mataPelajaran->tingkat = $value;
                $mataPelajaran->banyak = $request->banyak;
                $mataPelajaran->save();
                $data[] = $mataPelajaran;
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil di simpan',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal di simpan',
                'error' => $e,
                'request' => $request->all()
            ],400);
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

    public function destroy(Request $request)
    {
        try {
            $berhasil = [];
            $gagal = [];
            $i = 0;
            $j = 0;
            foreach ($request->checkedCheckboxes as $value) {
                $mataPelajaran = MataPelajaran::find($value);
                if ($mataPelajaran) {
                    $mataPelajaran->delete();
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
                    'message' => 'Data tidak ditemukan',
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
            $mataPelajaran = new MataPelajaran;
            DB::table($mataPelajaran->getTable())->truncate();
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
