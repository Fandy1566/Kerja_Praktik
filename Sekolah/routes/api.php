<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\API\APIJadwalMengajarController;
Route::controller(APIJadwalMengajarController::class)->group( function() {
    Route::get('jadwal_mengajar', 'index');
    Route::post('jadwal_mengajar', 'store');
    Route::post('jadwal_mengajar/{id}', 'update');
    Route::delete('delete/jadwal_mengajar', 'destroy');

    Route::delete('reset/jadwal_mengajar', 'reset');
});

use App\Http\Controllers\API\APIUserController;
Route::controller(APIUserController::class)->group( function() {
    Route::get('guru', 'index');
    Route::post('guru', 'store');
    Route::post('guru/{id}', 'update');
    Route::delete('delete/guru', 'destroy');

    Route::delete('reset/guru', 'reset');
    Route::get('get_guru_detail', 'getGuruDetail');
    
});

use App\Http\Controllers\API\APIKelasController;
Route::controller(APIKelasController::class)->group( function() {
    Route::get('kelas', 'index');
    Route::post('kelas', 'store');
    Route::post('kelas/{id}', 'update');
    Route::delete('delete/kelas', 'destroy');

    Route::delete('reset/kelas', 'reset');
});

use App\Http\Controllers\API\APIMataPelajaranController;
Route::controller(APIMataPelajaranController::class)->group( function() {
    Route::get('mata_pelajaran', 'index');
    Route::post('mata_pelajaran', 'store');
    Route::post('mata_pelajaran/{id}', 'update');
    Route::delete('delete/mata_pelajaran', 'destroy');

    Route::get('get_guru_mata_pelajaran', 'getGuruMengajar');
    Route::delete('reset/mata_pelajaran', 'reset');
});

use App\Http\Controllers\API\APIJadwalController;
Route::controller(APIJadwalController::class)->group( function() {
    Route::post('jadwal', 'store');
    Route::post('jadwal/update', 'update');
});