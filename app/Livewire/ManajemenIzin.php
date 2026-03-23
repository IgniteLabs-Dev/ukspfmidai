<?php

namespace App\Livewire;

use App\Models\IzinType;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenIzin extends Component
{
    use WithPagination;
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $name, $status, $deskripsi, $is_count;

    protected $rules = [

        'name' => 'required|string|max:255',
        'status' => 'required|string',

    ];

    public function render()
    {
        $data = IzinType::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('name', 'like', '%' . $this->filter . '%');
            });
        })->paginate(10);


        return view('livewire.manajemen-izin', compact('data'))->extends('layouts.master');
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
        $this->reset(['name', 'status']);
    }
    public function create(CrudService $crud)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
            'is_count' => $this->is_count,
        ];

        $crud->create(IzinType::class, $data, 'Tipe Cuti berhasil dibuat!', 'Gagal membuat tipe cuti.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $data = $crud->find(IzinType::class, $id);

        if ($data) {
            $this->name = $data->name;
            $this->status = $data->status;
            $this->deskripsi = $data->deskripsi;
            $this->is_count = $data->is_count;
            $this->mode = 'edit';
            $this->editId = $id;
        }
    }
    public function update(CrudService $crud)
    {

        $this->validate();
        $data = [
            'name' => $this->name,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
            'is_count' => $this->is_count,
        ];

        $crud->update(IzinType::class, $this->editId, $data, 'Tipe Cutiberhasil diperbarui!', 'Gagal memperbarui tipe cuti.');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(IzinType::class, $id, 'Tipe Cutiberhasil dihapus!', 'Gagal menghapus tipe cuti.');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
}
