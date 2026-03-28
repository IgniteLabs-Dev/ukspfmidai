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
use App\Livewire\ManajemenBerita;
use \App\Http\Controllers\BeritaController;
use \App\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/berita/{id}', [IndexController::class, 'detail'])->name('detail.berita');


Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login-store', [AuthController::class, 'loginStore'])->name('login-store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', fn() => view('pages.register'))->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardLivewire::class)->name('dashboard');
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
    Route::get('/manajemen-berita', ManajemenBerita::class)->name('manajemen-berita');
    Route::get('/manajemen-berita/create', [BeritaController::class, 'createBerita'])->name('manajemen-berita-create');
    Route::post('/manajemen-berita/store', [BeritaController::class, 'store'])->name('manajemen-berita-store');
    Route::get('/manajemen-berita/{id}/edit', [BeritaController::class, 'editBerita'])->name('manajemen-berita-edit');
    Route::put('/manajemen-berita/{id}', [BeritaController::class, 'updateBerita'])->name('manajemen-berita-update');
});
