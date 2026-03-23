<?php

namespace App\Livewire;

use App\Models\Role;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenRole extends Component
{
    use WithPagination;
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $name;

    protected $rules = [

        'name' => 'required|string|max:255',

    ];

    public function render()
    {
        $data = Role::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('name', 'like', '%' . $this->filter . '%');
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(10);


        return view('livewire.manajemen-role', compact('data'))->extends('layouts.master');
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
        $this->reset(['name']);
    }
    public function create(CrudService $crud)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
        ];

        $crud->create(Role::class, $data, 'Role berhasil dibuat!', 'Gagal membuat role.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $data = $crud->find(Role::class, $id);

        if ($data) {
            $this->name = $data->name;
            $this->mode = 'edit';
            $this->editId = $id;
        }
    }
    public function update(CrudService $crud)
    {

        $this->validate();
        $data = [
            'name' => $this->name,
        ];

        $crud->update(Role::class, $this->editId, $data, 'Role berhasil diperbarui!', 'Gagal memperbarui role.');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(Role::class, $id, 'Role berhasil dihapus!', 'Gagal menghapus role.');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
}
