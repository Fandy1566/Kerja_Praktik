<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Database\Eloquent\Model;
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

// Route::get('/dashboard', function () {
//     return view('dashboard.home');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard.home');
})->name('dashboard');

Route::get('/guru', function () {
    return view('dashboard.guru.index');
})->name('guru');

Route::get('/mata_pelajaran', function () {
    return view('dashboard.mata_pelajaran.index');
})->name('mapel');

Route::get('/user', function () {
    return view('dashboard.user.index');
})->name('user');

Route::get('/kelas', function () {
    return view('dashboard.kelas.index');
})->name('kelas');

Route::get('/jam_pelajaran', function () {
    $hari = \App\Models\Hari::all();
    return view('dashboard.jam_pelajaran.index', compact('hari'));
})->name('jampel');

Route::get('/penjadwalan', function () {
    return view('dashboard.penjadwalan.index');
})->name('jadwal');

Route::get('/pengaturan', function () {
    return view('pengaturan');
})->name('pengaturan');

// Route::get('/login', function(){
//     return view('login.login');
// });
