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
    public $cuti_type_id, $alasan, $tanggal_start, $tanggal_end;

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
            'tanggal_start' => 'required',
            'tanggal_end' => 'required',
        ]);



         $user = JWTAuth::parseToken()->authenticate();

        DB::transaction(function ()  {
            $user = JWTAuth::parseToken()->authenticate();

            $data = [
                'user_id' => $user->id,
                'cuti_type_id' => $this->cuti_type_id,
                'alasan' => $this->alasan,
                'status' => 'pending',
                'tanggal_start' => $this->tanggal_start,
                'tanggal_end' => $this->tanggal_end,
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
        $this->reset(['cuti_type_id', 'alasan', 'tanggal_start','tanggal_end']);
    }
}
