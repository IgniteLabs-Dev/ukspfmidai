<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Livewire\ManajemenUser;
use App\Livewire\PengajuanCuti;
use App\Livewire\PengajuanIzin;
use App\Livewire\RiwayatCuti;
use App\Livewire\RiwayatIzin;
use App\Livewire\PermohonanIzin;
use App\Livewire\Dashboard as DashboardLivewire;
use App\Livewire\PermohonanCuti;
use App\Livewire\PreviewCuti;
use App\Livewire\PreviewIzin;

Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login-store', [AuthController::class, 'loginStore'])->name('login-store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', fn() => view('pages.register'))->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/', DashboardLivewire::class)->name('index');
    Route::get('/manajemen-user', ManajemenUser::class)->name('manajemen-user');
    Route::get('/manajemen-user/{id}/cuti', fn($id) => view('pages.manajamen-cuti-user', ['id' => $id]))->name('manajemen-cuti-user');
    Route::get('/pengajuan-cuti', PengajuanCuti::class)->name('pengajuan-cuti');
    Route::get('/pengajuan-izin', PengajuanIzin::class)->name('pengajuan-izin');
    Route::get('/riwayat-cuti', RiwayatCuti::class)->name('riwayat-cuti');
    Route::get('/riwayat-izin', RiwayatIzin::class)->name('riwayat-izin');
    Route::get('/permohonan-cuti', PermohonanCuti::class)->name('permohonan-cuti');
    Route::get('/{id}/preview-cuti', PreviewCuti::class)->name('preview-cuti');
    Route::get('/permohonan-izin', PermohonanIzin::class)->name('permohonan-izin');
    Route::get('/{id}/preview-izin', PreviewIzin::class)->name('preview-izin');
    Route::view('/manajemen-web', 'pages.manajemen-web')->name('manajemen-web');
});
