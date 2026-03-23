<?php

namespace App\Livewire;

use App\Models\CutiApprovalLevel;
use App\Models\Cuti;
use App\Models\Jabatan;
use App\Services\CrudService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ManajemenApprovalLevelCuti extends Component
{
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $jabatan_id, $is_sign;


    public function render()
    {
        $data = CutiApprovalLevel::orderBy('id', 'asc')
            ->get();

        $jabatanTypes = Jabatan::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        return view('livewire.manajemen-approval-level-cuti', compact('data', 'jabatanTypes'));
    }


    public function toggleMode()
    {
        $this->mode = $this->mode === 'view' ? 'create' : 'view';
    }
    public function resetInput()
    {
        $this->mode = 'view';
        $this->editId = null;
        $this->resetValidation();
        $this->reset(['jabatan_id','is_sign']);
    }
    public function create(CrudService $crud)
    {

        $this->validate([
            'jabatan_id' => 'required|integer|unique:cuti_approval_level_ref,jabatan_id',
            'is_sign' => 'required',
        ]);

        $data = [
            'jabatan_id' => $this->jabatan_id,
            'is_sign' => $this->is_sign
        ];

        if ($this->getCutiStatusPending() == 0) {
            $crud->create(CutiApprovalLevel::class, $data, 'Tahapan Cuti berhasil dibuat!', 'Gagal membuat Tahapan Cuti.');
            $this->resetInput();
        } else {
            LivewireAlert::title('Terdapat pengajuan cuti yang masih berstatus pending. Mohon untuk menyelesaikan pengajuan cuti sebelumnya terlebih dahulu.')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }
    public function edit($id, CrudService $crud)
    {

        $data = $crud->find(CutiApprovalLevel::class, $id);

        if ($data) {
            $this->jabatan_id = $data->jabatan_id;
            $this->is_sign = $data->is_sign;
            $this->mode = 'edit';
            $this->editId = $id;
        }
    }
    public function update(CrudService $crud)
    {

        $this->validate([
            'jabatan_id' => 'required|integer|unique:cuti_approval_level_ref,jabatan_id,' . $this->editId,
            'is_sign' => 'required',
        ]);
        $data = [
            'jabatan_id' => $this->jabatan_id,
            'is_sign' => $this->is_sign
        ];


        if ($this->getCutiStatusPending() == 0) {
            $crud->update(CutiApprovalLevel::class, $this->editId, $data, 'Tahapan Cuti berhasil diperbarui!', 'Gagal memperbarui Tahapan Cuti .');
            $this->resetInput();
        } else {
            LivewireAlert::title('Terdapat pengajuan cuti yang masih berstatus pending. Mohon untuk menyelesaikan pengajuan cuti sebelumnya terlebih dahulu.')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(CutiApprovalLevel::class, $id, 'Tahapan Cuti berhasil dihapus!', 'Gagal menghapus Tahapan Cuti.');
        $this->resetInput();
    }
    public function getCutiStatusPending()
    {
        return Cuti::where('status', 'pending')->count();
    }
}
