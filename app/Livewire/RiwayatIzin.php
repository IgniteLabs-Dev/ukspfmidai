<?php

namespace App\Livewire;

use App\Models\Izin;
use App\Models\IzinType;
use App\Models\Tahun;
use App\Models\User;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Tymon\JWTAuth\Facades\JWTAuth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class RiwayatIzin extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $tahun;
    public $izinType;
    public $bulan;
    public $status;
    public $filter;
    public $editId;
    public $editDoc = false;
    public $form =
    [
        'keperluan' => '',
        'izin_type_id' => '',
        'tanggal_mulai' => '',
        'tanggal_selesai' => '',
        'doc' => '',
    ];
    public function mount()
    {
        $this->status = request()->query('status');
    }

    public function render()
    {
        $tahunData = Izin::where('user_id', JWTAuth::parseToken()->authenticate()->id)
            ->selectRaw('YEAR(tanggal_mulai) as tahun')
            ->whereNotNull('tanggal_mulai')
            ->union(
                Izin::where('user_id', JWTAuth::parseToken()->authenticate()->id)
                    ->selectRaw('YEAR(tanggal_selesai) as tahun')
                    ->whereNotNull('tanggal_selesai')
            )
            ->orderBy('tahun', 'asc')
            ->pluck('tahun', 'tahun')
            ->toArray();

        $izinTypesData = IzinType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        $izinTypes = IzinType::where('status', 'active')->get();

        $data = Izin::where('user_id', JWTAuth::parseToken()->authenticate()->id)
            ->when($this->tahun, function ($query) {
                return $query->whereYear('tanggal_mulai', $this->tahun)
                    ->orWhereYear('tanggal_selesai', $this->tahun);
            })
            ->when($this->izinType, function ($query) {
                return $query->where('izin_type_id', $this->izinType);
            })
            ->when($this->bulan, function ($query) {
                return $query->whereMonth('tanggal_mulai', $this->bulan)
                    ->orWhereMonth('tanggal_selesai', $this->bulan);
            })
            ->when($this->filter, function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('keperluan', 'like', '%' . $this->filter . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.riwayat-izin', compact('data', 'tahunData', 'izinTypesData','izinTypes'))->extends('layouts.master');
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }
    public function updatedTahun()
    {
        $this->resetPage();
    }
    public function updatedIzinType()
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
        $izin = Izin::findOrFail($id);
        if ($izin->status == 'pending') {
            // hapus file
            if ($izin->doc) {
                $oldPath = public_path('files/izin/' . $izin->doc);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            if ($izin->delete()) {
                LivewireAlert::title('Pengajuan izin berhasil dihapus!')
                    ->position('top-end')
                    ->toast()
                    ->success()
                    ->show();
            }
        } else {
            LivewireAlert::title('Hanya pengajuan izin dengan status pending yang dapat dihapus.')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
        }
    }

    public function edit($id)
    {
        $izin = Izin::findOrFail($id);
        $this->editId = $izin->id;
        $this->editDoc = $izin->doc;
        $this->form = [
            'keperluan' => $izin->keperluan,
            'izin_type_id' => $izin->izin_type_id,
            'tanggal_mulai' => $izin->tanggal_mulai,
            'tanggal_selesai' => $izin->tanggal_selesai,
        ];
    }


    public function update()
    {
        $rules = [
            'form.keperluan' => 'required',
            'form.izin_type_id' => 'required',
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
            'form.keperluan.required' => 'Keperluan izin wajib diisi.',
            'form.izin_type_id.required' => 'Jenis izin wajib dipilih.',
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
            'keperluan' => $this->form['keperluan'],
            'izin_type_id' => $this->form['izin_type_id'],
            'tanggal_mulai' => $this->form['tanggal_mulai'],
            'tanggal_selesai' => $this->form['tanggal_selesai'],
        ];

        $user = JWTAuth::parseToken()->authenticate();
        $user = User::find($user->id);

        if (isset($this->form['doc']) && $this->form['doc'] instanceof TemporaryUploadedFile) {
            // hapus file lama
            $oldDoc = Izin::findOrFail($this->editId)->doc;
            if ($oldDoc) {
                $oldPath = public_path('files/izin/' . $oldDoc);
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

        Izin::findOrFail($this->editId)->update($data);

        LivewireAlert::title('Pengajuan izin berhasil diperbarui!')
            ->position('top-end')
            ->toast()
            ->success()
            ->show();

        $this->dispatch('close-edit');
    }

    public function resetInput()
    {
        $this->form = [
            'keperluan' => '',
            'izin_type_id' => '',
            'tanggal_mulai' => '',
            'tanggal_selesai' => '',
        ];
    }
}
