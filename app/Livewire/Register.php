<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Http\Client\Request;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Register extends Component
{
    public $nip;
    public $password;
    public $name;

    public function render()
    {
        return view('livewire.register');
    }

    public function registerStore()
    {

        $this->validate([
            'nip'    => 'required|unique:users',
            'name'     => 'required',
            'password' => 'required|min:5',
        ]);

        $user = User::create([
            'name'     => $this->name,
            'nip'    => $this->nip,
            'status'     => 'active',
            'password' => bcrypt($this->password),
            'role'     => 'SUPERADMIN',
            'jabatan'     => null,
            'nomor_wa'     => null,
            'pangkat'     => null,
        ]);


        if ($user->save()) {
            LivewireAlert::title('Register Berhasil')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();
            return redirect()->route('login');
        } else {
            LivewireAlert::title('Register Gagal')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }
}