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

        $cutiIzinApprover = $service->IsApprovalUser();



        return view('livewire.dashboard', compact( 'CutiPending', 'CutiSuccess', 'CutiFailed', 'CutiKetua', 'IzinPending', 'IzinSuccess', 'IzinFailed', 'permohonanIzinWaiting', 'permohonanIzinSuccess', 'permohonanIzinFailed', 'permohonanCutiWaiting', 'permohonanCutiSuccess', 'permohonanCutiFailed','cutiIzinApprover'))->extends('layouts.master');
    }
}
