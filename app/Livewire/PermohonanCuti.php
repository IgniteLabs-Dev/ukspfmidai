<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\CutiApprovalWorkflow;
use App\Models\CutiType;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Tymon\JWTAuth\Facades\JWTAuth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class PermohonanCuti extends Component
{
    use WithPagination;
    public $tahun;
    public $cutiType;
    public $bulan;
    public $status;
    public $filter;
    public $viewFlowId;
    public $flowData;

    public function mount()
    {
        $this->status = request()->query('status');
    }


    public function render()
    {
        $tahunData = Tahun::where('status', 'active')
            ->pluck('tahun', 'tahun')
            ->toArray();
        $cutiTypesData = CutiType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        $user = JWTAuth::parseToken()->authenticate();

        $approvalList = CutiApprovalWorkflow::wherehas('approvalLevel', function ($query) use ($user) {
            $query->where('jabatan_id', $user->jabatan_id);
        })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->pluck('cuti_id')
            ->toArray();
        $data = CutiApprovalWorkflow::with(['cuti.user', 'approvalLevel'])
            ->whereHas('approvalLevel', function ($query) use ($user) {
                $query->where('jabatan_id', $user->jabatan_id);
            })
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when(!$this->status, fn($q) => $q->where('status', '!=', 'pending'))
            ->when($this->tahun, fn($q) => $q->whereHas('cuti', fn($q2) => $q2->whereYear('created_at', $this->tahun)))
            ->when($this->cutiType, fn($q) => $q->whereHas('cuti', fn($q2) => $q2->where('cuti_type_id', $this->cutiType)))
            ->when($this->filter, function ($query) {
                $query->whereHas('cuti', function ($q2) {
                    $q2->where('alasan', 'like', '%' . $this->filter . '%')
                        ->orWhereHas('user', fn($q3) => $q3->where('name', 'like', '%' . $this->filter . '%'));
                });
            })
            ->orderBy('cuti_id', 'desc')
            ->paginate(10);


        return view('livewire.permohonan-cuti', compact('data', 'tahunData', 'cutiTypesData', 'user'))->extends('layouts.master');
    }

    public function approve($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

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
        $user = JWTAuth::parseToken()->authenticate();

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
        $user = JWTAuth::parseToken()->authenticate();

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

                // aktifkan next approver kalau ada
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
        } else {
            LivewireAlert::title('Tidak ada approval yang menunggu untuk jabatan ini')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }


    public function viewFlow($id)
    {
        $this->viewFlowId = $id;

        $flowData = CutiApprovalWorkflow::with('approvalLevel')
            ->where('cuti_id', $id)
            ->orderBy('id')
            ->get();

        $this->flowData = $flowData;
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }
    public function updatedTahun()
    {
        $this->resetPage();
    }

    public function updatedCutiType()
    {
        $this->resetPage();
    }
    public function updatedBulan()
    {
        $this->resetPage();
    }
    public function updatedStatus()
    {
        $this->resetPage();
    }
}
