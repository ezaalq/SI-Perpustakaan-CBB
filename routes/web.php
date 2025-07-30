<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Login & Logout
Route::get('/login', [AuthPetugasController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthPetugasController::class, 'login']);
Route::post('/logout', [AuthPetugasController::class, 'logout'])->name('logout');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome');
})->name('logout');

Route::middleware(['auth:petugas'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Resource
    Route::resource('buku', BukuController::class);
    Route::resource('anggota-siswa', AnggotaSiswaController::class);
    Route::resource('anggota-non-siswa', AnggotaNonSiswaController::class);
    Route::resource('petugas', PetugasController::class);
    Route::resource('peminjaman-siswa', PeminjamanSiswaController::class);
    Route::resource('pengembalian-siswa', PengembalianSiswaController::class);
    Route::resource('peminjaman-non-siswa', PeminjamanNonSiswaController::class);
    Route::resource('pengembalian-non-siswa', PengembalianNonSiswaController::class);

    // TRASH & RESTORE (Soft Delete)
    Route::prefix('trash')->group(function () {
        Route::get('/buku', [BukuController::class, 'trash'])->name('buku.trash');
        Route::get('/anggota-siswa', [AnggotaSiswaController::class, 'trash'])->name('anggota-siswa.trash');
        Route::get('/anggota-non-siswa', [AnggotaNonSiswaController::class, 'trash'])->name('anggota-non-siswa.trash');
        Route::get('/petugas', [PetugasController::class, 'trash'])->name('petugas.trash');
        Route::get('/peminjaman-siswa', [PeminjamanSiswaController::class, 'trash'])->name('peminjaman-siswa.trash');
        Route::get('/pengembalian-siswa', [PengembalianSiswaController::class, 'trash'])->name('pengembalian-siswa.trash');
        Route::get('/peminjaman-non-siswa', [PeminjamanNonSiswaController::class, 'trash'])->name('peminjaman-non-siswa.trash');
        Route::get('/pengembalian-non-siswa', [PengembalianNonSiswaController::class, 'trash'])->name('pengembalian-non-siswa.trash');
    });

    Route::prefix('restore')->group(function () {
        Route::put('/buku/{id}', [BukuController::class, 'restore'])->name('buku.restore');
        Route::put('/anggota-siswa/{id}', [AnggotaSiswaController::class, 'restore'])->name('anggota-siswa.restore');
        Route::put('/anggota-non-siswa/{id}', [AnggotaNonSiswaController::class, 'restore'])->name('anggota-non-siswa.restore');
        Route::put('/petugas/{id}', [PetugasController::class, 'restore'])->name('petugas.restore');
        Route::put('/peminjaman-siswa/{id}', [PeminjamanSiswaController::class, 'restore'])->name('peminjaman-siswa.restore');
        Route::put('/pengembalian-siswa/{id}', [PengembalianSiswaController::class, 'restore'])->name('pengembalian-siswa.restore');
        Route::put('/peminjaman-non-siswa/{id}', [PeminjamanNonSiswaController::class, 'restore'])->name('peminjaman-non-siswa.restore');
        Route::put('/pengembalian-non-siswa/{id}', [PengembalianNonSiswaController::class, 'restore'])->name('pengembalian-non-siswa.restore');
    });

    Route::prefix('force-delete')->group(function () {
        Route::delete('/buku/{id}', [BukuController::class, 'forceDelete'])->name('buku.forceDelete');
        Route::delete('/anggota-siswa/{id}', [AnggotaSiswaController::class, 'forceDelete'])->name('anggota-siswa.forceDelete');
        Route::delete('/anggota-non-siswa/{id}', [AnggotaNonSiswaController::class, 'forceDelete'])->name('anggota-non-siswa.forceDelete');
        Route::delete('/petugas/{id}', [PetugasController::class, 'forceDelete'])->name('petugas.forceDelete');
        Route::delete('/peminjaman-siswa/{id}', [PeminjamanSiswaController::class, 'forceDelete'])->name('peminjaman-siswa.forceDelete');
        Route::delete('/pengembalian-siswa/{id}', [PengembalianSiswaController::class, 'forceDelete'])->name('pengembalian-siswa.forceDelete');
        Route::delete('/peminjaman-non-siswa/{id}', [PeminjamanNonSiswaController::class, 'forceDelete'])->name('peminjaman-non-siswa.forceDelete');
        Route::delete('/pengembalian-non-siswa/{id}', [PengembalianNonSiswaController::class, 'forceDelete'])->name('pengembalian-non-siswa.forceDelete');
    });

    // LAPORAN
    Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/buku', [LaporanController::class, 'buku'])->name('laporan.buku');
    Route::get('/laporan/anggota', [LaporanController::class, 'anggota'])->name('laporan.anggota');
    Route::get('/laporan/denda', [LaporanController::class, 'denda'])->name('laporan.denda');

    // LAPORAN PDF
    Route::get('/laporan/peminjaman/pdf', [LaporanController::class, 'peminjamanPdf'])->name('laporan.peminjaman.pdf');
    Route::get('/laporan/pengembalian/pdf', [LaporanController::class, 'pengembalianPdf'])->name('laporan.pengembalian.pdf');
    Route::get('/laporan/buku/pdf', [LaporanController::class, 'bukuPdf'])->name('laporan.buku.pdf');
    Route::get('/laporan/anggota/pdf', [LaporanController::class, 'anggotaPdf'])->name('laporan.anggota.pdf');
    Route::get('/laporan/denda/pdf', [LaporanController::class, 'dendaPdf'])->name('laporan.denda.pdf');

    // API
    Route::get('/api/buku/{kode}', fn($kode) => response()->json(Buku::findOrFail($kode)));
    Route::get('/api/peminjaman-ns/{no}', [PengembalianNonSiswaController::class, 'getPeminjaman']);
    Route::get('/api/peminjaman/{no}', [PengembalianSiswaController::class, 'getPeminjaman']);
});
