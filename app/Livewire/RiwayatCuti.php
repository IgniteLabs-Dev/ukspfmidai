<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\CutiApprovalWorkflow;
use App\Models\CutiType;
use App\Models\CutiUser;
use App\Models\IzinApprovalWorkflow;
use App\Models\Tahun;
use App\Models\User;
use App\Models\ViewCutiKuota;
use App\Models\ViewCutiTahunan;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Tymon\JWTAuth\Facades\JWTAuth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RiwayatCuti extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $tahun;
    public $cutiType;
    public $bulan;
    public $status;
    public $alasan;
    public $filter;
    public $viewFlowId;
    public $flowData;
    public $editId;
    public $form = [
        'alasan' => '',
        'cuti_type_id' => '',
        'tanggal_mulai' => '',
        'tanggal_selesai' => '',
        'doc' => '',
    ];
    public $editDoc = false;

    public function mount()
    {
        $this->status = request()->query('status');
    }

    public function render()
    {
        $tahunData = Cuti::where('user_id', JWTAuth::parseToken()->authenticate()->id)
            ->selectRaw('YEAR(tanggal_start) as tahun')
            ->whereNotNull('tanggal_start')
            ->union(
                Cuti::where('user_id', JWTAuth::parseToken()->authenticate()->id)
                    ->selectRaw('YEAR(tanggal_end) as tahun')
                    ->whereNotNull('tanggal_end')
            )
            ->orderBy('tahun', 'asc')
            ->pluck('tahun', 'tahun')
            ->toArray();


        $cutiTypesData = CutiType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();
        $cutiTypes = CutiType::where('status', 'active')->get();


        $data = Cuti::where('user_id', JWTAuth::parseToken()->authenticate()->id)
            ->when($this->tahun, function ($query) {
                return $query->whereYear('tanggal_start', $this->tahun)
                    ->orWhereYear('tanggal_end', $this->tahun);
            })
            ->when($this->bulan, function ($query) {
                return $query->whereMonth('tanggal_start', $this->bulan)
                    ->orWhereMonth('tanggal_end', $this->bulan);
            })
            ->when($this->cutiType, function ($query) {
                return $query->where('cuti_type_id', $this->cutiType);
            })
            ->when($this->filter, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('alasan', 'like', '%' . $this->filter . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.riwayat-cuti', compact('data', 'tahunData', 'cutiTypesData','cutiTypes'))->extends('layouts.master');
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }
    public function updatedTahun()
    {
        $this->resetPage();
    }
    public function updatedCutiType()
    {
        $this->resetPage();
    }
    public function updatedBulan()
    {
        $this->resetPage();
    }
    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function destroy($id)
    {
        $cuti = Cuti::findOrFail($id);
        if ($cuti->status == 'pending') {
            // hapus file
            if ($cuti->doc) {
                $oldPath = public_path('files/cuti/' . $cuti->doc);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            if ($cuti->delete()) {
                LivewireAlert::title('Pengajuan cuti berhasil dihapus!')
                    ->position('top-end')
                    ->toast()
                    ->success()
                    ->show();
            }
        } else {
            LivewireAlert::title('Hanya pengajuan cuti dengan status pending yang dapat dihapus.')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }

    public function edit($id)
    {
        $cuti = Cuti::findOrFail($id);
        $this->editId = $cuti->id;
        $this->editDoc = $cuti->doc;
        $this->form = [
            'alasan' => $cuti->alasan,
            'cuti_type_id' => $cuti->cuti_type_id,
            'tanggal_mulai' => $cuti->tanggal_start,
            'tanggal_selesai' => $cuti->tanggal_end,
        ];
    }

    public function update()
    {
        $rules = [
            'form.alasan' => 'nullable',
            'form.cuti_type_id' => 'required',
            'form.tanggal_mulai' => 'required|date',
            'form.tanggal_selesai' => 'required|date|after_or_equal:form.tanggal_mulai',
        ];

        // wajib upload file baru hanya kalau file lama sudah dihapus
        if (!$this->editDoc) {
            $rules['form.doc'] = 'required|file|mimes:pdf,doc,docx|max:10240';
        } else {
            $rules['form.doc'] = 'nullable|file|mimes:pdf,doc,docx|max:10240';
        }

        $this->validate($rules, [
            'form.alasan.required' => 'Alasan cuti wajib diisi.',
            'form.cuti_type_id.required' => 'Jenis cuti wajib dipilih.',
            'form.tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'form.tanggal_mulai.date' => 'Tanggal mulai tidak valid.',
            'form.tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'form.tanggal_selesai.date' => 'Tanggal selesai tidak valid.',
            'form.tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'form.doc.required' => 'File wajib diupload.',
            'form.doc.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
            'form.doc.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $data = [
            'alasan' => $this->form['alasan'],
            'cuti_type_id' => $this->form['cuti_type_id'],
            'tanggal_start' => $this->form['tanggal_mulai'],
            'tanggal_end' => $this->form['tanggal_selesai'],
        ];


        $user = JWTAuth::parseToken()->authenticate();
        $user = User::find($user->id);

        if (isset($this->form['doc']) && $this->form['doc'] instanceof TemporaryUploadedFile) {
            // hapus file lama
            $oldDoc = Cuti::findOrFail($this->editId)->doc;
            if ($oldDoc) {
                $oldPath = public_path('files/cuti/' . $oldDoc);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $extension = $this->form['doc']->getClientOriginalExtension();
            $timestamp = now()->format('Ymd_His');
            $docName = $user->name . '_' . $timestamp . '.' . $extension;
            $this->form['doc']->storeAs('files', $docName, 'real_public');
            $data['doc'] = $docName;
        }

        Cuti::findOrFail($this->editId)->update($data);

        LivewireAlert::title('Pengajuan cuti berhasil diperbarui!')
            ->position('top-end')
            ->toast()
            ->success()
            ->show();

        $this->dispatch('close-edit');
    }

    public function resetInput()
    {       $this->form = [
            'alasan' => '',
            'cuti_type_id' => '',
            'tanggal_mulai' => '',
            'tanggal_selesai' => '',
        ];
    }

    public function viewFlow($id)
    {
        $this->viewFlowId = $id;

        $flowData = IzinApprovalWorkflow::with('approvalLevel')
            ->where('izin_id', $id)
            ->orderBy('id')
            ->get();

        $this->flowData = $flowData;
    }
}
