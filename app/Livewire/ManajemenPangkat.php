<?php

namespace App\Livewire;

use App\Models\Pangkat;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenPangkat extends Component
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
        $data = Pangkat::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('name', 'like', '%' . $this->filter . '%');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.manajemen-pangkat', compact('data'))->extends('layouts.master');
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

        $crud->create(Pangkat::class, $data, 'Pangkat berhasil dibuat!', 'Gagal membuat pangkat.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $data = $crud->find(Pangkat::class, $id);

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
        $crud->update(Pangkat::class, $this->editId, $data, 'Pangkat berhasil diperbarui!', 'Gagal memperbarui Pangkat .');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(Pangkat::class, $id, 'Pangkat berhasil dihapus!', 'Gagal menghapus Pangkat.');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
}
