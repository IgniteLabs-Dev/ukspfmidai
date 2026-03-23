<?php

namespace App\Livewire;

use App\Models\Izin;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IzinDoc extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }
    public function render()
    {
        $data = Izin::find($this->id);
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data->user->name));
        $isPrint = 'false';
        $logoData = null;

        return view('livewire.izin-doc', compact(
            'data',
            'qrcode',
            'isPrint',
            'logoData'
        ));
    }
}
