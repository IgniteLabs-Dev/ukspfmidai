<?php

namespace App\Livewire;

use App\Models\Izin;
use App\Models\IzinApprovalWorkflow;
use App\Models\IzinType;
use App\Models\Tahun;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Tymon\JWTAuth\Facades\JWTAuth;

class PermohonanIzin extends Component
{
    use WithPagination;
    public $tahun;
    public $izinType;
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
        $izinTypesData = IzinType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        $user = JWTAuth::parseToken()->authenticate();

        $approvalList = IzinApprovalWorkflow::wherehas('approvalLevel', function ($query) use ($user) {
            $query->where('jabatan_id', $user->jabatan_id);
        })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->pluck('izin_id')
            ->toArray();
        $data = IzinApprovalWorkflow::with('izin', 'approvalLevel')
            ->wherehas('approvalLevel', function ($query) use ($user) {
                $query->where('jabatan_id', $user->jabatan_id);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when(!$this->status, fn($q) => $q->where('status', '!=', 'pending'))
            ->when($this->tahun, function ($query) {
                return $query->whereYear('izin.created_at', $this->tahun);
            })
            ->when($this->izinType, function ($query) {
                return $query->where('izin.izin_type_id', $this->izinType);
            })
            ->when($this->filter, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('izin.alasan', 'like', '%' . $this->filter . '%')
                        ->orWhereHas('izin.user', function ($izinTypeQuery) {
                            $izinTypeQuery->where('name', 'like', '%' . $this->filter . '%');
                        });
                });
            })
            ->orderBy('izin_id', 'desc')
            ->paginate(10);


        return view('livewire.permohonan-izin', compact('data', 'tahunData', 'izinTypesData', 'user'))->extends('layouts.master');
    }
    public function approve($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

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
                if (isset($izinApprovalWorkflow[$currentIndex + 1])) {
                    $dataNextIndex = $izinApprovalWorkflow[$currentIndex + 1];
                    $dataNextIndex->status = 'waiting';
                    $dataNextIndex->save();
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
        $user = JWTAuth::parseToken()->authenticate();

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
        $user = JWTAuth::parseToken()->authenticate();

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

                // aktifkan next approver kalau ada
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


    public function viewFlow($id)
    {
        $this->viewFlowId = $id;

        $flowData = IzinApprovalWorkflow::with('approvalLevel')
            ->where('izin_id', $id)
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
    public function updatedIzinType()
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
