<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\GuruController;
Route::resource('/guru', GuruController::class);

use App\Http\Controllers\JamMengajarController;
Route::resource('/jam_mengajar', JamMengajarController::class);

use App\Http\Controllers\MataPelajaranController;
Route::resource('/mata_pelajaran', MataPelajaranController::class);

use App\Http\Controllers\SiswaController;
Route::resource('/siswa', SiswaController::class);

use App\Http\Controllers\UserController;
Route::resource('/user', UserController::class);
