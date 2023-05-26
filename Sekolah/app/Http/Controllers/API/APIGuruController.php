<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GuruKelasDetail;
use App\Models\GuruMataPelajaran;
use Illuminate\Http\Request;
use App\Models\Guru;
use DB;

class APIGuruController extends Controller
{
    public function index()
    {
        try {
            $guru = Guru::with(['GuruMataPelajaran' => function ($query) {
                $query->with('MataPelajaran');
            }])->get();
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
        
            $guru = new Guru;
            $increment = DB::select("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA ='" . env('DB_DATABASE') . "' AND TABLE_NAME ='" . $guru->getTable() . "'")[0]->AUTO_INCREMENT;
            $guru->nama_guru = $request->nama_guru;
            $guru->is_guru_tetap = $request->is_guru_tetap;
            $guru->save();

            foreach ($request->id_mata_pelajaran as $value) {
                $guruMapelDetail = new GuruMataPelajaran;
                $guruMapelDetail->id_guru = $increment;
                $guruMapelDetail->id_mata_pelajaran = $value;
                $guruMapelDetail->save();
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
                'request' => $request->all()
            ], 400);
        }        
    }

    public function update(Request $request, string $id)
    {
        DB::beginTransaction(); 

        try {
            $guru = Guru::find($id);
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
                $guru = Guru::find($value);
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
            $guru = new Guru;
            DB::delete('DELETE FROM '.$guru->getTable().';');
            DB::statement('ALTER TABLE '.$guru->getTable().' AUTO_INCREMENT = 1;');
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

    public function getGuruDetail()
    {
        try {
            $guru = GuruMataPelajaran::with('Guru','MataPelajaran')->get();
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
