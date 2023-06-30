<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenjadwalanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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
    return redirect()->route('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard.home');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard',[HomeController::class, 'index'])->name('dashboard');

    Route::get('/guru', function () {
        return view('dashboard.guru.index');
    })->name('guru');

    Route::get('/mata_pelajaran', function () {
        return view('dashboard.mata_pelajaran.index');
    })->name('mapel');

    Route::get('/kelas', function () {
        return view('dashboard.kelas.index');
    })->name('kelas');

    Route::get('/jam_pelajaran', function () {
        $hari = \App\Models\Hari::all();
        return view('dashboard.jam_pelajaran.index', compact('hari'));
    })->name('jampel');

    Route::get('/penjadwalan', [PenjadwalanController::class, 'index'])->name('jadwal');
    Route::get('/penjadwalan/create', [PenjadwalanController::class, 'create'])->name('jadwal.create');
    Route::get('/penjadwalan/show', [PenjadwalanController::class, 'show'])->name('jadwal.show');
    Route::get('/penjadwalan/edit/{id}', [PenjadwalanController::class, 'edit'])->name('jadwal.edit');
    Route::post('/penjadwalan/validasi/{id}', [PenjadwalanController::class, 'validasi'])->name('jadwal.validasi');
    Route::get('/penjadwalan/print/{id}', [PenjadwalanController::class, 'print'])->name('jadwal.print');
    Route::get('/penjadwalan/show/kelas', [PenjadwalanController::class, 'showKelas'])->name('jadwal.showKelas');
    Route::delete('/jadwal/delete/{id}', [PenjadwalanController::class, 'destroy'])->name('jadwal.delete');
    Route::patch('/user/edit/{id}', [UserController::class, 'update'])->name('user.edit');

    Route::get('/pengaturan', function () {
        $user = App\Models\User::find(Auth::user()->id);
        return view('pengaturan', compact('user'));
    })->name('pengaturan');
    

});

require __DIR__.'/auth.php';
// Route::get('/login', function(){
//     return view('login.login');
// });
