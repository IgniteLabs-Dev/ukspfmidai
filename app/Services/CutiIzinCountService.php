<?php

namespace App\Services;

use App\Models\CutiApprovalLevel;
use App\Models\CutiApprovalWorkflow;
use App\Models\IzinApprovalLevel;
use App\Models\IzinApprovalWorkflow;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Tymon\JWTAuth\Facades\JWTAuth;

class CutiIzinCountService
{
    public function CutiCount(string $status)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return CutiApprovalWorkflow::with(['cuti.user', 'approvalLevel'])
            ->whereHas('approvalLevel', function ($query) use ($user) {
                $query->where('jabatan_id', $user->jabatan_id);
            })
            ->where('status', $status)
            ->count();
    }
    public function IzinCount(string $status)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return IzinApprovalWorkflow::with(['izin.user', 'approvalLevel'])
            ->whereHas('approvalLevel', function ($query) use ($user) {
                $query->where('jabatan_id', $user->jabatan_id);
            })
            ->where('status', $status)
            ->count();
    }

    public function IsApprovalUser(){
        $user = JWTAuth::parseToken()->authenticate();
        $cuti = CutiApprovalLevel::where('jabatan_id', $user->jabatan_id)->first();
        $izin = IzinApprovalLevel::where('jabatan_id', $user->jabatan_id)->first();

        return [
            'is_cuti_approver' => $cuti ? true : false,
            'is_izin_approver' => $izin ? true : false,
        ];
    }
}
