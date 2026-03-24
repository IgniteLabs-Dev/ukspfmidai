<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\CutiApprovalLevel;
use App\Models\CutiApprovalWorkflow;
use App\Models\CutiType;
use App\Models\User;
use App\Models\ViewCutiTahunan;
use App\Services\CrudService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Tymon\JWTAuth\Facades\JWTAuth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class PengajuanCuti extends Component
{
    use WithFileUploads;
    public $cuti_type_id, $alasan, $tanggal_start, $tanggal_end,$doc;

    public function render()
    {
        $cutiTypes = CutiType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();
        return view('livewire.pengajuan-cuti', compact('cutiTypes'))->extends('layouts.master');
    }

    public function create(CrudService $crud)
    {
        $this->validate([
            'cuti_type_id' => 'required',
            'alasan' => 'nullable',
            'tanggal_start' => 'required',
            'tanggal_end' => 'required',
            'doc' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);


         $user = JWTAuth::parseToken()->authenticate();

        DB::transaction(function ()  {
            $user = JWTAuth::parseToken()->authenticate();
            $user = User::find($user->id);

            $data = [
                'user_id' => $user->id,
                'cuti_type_id' => $this->cuti_type_id,
                'alasan' => $this->alasan,
                'status' => 'pending',
                'tanggal_start' => $this->tanggal_start,
                'tanggal_end' => $this->tanggal_end,
            ];

            if (isset($this->doc) && $this->doc instanceof TemporaryUploadedFile) {
                $originalName = pathinfo(
                    $this->doc->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $extension = $this->doc->getClientOriginalExtension();
                $timestamp = now()->format('Ymd_His');
                $docName = $user->name . '_' . $timestamp . '.' . $extension;

                $this->doc->storeAs('files', $docName, 'real_public');

                $data['doc'] = $docName;
            }

            $cuti = Cuti::create($data);

            LivewireAlert::title('Pengajuan Cuti Berhasil!')
                ->position('top-end')
                ->toast()
                ->success()
                ->show();

            $this->resetInput();
        });
    }
    public function resetInput()
    {
        $this->reset(['cuti_type_id', 'alasan', 'tanggal_start','tanggal_end','doc']);
    }
}
