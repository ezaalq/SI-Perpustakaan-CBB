<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthPetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaSiswaController;
use App\Http\Controllers\AnggotaNonSiswaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamanSiswaController;
use App\Http\Controllers\PengembalianSiswaController;
use App\Http\Controllers\PeminjamanNonSiswaController;
use App\Http\Controllers\PengembalianNonSiswaController;
use App\Http\Controllers\LaporanController;
use App\Models\Buku;

// halaman utama sebelum login
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// login/logout petugas
Route::get('/login', [AuthPetugasController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthPetugasController::class, 'login']);
Route::post('/logout', [AuthPetugasController::class, 'logout'])->name('logout');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('/');
})->name('logout');

// halaman dashboard setelah login
Route::middleware(['auth:petugas'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD master data
    Route::resource('buku', BukuController::class);
    Route::resource('anggota-siswa', AnggotaSiswaController::class);
    Route::resource('anggota-non-siswa', AnggotaNonSiswaController::class);
    Route::resource('petugas', PetugasController::class);

    // peminjaman & pengembalian
    Route::resource('peminjaman-siswa', PeminjamanSiswaController::class);
    Route::resource('pengembalian-siswa', PengembalianSiswaController::class);
    Route::resource('peminjaman-non-siswa', PeminjamanNonSiswaController::class);
    Route::resource('pengembalian-non-siswa', PengembalianNonSiswaController::class);

    // laporan
    Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/buku', [LaporanController::class, 'buku'])->name('laporan.buku');
    Route::get('/laporan/anggota', [LaporanController::class, 'anggota'])->name('laporan.anggota');
    Route::get('/laporan/denda', [LaporanController::class, 'denda'])->name('laporan.denda');

    // laporan PDF
    Route::get('/laporan/peminjaman/pdf', [LaporanController::class, 'peminjamanPdf'])->name('laporan.peminjaman.pdf');
    Route::get('/laporan/pengembalian/pdf', [LaporanController::class, 'pengembalianPdf'])->name('laporan.pengembalian.pdf');
    Route::get('/laporan/buku/pdf', [LaporanController::class, 'bukuPdf'])->name('laporan.buku.pdf');
    Route::get('/laporan/anggota/pdf', [LaporanController::class, 'anggotaPdf'])->name('laporan.anggota.pdf');
    Route::get('/laporan/denda/pdf', [LaporanController::class, 'dendaPdf'])->name('laporan.denda.pdf');

    // ini route API
    Route::get('/api/buku/{kode}', function ($kode) {
        return response()->json(Buku::findOrFail($kode));
    });
    Route::get('/api/peminjaman-ns/{no}', [PengembalianNonSiswaController::class, 'getPeminjaman']);
    Route::get('/api/peminjaman/{no}', [PengembalianSiswaController::class, 'getPeminjaman']);


});
