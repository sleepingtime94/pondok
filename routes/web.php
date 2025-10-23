<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\PersyaratanController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\PengajuanUlangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserBaruController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\KomplainController;
use App\Models\SetupKel;
use Illuminate\Http\Request;

// === 1. ROUTE YANG SELALU BISA DIAKSES (MESKI JADWAL TUTUP) ===
Route::get('/formulir', [FormulirController::class, 'index'])->name('formulir.index');
Route::get('/formulir/download/{filename}', [FormulirController::class, 'download'])->name('formulir.download');
Route::get('/persyaratan', [PersyaratanController::class, 'index'])->name('persyaratan.index');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/desa', [LocationController::class, 'getDesa'])->name('get.desa');

// === 2. ROUTE YANG DILINDUNGI JADWAL ===
    // Homepage
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Rute yang memerlukan login
    Route::middleware(['auth'])->group(function () {
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');
        Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
        Route::get('/form_pengajuan', [PengajuanController::class, 'showForm']);
        Route::get('/api/jenis-layanan/filter/{keterangan}', [PengajuanController::class, 'getJenisLayananByKeterangan']);
        Route::get('/api/pengambilan-dokumen', [PengajuanController::class, 'getPengambilanDokumen'])->name('api.pengambilan.dokumen');
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi/{id_trx}/update-status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
        Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
        Route::get('/tracking/{id_trx}', [TrackingController::class, 'show'])->name('tracking.show');
        Route::get('/pengajuan-ulang/{id_trx}', [PengajuanUlangController::class, 'showForm'])->name('pengajuan.ulang.form');
        Route::post('/pengajuan-ulang/{id_trx}', [PengajuanUlangController::class, 'submitForm'])->name('pengajuan.ulang.submit');
        Route::delete('/api/hapus-file/{id}', [PengajuanUlangController::class, 'hapusFile'])->name('pengajuan.ulang.hapus.file');
    });

    // Rute publik yang dilindungi jadwal (tidak perlu login)
    Route::post('/submit-pengajuan', [PengajuanController::class, 'submitForm']);
    Route::post('/konfirmasi/{id}', [TransaksiController::class, 'konfirmasi'])->name('api.konfirmasi');
    Route::post('/api/nilai/{id}', [TransaksiController::class, 'submitRating'])->name('api.nilai');
    Route::post('/api/komplain/{id_trx}', [KomplainController::class, 'store'])->name('komplain.store');

// === 3. RUTE ADMIN (TIDAK TERKENA JADWAL) ===
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware([\App\Http\Middleware\AdminOperatorMiddleware::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/transaksi', [DashboardController::class, 'transaksiIndex'])->name('admin.transaksi.index');
        Route::get('/transaksi/{id_trx}', [DashboardController::class, 'show'])->name('admin.transaksi.show');
        Route::post('/transaksi/{id}/update-status', [DashboardController::class, 'updateStatus'])->name('admin.transaksi.update-status');
        Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/user', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
        Route::get('/user/export', [UserController::class, 'export'])->name('admin.user.export');
        Route::get('/user-baru', [UserBaruController::class, 'index'])->name('user_baru.index');
        Route::post('/dokumen/upload/{id_trx}', [DokumenController::class, 'upload'])->name('admin.dokumen.upload');
        Route::delete('/dokumen/delete/{id}', [DokumenController::class, 'delete'])->name('admin.dokumen.delete');
        Route::post('/user-baru/action/{id}', [UserBaruController::class, 'action'])->name('user_baru.action');
        Route::post('/user-baru/reset-otp/{id}', [UserBaruController::class, 'reset_otp'])->name('user_baru.reset_otp');
        Route::get('/desa', function (Request $request) {
            $kecamatanId = $request->query('kecamatan_id');
            if (!$kecamatanId) {
                return response()->json([]);
            }
            return SetupKel::where('kecamatan_id', $kecamatanId)
                ->select('kode_desa', 'nama')
                ->get();
        })->name('admin.desa');
        Route::patch('/user/{id}/blokir', [App\Http\Controllers\UserController::class, 'blokir'])->name('admin.user.blokir');
        Route::get('/jadwal', [App\Http\Controllers\Admin\JadwalController::class, 'index'])->name('admin.jadwal.index');
        Route::get('/jadwal/{id}/edit', [App\Http\Controllers\Admin\JadwalController::class, 'edit'])->name('admin.jadwal.edit');
        Route::put('/jadwal/{id}', [App\Http\Controllers\Admin\JadwalController::class, 'update'])->name('admin.jadwal.update');
        Route::put('/admin/user/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.user.update');
    });
});

// === 4. ROUTE DOKUMEN (SELALU BISA DIAKSES) ===
Route::get('/dokumen/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (strtolower($extension) !== 'pdf') {
        abort(403, 'Hanya file PDF yang diperbolehkan.');
    }
    return response()->file($filePath, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
    ]);
})->where('path', '.*')->name('dokumen.show');

// === 5. ROUTE AKTIVASI USER ===
Route::post('/users/{user}/activate', [UserBaruController::class, 'activate'])->name('users.activate');
