<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IdentitasSekolahController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PilihanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\VoteController;

// ========== ROUTES PUBLIK SISWA (Tanpa Auth) ========== //
Route::get("/", [UserAuthController::class, "showLanding"])->name("landing");
Route::get("terimakasih", [VoteController::class, "terimakasih"])->name("terimakasih");

// ========== ROUTES GUEST SISWA (Hanya bisa diakses jika BELUM login) ========== //
Route::middleware("siswa.guest")->group(function () {
    Route::get("login", [UserAuthController::class, "showLoginForm"])->name("login");
    Route::post("login", [UserAuthController::class, "login"])->name("login.submit");
});

// ========== ROUTES PROTECTED SISWA (Harus login) ========== //
Route::middleware("siswa.auth")->group(function () {
    Route::get("vote", [VoteController::class, "index"])->name("vote");
    Route::post("vote", [VoteController::class, "store"])->name("vote.submit");
    Route::post("logout", [UserAuthController::class, "logout"])->name("logout");
});

// ========== ROUTES ADMIN ========== //
Route::prefix("admin")->name("admin.")->group(function () {
    Route::middleware("admin.guest")->group(function () {
        Route::get("login", [AdminAuthController::class, "showLoginForm"])->name("login");
        Route::post("login", [AdminAuthController::class, "login"])->name("login.submit");
    });

    Route::middleware("admin.auth")->group(function () {
        // Dashboard & Reset
        Route::get("dashboard", [DashboardController::class, "index"])->name("dashboard");
        Route::post("dashboard/reset", [DashboardController::class, "resetVoting"])->name("dashboard.reset");
        
        // Ganti Password Admin
        Route::post("password/update", [AdminAuthController::class, "changePassword"])->name("password.update");

        // Identitas Sekolah
        Route::get("identitas", [IdentitasSekolahController::class, "index"])->name("identitas.index");
        Route::post("identitas/update", [IdentitasSekolahController::class, "update"])->name("identitas.update");

        // Kelas
        Route::resource('kelas', KelasController::class)->except(['create', 'show', 'edit']);

        // Siswa (DPT)
        Route::post('siswa/delete-all', [SiswaController::class, 'deleteAll'])->name('siswa.deleteAll');
        Route::post('siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
        Route::get('siswa/template', [SiswaController::class, 'downloadTemplate'])->name('siswa.template');
        Route::resource('siswa', SiswaController::class)->except(['create', 'show', 'edit']);

        // Kandidat (Pilihan)
        Route::resource('kandidat', PilihanController::class)->except(['create', 'show', 'edit']);

        // Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('laporan/pdf-golput', [LaporanController::class, 'exportGolputPdf'])->name('laporan.pdf_golput');

        // Auth Admin
        Route::post("logout", [AdminAuthController::class, "logout"])->name("logout");
    });
});


