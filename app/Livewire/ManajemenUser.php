<?php

namespace App\Livewire;

use App\Models\Jabatan;
use App\Models\Pangkat;
use App\Models\User;
use App\Services\CrudService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

use function Psy\debug;

class ManajemenUser extends Component
{
    use WithPagination;
    public $title = 'Manajemen User';
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $name, $nip, $password, $role, $jabatan_id, $pangkat_id, $nomor_wa;


    public function render()
    {
        $data = User::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('name', 'like', '%' . $this->filter . '%')
                    ->orWhere('nip', 'like', '%' . $this->filter . '%')
                    ->orWhere('nomor_wa', 'like', '%' . $this->filter . '%')
                    ->orwherehas('jabatan', function ($jabatan) {
                        $jabatan->where('name', 'like', '%' . $this->filter . '%');
                    })
                    ->orwherehas('pangkat', function ($pangkat) {
                        $pangkat->where('name', 'like', '%' . $this->filter . '%');
                    });
            });
        })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $jabatanData = Jabatan::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        $pangkatData = Pangkat::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();


        return view('livewire.manajemen-user', compact('data', 'jabatanData', 'pangkatData'))->extends('layouts.master');
    }
    public function toggleMode()
    {
        $this->mode = $this->mode === 'view' ? 'edit' : 'view';
    }
    public function resetInput()
    {
        $this->mode = 'view';
        $this->resetValidation();
        $this->editId = null;
        $this->reset(['name', 'nip', 'password', 'role', 'jabatan_id', 'pangkat_id', 'nomor_wa']);
    }
    public function create(CrudService $crud)
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:users,nip',
            'password' => 'required|string|min:1',
            'role' => 'required',
            'jabatan_id' => 'required|integer',
            'pangkat_id' => 'required|integer',
            'nomor_wa' => 'required|string|max:15',
        ]);

        $data = [
            'name' => $this->name,
            'nip' => $this->nip,
            'password' => bcrypt($this->password),
            'role' => $this->role,
            'jabatan_id' => $this->jabatan_id,
            'pangkat_id' => $this->pangkat_id,
            'nomor_wa' => $this->nomor_wa,
        ];

        $crud->create(User::class, $data, 'User berhasil dibuat!', 'Gagal membuat user.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $user = $crud->find(User::class, $id);

        if ($user) {
            $this->name = $user->name;
            $this->nip = $user->nip;
            $this->role = $user->role;
            $this->jabatan_id = $user->jabatan_id;
            $this->pangkat_id = $user->pangkat_id;
            $this->nomor_wa = $user->nomor_wa;
            $this->mode = 'edit';
            $this->editId = $id;
        }
    }
    public function update(CrudService $crud)
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:users,nip,' . $this->editId,
            'role' => 'required',
            'jabatan_id' => 'required|integer|max:100',
            'pangkat_id' => 'required|integer|max:100',
            'nomor_wa' => 'required|string|max:15',
        ]);

        $data = [
            'name' => $this->name,
            'nip' => $this->nip,
            'role' => $this->role,
            'jabatan_id' => $this->jabatan_id,
            'pangkat_id' => $this->pangkat_id,
            'nomor_wa' => $this->nomor_wa,

        ];
        if (!empty($this->password)) {
            $data['password'] = bcrypt($this->password);
        }

        $crud->update(User::class, $this->editId, $data, 'User berhasil diperbarui!', 'Gagal memperbarui user.');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(User::class, $id, 'User berhasil dihapus!', 'Gagal menghapus user.');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
}
