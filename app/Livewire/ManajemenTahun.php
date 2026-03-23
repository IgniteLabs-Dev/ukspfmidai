<?php

namespace App\Livewire;

use App\Models\Tahun;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenTahun extends Component
{
    use WithPagination;
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $tahun, $status;

    protected $rules = [

        'tahun' => 'required|integer',
        'status' => 'required|string',

    ];

    public function render()
    {
        $data = Tahun::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('tahun', 'like', '%' . $this->filter . '%');
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(10);


        return view('livewire.manajemen-tahun', compact('data'))->extends('layouts.master');
    }
    public function toggleMode()
    {
        $this->mode = $this->mode === 'view' ? 'edit' : 'view';
    }
    public function resetInput()
    {
        $this->mode = 'view';
        $this->editId = null;
        $this->resetValidation();
        $this->reset(['tahun', 'status']);
    }
    public function create(CrudService $crud)
    {
        $this->validate();

        $data = [
            'tahun' => $this->tahun,
            'status' => $this->status,
        ];

        $crud->create(Tahun::class, $data, 'Tahun berhasil dibuat!', 'Gagal membuat Tahun.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $data = $crud->find(Tahun::class, $id);

        if ($data) {
            $this->tahun = $data->tahun;
            $this->status = $data->status;
            $this->mode = 'edit';
            $this->editId = $id;
        }
    }
    public function update(CrudService $crud)
    {

        $this->validate();
        $data = [
            'tahun' => $this->tahun,
            'status' => $this->status,
        ];

        $crud->update(Tahun::class, $this->editId, $data, 'Tahun berhasil diperbarui!', 'Gagal memperbarui Tahun.');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(Tahun::class, $id, 'Tahun berhasil dihapus!', 'Gagal menghapus Tahun.');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
}
