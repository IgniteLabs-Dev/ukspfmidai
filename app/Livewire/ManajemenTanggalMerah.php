<?php

namespace App\Livewire;

use App\Models\TanggalMerah;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenTanggalMerah extends Component
{
    use WithPagination;
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $keterangan, $tanggal, $status;

    protected $rules = [

        'keterangan' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'status' => 'required|string',

    ];

    public function render()
    {
        $data = TanggalMerah::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('keterangan', 'like', '%' . $this->filter . '%');
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(10);


        return view('livewire.manajemen-tanggal-merah', compact('data'))->extends('layouts.master');
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
        $this->reset(['keterangan', 'tanggal', 'status']);
    }
    public function create(CrudService $crud)
    {
        $this->validate();

        $data = [
            'tanggal' => $this->tanggal,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
        ];

        $crud->create(TanggalMerah::class, $data, 'Tanggal Merah berhasil dibuat!', 'Gagal membuat tanggal merah.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $data = $crud->find(TanggalMerah::class, $id);

        if ($data) {
            $this->tanggal = $data->tanggal;
            $this->status = $data->status;
            $this->keterangan = $data->keterangan;
            $this->mode = 'edit';
            $this->editId = $id;
        }
    }
    public function update(CrudService $crud)
    {

        $this->validate();
        $data = [
            'tanggal' => $this->tanggal,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
        ];

        $crud->update(TanggalMerah::class, $this->editId, $data, 'Tanggal Merah berhasil diperbarui!', 'Gagal memperbarui tanggal merah.');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(TanggalMerah::class, $id, 'Tanggal Merah berhasil dihapus!', 'Gagal menghapus tanggal merah.');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
}
