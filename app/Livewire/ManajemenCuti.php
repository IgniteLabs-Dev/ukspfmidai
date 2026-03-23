<?php

namespace App\Livewire;

use App\Models\CutiType;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenCuti extends Component
{
    use WithPagination;
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $name, $status, $deskripsi, $is_count;

    protected $rules = [

        'name' => 'required|string|max:255',
        'deskripsi' => 'required|string|max:255',
        'status' => 'required|string',
        'is_count' => 'required|integer',

    ];

    public function render()
    {
        $data = CutiType::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('name', 'like', '%' . $this->filter . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->filter . '%');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.manajemen-cuti', compact('data'))->extends('layouts.master');
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
        $this->reset(['name', 'status', 'deskripsi', 'is_count']);
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

        $crud->create(CutiType::class, $data, 'Tipe Cuti berhasil dibuat!', 'Gagal membuat tipe cuti.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $data = $crud->find(CutiType::class, $id);

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

        $crud->update(CutiType::class, $this->editId, $data, 'Tipe cuti berhasil diperbarui!', 'Gagal memperbarui tipe cuti.');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(CutiType::class, $id, 'Tipe cuti berhasil dihapus!', 'Gagal menghapus tipe cuti.');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
}
