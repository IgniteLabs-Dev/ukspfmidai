<?php

namespace App\Livewire;

use App\Models\Izin;
use App\Models\IzinApprovalLevel;
use App\Models\IzinApprovalWorkflow;
use App\Models\IzinType;
use App\Services\CrudService;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Tymon\JWTAuth\Facades\JWTAuth;

class PengajuanIzin extends Component
{
    public $izin_type_id, $tanggal, $keperluan, $mulai_pukul, $sampai_pukul;

    public function render()
    {
        $izinTypes = IzinType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();
        return view('livewire.pengajuan-izin', compact('izinTypes'))->extends('layouts.master');
    }

    public function create(CrudService $crud)
    {

        $this->validate([
            'izin_type_id' => 'required',
            'tanggal' => 'required',
            'keperluan' => 'required',
            'mulai_pukul' => 'required',
            'sampai_pukul' => 'required',
        ]);


        DB::transaction(function () {
            $user = JWTAuth::parseToken()->authenticate();

            $data = [
                'user_id' => JWTAuth::parseToken()->authenticate()->id,
                'izin_type_id' => $this->izin_type_id,
                'tanggal' => $this->tanggal,
                'keperluan' => $this->keperluan,
                'mulai_pukul' => $this->mulai_pukul,
                'sampai_pukul' => $this->sampai_pukul,
                'status' => 'pending',
            ];

            $izin = Izin::create($data);

            $approvalLevel = IzinApprovalLevel::all();

            foreach ($approvalLevel as $index => $workflow) {
                IzinApprovalWorkflow::create([
                    'izin_id' => $izin->id,
                    'approval_level_id' => $workflow->id,
                    'status' => $index === 0 ? 'waiting' : 'pending',
                ]);
            }

            LivewireAlert::title('Pengajuan Izin Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();

            $this->resetInput();
        });
    }
    public function resetInput()
    {
        $this->reset(['izin_type_id', 'tanggal', 'keperluan', 'mulai_pukul', 'sampai_pukul']);
    }
}
