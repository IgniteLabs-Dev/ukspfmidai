<?php

namespace App\Livewire;

use App\Services\CutiIzinCountService;
use Livewire\Component;
use Tymon\JWTAuth\Facades\JWTAuth;

class Sidebar extends Component
{
    public function render()
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());
        $service = new CutiIzinCountService();
        $izinCount = $service->IzinCount('waiting');
        $cutiCount = $service->CutiCount('waiting');
        return view('livewire.sidebar', compact('izinCount', 'cutiCount','user'));
    }
}
