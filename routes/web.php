<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\VerifikasiController as AdminVerifikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\NotifikasiController as MahasiswaNotifikasiController;
use App\Http\Controllers\Mahasiswa\PrestasiController as MahasiswaPrestasiController;
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboardController;
use App\Http\Controllers\Pimpinan\PrestasiController as PimpinanPrestasiController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Beranda / Landing Page (Lap. hal. 100-101)
Route::get('/', function () {
    $user = Auth::user();

    if ($user) {
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if (method_exists($user, 'isPimpinan') && $user->isPimpinan()) {
            return redirect()->route('pimpinan.dashboard');
        }

        if (method_exists($user, 'isMahasiswa') && $user->isMahasiswa()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return redirect()->route('mahasiswa.dashboard');
    }

    return redirect()->route('login');
})->name('landing');

// Halaman Pemilihan Peran Pengguna (Lap. hal. 101-102)
Route::get('/pilih-peran', fn () => view('auth.role-selection'))->name('pilih-peran');

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');

    // Pembatasan percobaan login (NF-08)
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil & akun (F-02, F-16, Lap. hal. 105, 106, 117, 118)
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    // Sertifikat & dokumentasi: disk privat (NF-14)
    Route::get('/berkas/sertifikat/{sertifikat}', [BerkasController::class, 'sertifikat'])
        ->whereNumber('sertifikat')
        ->name('berkas.sertifikat');
    Route::get('/berkas/dokumentasi/{dokumentasi}', [BerkasController::class, 'dokumentasi'])
        ->whereNumber('dokumentasi')
        ->name('berkas.dokumentasi');

    // ---------------- Area Mahasiswa ----------------
    Route::prefix('mahasiswa')
        ->name('mahasiswa.')
        ->middleware('role:mahasiswa')
        ->group(function () {
            // Dashboard Mahasiswa (Lap. hal. 103-104)
            Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');

            // Riwayat & Manajemen Data Prestasi (Lap. hal. 106-111)
            Route::get('/prestasi', [MahasiswaPrestasiController::class, 'index'])->name('prestasi.index');
            Route::get('/prestasi/create', [MahasiswaPrestasiController::class, 'create'])->name('prestasi.create');
            Route::post('/prestasi', [MahasiswaPrestasiController::class, 'store'])->name('prestasi.store');

            // Navigasi cepat Upload Sertifikat & Dokumentasi (Lap. hal. 107-109)
            Route::get('/upload-sertifikat', fn () => redirect()->route('mahasiswa.prestasi.create', ['step' => 'sertifikat']))->name('upload.sertifikat');
            Route::get('/upload-dokumentasi', fn () => redirect()->route('mahasiswa.prestasi.create', ['step' => 'dokumentasi']))->name('upload.dokumentasi');

            Route::get('/prestasi/{prestasi}', [MahasiswaPrestasiController::class, 'show'])
                ->whereNumber('prestasi')->name('prestasi.show');
            Route::get('/prestasi/{prestasi}/edit', [MahasiswaPrestasiController::class, 'edit'])
                ->whereNumber('prestasi')->name('prestasi.edit');
            Route::put('/prestasi/{prestasi}', [MahasiswaPrestasiController::class, 'update'])
                ->whereNumber('prestasi')->name('prestasi.update');

            // Notifikasi (Lap. hal. 111-112)
            Route::get('/notifikasi', [MahasiswaNotifikasiController::class, 'index'])->name('notifikasi.index');
            Route::post('/notifikasi/baca-semua', [MahasiswaNotifikasiController::class, 'bacaSemua'])->name('notifikasi.baca-semua');
        });

    // ---------------- Area Admin ----------------
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function () {
            // Dashboard Admin (Lap. hal. 115-116)
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Rekapitulasi Data Prestasi (Lap. hal. 123-124)
            Route::get('/rekapitulasi', [AdminDashboardController::class, 'rekapitulasi'])->name('rekapitulasi');

            // Riwayat Data Prestasi (Lap. hal. 124-125)
            Route::get('/riwayat', [AdminDashboardController::class, 'riwayat'])->name('riwayat');

            // Pengolahan & Verifikasi Data Prestasi (Lap. hal. 118-122)
            Route::get('/verifikasi', [AdminVerifikasiController::class, 'index'])->name('verifikasi.index');
            Route::get('/verifikasi/{prestasi}', [AdminVerifikasiController::class, 'show'])
                ->whereNumber('prestasi')->name('verifikasi.show');
            Route::patch('/verifikasi/{prestasi}', [AdminVerifikasiController::class, 'verifikasi'])
                ->whereNumber('prestasi')->name('verifikasi.proses');
            Route::delete('/verifikasi/{prestasi}', [AdminVerifikasiController::class, 'destroy'])
                ->whereNumber('prestasi')->name('verifikasi.destroy');

            // Manajemen data mahasiswa
            Route::get('/mahasiswa', [AdminMahasiswaController::class, 'index'])->name('mahasiswa.index');
            Route::get('/mahasiswa/create', [AdminMahasiswaController::class, 'create'])->name('mahasiswa.create');
            Route::post('/mahasiswa', [AdminMahasiswaController::class, 'store'])->name('mahasiswa.store');
            Route::get('/mahasiswa/{mahasiswa}', [AdminMahasiswaController::class, 'show'])
                ->whereNumber('mahasiswa')->name('mahasiswa.show');
            Route::get('/mahasiswa/{mahasiswa}/edit', [AdminMahasiswaController::class, 'edit'])
                ->whereNumber('mahasiswa')->name('mahasiswa.edit');
            Route::put('/mahasiswa/{mahasiswa}', [AdminMahasiswaController::class, 'update'])
                ->whereNumber('mahasiswa')->name('mahasiswa.update');
        });

    // ---------------- Area Pimpinan ----------------
    Route::prefix('pimpinan')
        ->name('pimpinan.')
        ->middleware('role:pimpinan')
        ->group(function () {
            // Dashboard Pimpinan (Lap. hal. 127-128)
            Route::get('/dashboard', [PimpinanDashboardController::class, 'index'])->name('dashboard');

            // Rekapitulasi Data Prestasi Pimpinan (Lap. hal. 128-130)
            Route::get('/rekapitulasi', [PimpinanDashboardController::class, 'rekapitulasi'])->name('rekapitulasi');

            // Data Prestasi Pimpinan (Lap. hal. 130-131)
            Route::get('/prestasi', [PimpinanPrestasiController::class, 'index'])->name('prestasi.index');
            Route::get('/prestasi/{prestasi}', [PimpinanPrestasiController::class, 'show'])
                ->whereNumber('prestasi')->name('prestasi.show');
        });
});
