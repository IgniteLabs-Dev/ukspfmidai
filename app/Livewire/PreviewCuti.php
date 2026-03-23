<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\CutiApprovalWorkflow;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Tymon\JWTAuth\Facades\JWTAuth;

class PreviewCuti extends Component
{

    public $id;
    public $user;


    public function mount($id)
    {
        $this->id = $id;
        $this->user = JWTAuth::parseToken()->authenticate();

        $cutiFlowNow = CutiApprovalWorkflow::where('cuti_id', $this->id)
            ->whereHas('approvalLevel', function ($query) {
                $query->where('jabatan_id', $this->user->jabatan_id);
            })
            ->first();

        if (!$cutiFlowNow) {
            return redirect()->route('permohonan-cuti');
        }
    }


    public function render()
    {

        $cutiFlow = CutiApprovalWorkflow::where('cuti_id', $this->id)->get();

        $cutiFlowNow = CutiApprovalWorkflow::where('cuti_id', $this->id)
            ->whereHas('approvalLevel', function ($query) {
                $query->where('jabatan_id', $this->user->jabatan_id);
            })
            ->first();


        return view('livewire.preview-cuti',  compact('cutiFlow', 'cutiFlowNow'))->extends('layouts.master');
    }
    public function redirectOut() {}
    public function approve($id)
    {
        $user = $this->user;

        // eager load approvalLevel & pastikan urutan
        $cutiApprovalWorkflow = CutiApprovalWorkflow::with('approvalLevel')
            ->where('cuti_id', $id)
            ->orderBy('id')
            ->get();

        // cari index yang sesuai jabatan user dan status waiting
        $currentIndex = $cutiApprovalWorkflow->search(function ($item) use ($user) {
            return $item->approvalLevel->jabatan_id == $user->jabatan_id && $item->status == 'waiting';
        });

        if ($currentIndex !== false) {
            DB::transaction(function () use ($cutiApprovalWorkflow, $currentIndex, $id) {
                $dataCurrent = $cutiApprovalWorkflow[$currentIndex];
                $dataCurrent->status = 'success';
                $dataCurrent->save();

                // aktifkan next approver kalau ada
                if (isset($cutiApprovalWorkflow[$currentIndex + 1])) {
                    $dataNextIndex = $cutiApprovalWorkflow[$currentIndex + 1];
                    $dataNextIndex->status = 'waiting';
                    $dataNextIndex->save();
                }

                // cek apakah ini index terakhir
                $lastIndex = $cutiApprovalWorkflow->count() - 1;
                if ($currentIndex === $lastIndex) {
                    $cuti = Cuti::find($id);
                    $cuti->status = 'success';
                    $cuti->save();
                }
            });

            LivewireAlert::title('Approval Cuti Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();
            $this->render();
        } else {
            LivewireAlert::title('Tidak ada approval yang menunggu untuk jabatan ini')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }

    public function reject($id)
    {
        $user = $this->user;

        // eager load approvalLevel & pastikan urutan
        $cutiApprovalWorkflow = CutiApprovalWorkflow::with('approvalLevel')
            ->where('cuti_id', $id)
            ->orderBy('id')
            ->get();

        // cari index yang sesuai jabatan user dan status waiting
        $currentIndex = $cutiApprovalWorkflow->search(function ($item) use ($user) {
            return $item->approvalLevel->jabatan_id == $user->jabatan_id && $item->status == 'waiting';
        });

        if ($currentIndex !== false) {
            //ubah status di CutiApprovalWorkflow
            DB::transaction(function () use ($cutiApprovalWorkflow, $currentIndex, $id) {
                $dataCurrent = $cutiApprovalWorkflow[$currentIndex];
                $dataCurrent->status = 'failed';
                $dataCurrent->save();

                $cuti = Cuti::find($id);
                $cuti->status = 'failed';
                $cuti->save();
            });

            LivewireAlert::title('Reject Cuti Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();
            $this->render();
        } else {
            LivewireAlert::title('Tidak ada approval yang menunggu untuk jabatan ini')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }
    public function backToWaiting($id)
    {
        $user = $this->user;

        // eager load approvalLevel & pastikan urutan
        $cutiApprovalWorkflow = CutiApprovalWorkflow::with('approvalLevel')
            ->where('cuti_id', $id)
            ->orderBy('id')
            ->get();

        // cari index yang sesuai jabatan user dan status waiting
        $currentIndex = $cutiApprovalWorkflow->search(function ($item) use ($user) {
            return $item->approvalLevel->jabatan_id == $user->jabatan_id && $item->status != 'waiting';
        });

        if ($currentIndex !== false) {
            //ubah status di CutiApprovalWorkflow
            DB::transaction(function () use ($cutiApprovalWorkflow, $currentIndex, $id) {
                $dataCurrent = $cutiApprovalWorkflow[$currentIndex];
                $dataCurrent->status = 'waiting';
                $dataCurrent->save();

                // aktifkan pending untuk next nya
                for ($i = $currentIndex + 1; $i < count($cutiApprovalWorkflow); $i++) {
                    $dataNext = $cutiApprovalWorkflow[$i];
                    $dataNext->status = 'pending';
                    $dataNext->save();
                }

                $cuti = Cuti::find($id);
                $cuti->status = 'pending';
                $cuti->save();
            });

            LivewireAlert::title('Approval Cuti Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();
            $this->render();
        } else {
            LivewireAlert::title('Tidak ada approval yang menunggu untuk jabatan ini')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }
}
