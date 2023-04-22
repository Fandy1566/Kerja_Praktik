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
    return view('dashboard.home');
});

use App\Http\Controllers\GuruController;
Route::resource('/guru', GuruController::class)->except(['store', 'update', 'destroy']);

use App\Http\Controllers\MataPelajaranController;
Route::resource('/mata_pelajaran', MataPelajaranController::class)->except(['store', 'update', 'destroy']);;

use App\Http\Controllers\UserController;
Route::resource('/user', UserController::class)->except(['store', 'update', 'destroy']);;

use App\Http\Controllers\KelasController;
Route::resource('/kelas', KelasController::class)->except(['store', 'update', 'destroy']);;

use App\Http\Controllers\JadwalMengajarController;
Route::resource('/jadwal_mengajar', JadwalMengajarController::class)->except(['store', 'update', 'destroy']);;

use App\Http\Controllers\PenjadwalanController;
Route::get('/penjadwalan', [PenjadwalanController::class, 'index']);

Route::get('/login', function(){
    return view('login.login');
});
