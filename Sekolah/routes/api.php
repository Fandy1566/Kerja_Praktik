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
Route::get('jadwal_mengajar', [APIJadwalMengajarController::class, 'index']);
Route::post('jadwal_mengajar', [APIJadwalMengajarController::class, 'store']);
Route::patch('jadwal_mengajar/{id}', [APIJadwalMengajarController::class, 'update']);
Route::delete('jadwal_mengajar/{id}', [APIJadwalMengajarController::class, 'destroy']);

use App\Http\Controllers\API\APIGuruController;
Route::get('guru', [APIGuruController::class, 'index']);
Route::post('guru', [APIGuruController::class, 'store']);
Route::patch('guru/{id}', [APIGuruController::class, 'update']);
Route::delete('guru/{id}', [APIGuruController::class, 'destroy']);