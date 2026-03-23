<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\CutiApprovalLevel;
use App\Models\CutiApprovalWorkflow;
use App\Models\CutiType;
use App\Models\ViewCutiTahunan;
use App\Services\CrudService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Tymon\JWTAuth\Facades\JWTAuth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class PengajuanCuti extends Component
{
    public $cuti_type_id, $alasan, $tanggal,$total_hari;

    public function render()
    {
        $cutiTypes = CutiType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();
        return view('livewire.pengajuan-cuti', compact('cutiTypes'))->extends('layouts.master');
    }

    public function create(CrudService $crud)
    {
        $this->validate([
            'cuti_type_id' => 'required',
            'alasan' => 'required',
            'tanggal' => 'required',
        ]);

        $totalHari = 0;
        if (!empty($this->tanggal)) {
            $tanggalArray = explode(',', $this->tanggal);
            $totalHari = count(array_map('trim', $tanggalArray));
        }

         $user = JWTAuth::parseToken()->authenticate();
        $kuotaUsed = ViewCutiTahunan::where('user_id', $user->id)
            ->where('cuti_type_id', $this->cuti_type_id)
            ->pluck('uraian_tahun')
            ->first();


        $this->total_hari = count($tanggalArray);

        if ($kuotaUsed) {
            $tahunArray = explode(',', $kuotaUsed);
            $selectedTahun = array_slice($tahunArray, 0, $this->total_hari);
            $kuotaYearUsed = implode(',', $selectedTahun);
        } else {
            $kuotaYearUsed = null;
        }


        DB::transaction(function () use ($totalHari,$kuotaYearUsed) {
            $user = JWTAuth::parseToken()->authenticate();

            $data = [
                'user_id' => $user->id,
                'cuti_type_id' => $this->cuti_type_id,
                'alasan' => $this->alasan,
                'status' => 'pending',
                'tanggal' => $this->tanggal,
                'kuota_used' => $kuotaYearUsed,
                'total_hari' => $totalHari,
            ];

            $cuti = Cuti::create($data);

            $approvalLevel = CutiApprovalLevel::all();

            foreach ($approvalLevel as $index => $workflow) {
                CutiApprovalWorkflow::create([
                    'cuti_id' => $cuti->id,
                    'approval_level_id' => $workflow->id,
                    'status' => $index === 0 ? 'waiting' : 'pending',
                ]);
            }

            LivewireAlert::title('Pengajuan Cuti Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();

            $this->resetInput();
        });
    }
    public function resetInput()
    {
        $this->reset(['cuti_type_id', 'alasan', 'tanggal']);
    }
}
