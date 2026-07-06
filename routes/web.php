<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('session.login:admin,verifikator')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/lihat-file', [FileController::class, 'preview'])->name('files.preview');
    Route::get('/download', [FileController::class, 'download'])->name('files.download');
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/kelola-laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/rekap-laporan', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/export-word', [RekapController::class, 'exportWord'])->name('rekap.word');
    Route::get('/export-excel', [RekapController::class, 'exportExcel'])->name('rekap.excel');
});

Route::middleware('session.login:admin')->group(function () {
    Route::get('/input-laporan', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/input-laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/lihat-laporan', fn () => redirect()->route('laporan.index'))->name('laporan.redirect');
    Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/cms/footer', [FooterController::class, 'edit'])->name('cms.footer.edit');
    Route::put('/cms/footer', [FooterController::class, 'update'])->name('cms.footer.update');
});

Route::middleware('session.login:verifikator')->group(function () {
    Route::get('/verifikasi-laporan', fn () => redirect()->route('laporan.index'))->name('verifikasi.index');
    Route::post('/verifikasi-laporan/{laporan}/{aksi}', [VerifikasiController::class, 'update'])->name('verifikasi.update');
});
