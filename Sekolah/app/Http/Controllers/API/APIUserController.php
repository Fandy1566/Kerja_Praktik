<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GuruDetail;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class APIUserController extends Controller
{
    public function index()
    {
        try {
            $guru = User::all();
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
                'error' => $e
            ],400);
        }
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction(); 
        
            $guru = new User;
            $increment = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='" . env('DB_DATABASE') . "' AND TABLE_NAME ='" . $guru->getTable() . "'")[0]->AUTO_INCREMENT;
            $guru->name = $request->nama_guru;
            $guru->password = bcrypt("1234567890");
            $guru->is_guru_tetap = $request->is_guru_tetap;
            $guru->email = "guru".$increment."@smpn23.com";
            $guru->is_guru_kelas_7 = in_array('7', $request->kelas) ? 1 : 0;
            $guru->is_guru_kelas_8 = in_array('8', $request->kelas) ? 1 : 0;
            $guru->is_guru_kelas_9 = in_array('9', $request->kelas) ? 1 : 0;
            $guru->save();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Data '.$guru->nama_guru.' berhasil di simpan',
                'data' => $guru
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

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction(); 
            
            $guru = User::find($id);
            if ($guru) {
                $guru->name = $request->nama_guru;
                $guru->is_guru_tetap = $request->is_guru_tetap;
                $guru->is_guru_kelas_7 = in_array('7', $request->kelas) ? 1 : 0;
                $guru->is_guru_kelas_8 = in_array('8', $request->kelas) ? 1 : 0;
                $guru->is_guru_kelas_9 = in_array('9', $request->kelas) ? 1 : 0;
                $guru->save();

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data '.$guru->nama_guru.' berhasil di update',
                    'data' => $guru
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Data tidak ditemukan',
                ],400);
            }

        } catch (\Exception $e) {
            DB::rollBack();

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
                $guru = User::find($value);
                if ($guru) {
                    $guru->delete();
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

    public function getGuruDetail()
    {
        try {
            $guru = GuruDetail::with('User','MataPelajaran')->get();
            return response()->json([
                'status' => 200,
                'message' => 'berhasil ditampilkan',
                'data' => $guru
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
