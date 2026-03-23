<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\ViewCutiKuota;
use App\Models\ViewCutiTahunan;
use App\Services\CutiIzinCountService;
use Livewire\Component;
use Tymon\JWTAuth\Facades\JWTAuth;

class Dashboard extends Component
{
    public function render()
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());
        $cutiTypeTanpaTahunan = ViewCutiKuota::where('user_id', $user->id)
            ->where('is_count', '0')
            ->where('tahun', now()->setTimezone('Asia/Jakarta')->year)
            ->select('cuti_type_id', 'cuti_type', 'sisa_kuota')
            ->get();

        $cutiTypeTahunan = ViewCutiTahunan::where('user_id', $user->id)
            ->select('cuti_type_id', 'cuti_type', 'sisa_kuota')
            ->get();

        $cuti_type = $cutiTypeTanpaTahunan->concat($cutiTypeTahunan)->values();

        $cutiTahunan = ViewCutiKuota::where('user_id', $user->id)
            ->where('is_count', '1')
            ->select('tahun', 'sisa_kuota', 'sisa_cuti_tersimpan')
            ->take(3)
            ->orderby('tahun', 'desc')
            ->get();
        $cutiTahunan = $cutiTahunan->sortBy('tahun')->values();

        $CutiPending = Cuti::where('status', 'pending')->where('user_id', $user['id'])->count();
        $CutiSuccess = Cuti::where('status', 'success')->where('user_id', $user['id'])->count();
        $CutiFailed = Cuti::where('status', 'failed')->where('user_id', $user['id'])->count();
        $CutiKetua = Cuti::where('status', 'menunggu_ketua')->where('user_id', $user['id'])->count();

        $IzinPending = Izin::where('status', 'pending')->where('user_id', $user['id'])->count();
        $IzinSuccess = Izin::where('status', 'success')->where('user_id', $user['id'])->count();
        $IzinFailed = Izin::where('status', 'failed')->where('user_id', $user['id'])->count();

        $service = new CutiIzinCountService();
        $permohonanIzinWaiting = $service->IzinCount('waiting');
        $permohonanIzinSuccess = $service->IzinCount('success');
        $permohonanIzinFailed = $service->IzinCount('failed');

        $permohonanCutiWaiting = $service->CutiCount('waiting');
        $permohonanCutiSuccess = $service->CutiCount('success');
        $permohonanCutiFailed = $service->CutiCount('failed');



        return view('livewire.dashboard', compact('cuti_type', 'cutiTahunan', 'CutiPending', 'CutiSuccess', 'CutiFailed', 'CutiKetua', 'IzinPending', 'IzinSuccess', 'IzinFailed', 'permohonanIzinWaiting', 'permohonanIzinSuccess', 'permohonanIzinFailed', 'permohonanCutiWaiting', 'permohonanCutiSuccess', 'permohonanCutiFailed'))->extends('layouts.master');
    }
}
