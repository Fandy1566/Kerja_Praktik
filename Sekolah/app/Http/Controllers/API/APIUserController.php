<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GuruKelasDetail;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class APIUserController extends Controller
{
    public function index()
    {
        try {
            $guru = User::with('GuruDetail')->where('is_admin','=','0')->get();
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
            $guru->save();

            foreach ($request->kelas as $value) {
                $GuruKelasDetail = new GuruKelasDetail;
                $GuruKelasDetail->id_guru = $increment;
                $GuruKelasDetail->tingkat = $value;
                $GuruKelasDetail->save();
            }

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
                $guru->nama_guru = $request->nama_guru;
                $guru->is_guru_tetap = $request->is_guru_tetap;
                $guru->save();

                foreach ($request->kelas as $value) {
                    $guruMapelDetail = new GuruKelasDetail;
                    $guruMapelDetail->id_guru = $id;
                    $guruMapelDetail->kelas = $value;
                    $guruMapelDetail->save();
                }

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
            $guru = new User;
            DB::table($guru->getTable())->where('is_admin', 0)->delete();
            $count = User::where('is_admin', 1)->count();
            DB::statement('ALTER TABLE '.$guru->getTable().' AUTO_INCREMENT = '.($count+1).';');
            return response()->json([
                'status' => 200,
                'message' => 'Semua data berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Data gagal dihapus',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
    public function getGuruDetail()
    {
        try {
            $guru = GuruKelasDetail::with('User','MataPelajaran')->get();
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
