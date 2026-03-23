<?php

namespace App\Livewire;

use App\Models\Izin;
use App\Models\IzinApprovalLevel;
use App\Models\Jabatan;
use App\Services\CrudService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ManajemenApprovalLevelIzin extends Component
{
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $jabatan_id, $is_sign;


    public function render()
    {
        $data = IzinApprovalLevel::orderBy('id', 'asc')
            ->get();



        $jabatanTypes = Jabatan::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        return view('livewire.manajemen-approval-level-izin', compact('data', 'jabatanTypes'));
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
            'jabatan_id' => 'required|integer|unique:izin_approval_level_ref,jabatan_id',
            'is_sign' => 'required',
        ]);

        $data = [
            'jabatan_id' => $this->jabatan_id,
            'is_sign' => $this->is_sign
        ];

        if ($this->getIzinStatusPending() == 0) {
            $crud->create(IzinApprovalLevel::class, $data, 'Tahapan Izin berhasil dibuat!', 'Gagal membuat Tahapan Izin.');
            $this->resetInput();
        } else {
            LivewireAlert::title('Terdapat pengajuan izin yang masih berstatus pending. Mohon untuk menyelesaikan pengajuan izin sebelumnya terlebih dahulu.')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }
    public function edit($id, CrudService $crud)
    {

        $data = $crud->find(IzinApprovalLevel::class, $id);

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
            'jabatan_id' => 'required|integer|unique:izin_approval_level_ref,jabatan_id,' . $this->editId,
            'is_sign' => 'required',
        ]);
        $data = [
            'jabatan_id' => $this->jabatan_id,
            'is_sign' => $this->is_sign
        ];


        if ($this->getIzinStatusPending() == 0) {
            $crud->update(IzinApprovalLevel::class, $this->editId, $data, 'Tahapan Izin berhasil diperbarui!', 'Gagal memperbarui Tahapan Izin .');
            $this->resetInput();
        } else {
            LivewireAlert::title('Terdapat pengajuan izin yang masih berstatus pending. Mohon untuk menyelesaikan pengajuan izin sebelumnya terlebih dahulu.')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(IzinApprovalLevel::class, $id, 'Tahapan Izin berhasil dihapus!', 'Gagal menghapus Tahapan Izin.');
        $this->resetInput();
    }
    public function getIzinStatusPending()
    {
        return Izin::where('status', 'pending')->count();
    }
}
