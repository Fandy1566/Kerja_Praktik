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
            $kelas = Kelas::orderBy('tingkat', 'asc')
            ->orderBy('nama_kelas', 'asc')
            ->get();
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
            $count = DB::select("SELECT COUNT(tingkat) as Count FROM kelas WHERE tingkat = '".$request->tingkat."'")[0]->Count + 1;
            if ($request->tingkat == 7) {       
                $kelas->nama_kelas = "VII.".$count;
            } if ($request->tingkat == 8) {
                $kelas->nama_kelas = "VIII.".$count;
            } if ($request->tingkat == 9) {
                $kelas->nama_kelas = "IX.".$count;
            }          
            $kelas->lantai = $request->lantai;
            $kelas->tingkat = $request->tingkat;
            $kelas->save();
            return response()->json([
                'status' => 200,
                'message' => 'Data '.$kelas->nama_kelas.' berhasil di simpan',
                'data' => $kelas,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal di simpan',
                'error' => $e,
                'request' => $request
            ],400);
        }        
    }

    public function update(Request $request, string $id)
    {
        try {
            $kelas = Kelas::find($id);
            if ($kelas) {
                $kelas->lantai = $request->lantai;
                $kelas->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data '.$kelas->nama_kelas.' berhasil di update',
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

    public function destroy(Request $request)
    {
        try {
            $berhasil = [];
            $gagal = [];
            $i = 0;
            $j = 0;
            foreach ($request->checkedCheckboxes as $value) {
                $kelas = Kelas::find($value);
                if ($kelas) {
                    $kelas->isDeleted = 1;
                    $kelas->save();
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
                    'message' => 'Data Berhasil dihapus',
                    'data' => array(
                        "Berhasil" => $berhasil,
                        "Gagal" => $gagal
                    ),
                    'check' => $request->checkedCheckboxes,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data gagal dihapus',
                    'check' => $request->checkedCheckboxes,
                ],400);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal dihapus',
                'error' => $e,
                'check' => $request->checkedCheckboxes,
            ],400);
        }
        
    }
}
