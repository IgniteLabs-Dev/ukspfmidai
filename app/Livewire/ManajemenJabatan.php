<?php

namespace App\Livewire;

use App\Models\Jabatan;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenJabatan extends Component
{
    use WithPagination;
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $name, $status;

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|string',
    ];

    public function render()
    {
        $data = Jabatan::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('name', 'like', '%' . $this->filter . '%');
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(10);


        return view('livewire.manajemen-jabatan', compact('data'))->extends('layouts.master');
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
            'status' => $this->status,
        ];

        $crud->create(Jabatan::class, $data, 'Jabatan berhasil dibuat!', 'Gagal membuat jabatan.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $data = $crud->find(Jabatan::class, $id);

        if ($data) {
            $this->name = $data->name;
            $this->status = $data->status;
            $this->mode = 'edit';
            $this->editId = $id;
        }
    }
    public function update(CrudService $crud)
    {

        $this->validate();
        $data = [
            'name' => $this->name,
            'status' => $this->status,
        ];
        $crud->update(Jabatan::class, $this->editId, $data, 'Jabatan berhasil diperbarui!', 'Gagal memperbarui jabatan .');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(Jabatan::class, $id, 'Jabatan berhasil dihapus!', 'Gagal menghapus jabatan .');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
}
