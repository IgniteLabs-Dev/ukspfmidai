<?php

namespace App\Livewire;

use App\Models\Izin;
use App\Models\IzinApprovalWorkflow;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Tymon\JWTAuth\Facades\JWTAuth;

class PreviewIzin extends Component
{

    public $id;
    public $user;


    public function mount($id)
    {
        $this->id = $id;
        $this->user = JWTAuth::parseToken()->authenticate();

        $izinFlowNow = IzinApprovalWorkflow::where('izin_id', $this->id)
            ->whereHas('approvalLevel', function ($query) {
                $query->where('jabatan_id', $this->user->jabatan_id);
            })
            ->first();

        if (!$izinFlowNow) {
            return redirect()->route('permohonan-izin');
        }
    }


    public function render()
    {
        $izinFlow = IzinApprovalWorkflow::where('izin_id', $this->id)->get();

        $izinFlowNow = IzinApprovalWorkflow::where('izin_id', $this->id)
            ->whereHas('approvalLevel', function ($query) {
                $query->where('jabatan_id', $this->user->jabatan_id);
            })
            ->first();


        return view('livewire.preview-izin',  compact('izinFlow', 'izinFlowNow'))->extends('layouts.master');
    }
    public function approve($id)
    {
        $user = $this->user;

        // eager load approvalLevel & pastikan urutan
        $izinApprovalWorkflow = IzinApprovalWorkflow::with('approvalLevel')
            ->where('izin_id', $id)
            ->orderBy('id')
            ->get();

        // cari index yang sesuai jabatan user dan status waiting
        $currentIndex = $izinApprovalWorkflow->search(function ($item) use ($user) {
            return $item->approvalLevel->jabatan_id == $user->jabatan_id && $item->status == 'waiting';
        });

        if ($currentIndex !== false) {
            DB::transaction(function () use ($izinApprovalWorkflow, $currentIndex, $id) {
                $dataCurrent = $izinApprovalWorkflow[$currentIndex];
                $dataCurrent->status = 'success';
                $dataCurrent->save();

                // aktifkan next approver kalau ada
                for ($i = $currentIndex + 1; $i < count($izinApprovalWorkflow); $i++) {
                    $dataNext = $izinApprovalWorkflow[$i];
                    $dataNext->status = 'pending';
                    $dataNext->save();
                }


                // cek apakah ini index terakhir
                $lastIndex = $izinApprovalWorkflow->count() - 1;
                if ($currentIndex === $lastIndex) {
                    $izin = Izin::find($id);
                    $izin->status = 'success';
                    $izin->save();
                }
            });

            LivewireAlert::title('Approval Izin Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();
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
        $izinApprovalWorkflow = IzinApprovalWorkflow::with('approvalLevel')
            ->where('izin_id', $id)
            ->orderBy('id')
            ->get();

        // cari index yang sesuai jabatan user dan status waiting
        $currentIndex = $izinApprovalWorkflow->search(function ($item) use ($user) {
            return $item->approvalLevel->jabatan_id == $user->jabatan_id && $item->status == 'waiting';
        });

        if ($currentIndex !== false) {
            //ubah status di IzinApprovalWorkflow
            DB::transaction(function () use ($izinApprovalWorkflow, $currentIndex, $id) {
                $dataCurrent = $izinApprovalWorkflow[$currentIndex];
                $dataCurrent->status = 'failed';
                $dataCurrent->save();

                $izin = Izin::find($id);
                $izin->status = 'failed';
                $izin->save();
            });

            LivewireAlert::title('Reject Izin Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();
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
        $izinApprovalWorkflow = IzinApprovalWorkflow::with('approvalLevel')
            ->where('izin_id', $id)
            ->orderBy('id')
            ->get();

        // cari index yang sesuai jabatan user dan status waiting
        $currentIndex = $izinApprovalWorkflow->search(function ($item) use ($user) {
            return $item->approvalLevel->jabatan_id == $user->jabatan_id && $item->status != 'waiting';
        });

        if ($currentIndex !== false) {
            //ubah status di IzinApprovalWorkflow
            DB::transaction(function () use ($izinApprovalWorkflow, $currentIndex, $id) {
                $dataCurrent = $izinApprovalWorkflow[$currentIndex];
                $dataCurrent->status = 'waiting';
                $dataCurrent->save();

                // aktifkan pending untuk next nya
                if (isset($izinApprovalWorkflow[$currentIndex + 1])) {
                    $dataNextIndex = $izinApprovalWorkflow[$currentIndex + 1];
                    $dataNextIndex->status = 'pending';
                    $dataNextIndex->save();
                }

                $izin = Izin::find($id);
                $izin->status = 'pending';
                $izin->save();
            });

            LivewireAlert::title('Approval Izin Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();
        } else {
            LivewireAlert::title('Tidak ada approval yang menunggu untuk jabatan ini')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }
}
