<?php

namespace App\Livewire;

use App\Models\Izin;
use App\Models\IzinApprovalLevel;
use App\Models\IzinApprovalWorkflow;
use App\Models\IzinType;
use App\Services\CrudService;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Tymon\JWTAuth\Facades\JWTAuth;

class PengajuanIzin extends Component
{
    use WithFileUploads;
    public $izin_type_id, $tanggal_mulai,$tanggal_selesai, $keperluan,$doc;

    public function render()
    {
        $izinTypes = IzinType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();
        return view('livewire.pengajuan-izin', compact('izinTypes'))->extends('layouts.master');
    }

    public function create(CrudService $crud)
    {

        $this->validate([
            'izin_type_id' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required|after_or_equal:tanggal_mulai',
            'keperluan' => 'nullable',
            'doc' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);


        DB::transaction(function () {
            $user = JWTAuth::parseToken()->authenticate();

            $data = [
                'user_id' => JWTAuth::parseToken()->authenticate()->id,
                'izin_type_id' => $this->izin_type_id,
                'tanggal_mulai' => $this->tanggal_mulai,
                'tanggal_selesai' => $this->tanggal_selesai,
                'keperluan' => $this->keperluan,
                'status' => 'pending',
            ];

            if (isset($this->doc) && $this->doc instanceof TemporaryUploadedFile) {
                $originalName = pathinfo(
                    $this->doc->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $extension = $this->doc->getClientOriginalExtension();
                $timestamp = now()->format('Ymd_His');
                $docName = $user->name .'_izin_' . $timestamp . '.' . $extension;

                $this->doc->storeAs('files/izin/', $docName, 'real_public');

                $data['doc'] = $docName;
            }

            $izin = Izin::create($data);

            $approvalLevel = IzinApprovalLevel::all();

            foreach ($approvalLevel as $index => $workflow) {
                IzinApprovalWorkflow::create([
                    'izin_id' => $izin->id,
                    'approval_level_id' => $workflow->id,
                    'status' => $index === 0 ? 'waiting' : 'pending',
                ]);
            }

            LivewireAlert::title('Pengajuan Izin Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();

            $this->resetInput();
            redirect()->route('riwayat-izin');
        });
    }
    public function resetInput()
    {
        $this->reset(['izin_type_id', 'keperluan', 'tanggal_mulai', 'tanggal_selesai','doc']);
    }
}
