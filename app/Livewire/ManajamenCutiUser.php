<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\CutiType;
use App\Models\CutiUser;
use App\Models\Tahun;
use App\Models\User;
use App\Models\ViewCutiKuota;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class ManajamenCutiUser extends Component
{
    public $user;
    public $confirmDeleteId;
    public $editId;
    public $mode = 'view';
    public $cuti_type_id;
    public $kuota;
    public $cuti_tersimpan;
    public $isCutiTahunan;
    public $tahun;

    public $tahunFilter;
    public $cutiTypeFilter;
    // public $deleteId;

    public $perPage = 10;
    public $currentPageKuota = 1;
    public $currentPageTahunan = 1;
    public $currentPageRiwayat = 1;


    public $dataKuotaUsed;
    public $dataTanggal;
    public $dataMapped;
    public $editingCutiId;
    public $tahunRiwayat;
    public $modeRiwayat = 'view';

    private function showAlert(string $type, string $message)
    {
        LivewireAlert::title($message)
            ->position('top-end')
            ->toast()
            ->{$type}()
            ->show();
    }

    public function mount($id)
    {
        $this->user = User::find($id);
    }
    public function render()
    {
        $viewCutiKuotaReguler = $this->getViewCutiKuotaRegulerProperty();
        $riwayatCuti = $this->getRiwayatCutiProperty();
        $viewCutiKuotaTahunan = $this->getViewCutiKuotaTahunanProperty();

        $dataCutiTahunan = CutiUser::where('user_id', $this->user->id)
            ->orderby('tahun', 'desc')
            ->wherehas('cuti', function ($query) {
                $query->where('is_count', 1);
            })
            ->get();

        $tahunData = Tahun::all();
        $cutiTypes = CutiType::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();
        $tahunData = Tahun::where('status', 'active')
            ->pluck('tahun', 'tahun')
            ->toArray();

        $tahunDataMapped =  Tahun::where('status', 'active')->get();

        return view('livewire.manajamen-cuti-user', compact('viewCutiKuotaReguler', 'cutiTypes', 'dataCutiTahunan', 'tahunData', 'riwayatCuti', 'viewCutiKuotaTahunan', 'tahunDataMapped'));
    }
    public function confirmDelete($id)
    {
        $this->confirmDeleteId = $id;
    }
    public function batalDelete()
    {
        $this->confirmDeleteId = null;
    }
    public function delete($id)
    {
        $data = CutiUser::find($id);
        if ($data->delete()) {
            $this->showAlert('success',  'Data berhasil dihapus!');
        }
    }
    public function edit($id)
    {

        $data = CutiUser::find($id);
        $this->editId = $id;
        $this->cuti_type_id = $data->cuti_type_id;
        $this->isCutiTahunan = $data->cuti->is_count;
        $this->kuota = $data->kuota;
        $this->cuti_tersimpan = $data->cuti_tersimpan ?? 0;
        $this->tahun = $data->tahun;
        $this->mode = 'edit';
    }
    public function resetInput()
    {
        $this->cuti_type_id = null;
        $this->kuota = null;
        $this->cuti_tersimpan = null;
        $this->tahun = null;
        $this->isCutiTahunan = null;
        $this->mode = 'view';
    }
    public function store()
    {
        $this->validate([
            'cuti_type_id' => 'required',
            'kuota' => 'required|numeric',
            'tahun' => 'required',
            'cuti_tersimpan' => 'nullable|numeric',
        ]);
        $data = CutiUser::create([
            'cuti_type_id' => $this->cuti_type_id,
            'kuota' => $this->kuota,
            'cuti_tersimpan' => $this->cuti_tersimpan,
            'tahun' => $this->tahun,
            'user_id' => $this->user->id,
        ]);

        if ($data->save()) {
            $this->showAlert('success', $successMessage ?? 'Data Berhasil Ditambahkan!');
            $this->resetInput();
        } else {
            $this->showAlert('error', $successMessage ?? 'Data Gagal Ditambahkan!');
        }
    }
    public function update()
    {
        $this->validate([
            'cuti_type_id' => 'required',
            'kuota' => 'required|numeric',
            'cuti_tersimpan' => 'nullable|numeric',
            'tahun' => 'required|numeric',
        ]);

        $data = CutiUser::find($this->editId);
        $data->cuti_type_id = $this->cuti_type_id;
        $data->kuota = $this->kuota;
        $data->cuti_tersimpan = $this->cuti_tersimpan;
        $data->tahun = $this->tahun;

        if ($data->save()) {

            $this->showAlert('success', 'Data Berhasil Diperbarui');
            $this->resetInput();
            $this->mode = 'view';
        } else {
            $this->showAlert('error', 'Data Gagal Diperbarui');
        }
    }
    public function mappingKuotaUsed($kuota_used)
    {
        $this->modeRiwayat = 'mapping';

        $data = Cuti::where('id', $kuota_used)->first();
        $this->editingCutiId = $kuota_used;

        $tanggalArray = collect(explode(',', $data->tanggal))
            ->map(fn($tanggal) => trim($tanggal));
        $kuotaArray = collect(explode(',', $data->kuota_used))
            ->map(fn($kuota) => trim($kuota));

        $maxCount = max($tanggalArray->count(), $kuotaArray->count());

        $this->dataMapped = collect(range(0, $maxCount - 1))->map(function ($index) use ($tanggalArray, $kuotaArray) {
            return [
                'tanggal' => $tanggalArray[$index] ?? null,
                'kuota_used' => $kuotaArray[$index] ?? ''
            ];
        })->toArray();
    }

    public function saveMappingKuota()
    {
        $kuotaUsedArray = collect($this->dataMapped)
            ->pluck('kuota_used')
            ->filter(fn($val) => $val !== null && $val !== '')
            ->toArray();

        Cuti::where('id', $this->editingCutiId)->update([
            'kuota_used' => implode(',', $kuotaUsedArray)
        ]);

        $this->backView();

        $this->showAlert('success', 'Data Berhasil Diperbarui');
    }
    public function backView()
    {
        $this->modeRiwayat = 'view';
        $this->dataTanggal = null;
        $this->dataKuotaUsed = null;
    }

    public function getViewCutiKuotaRegulerProperty()
    {
        $query = ViewCutiKuota::where('user_id', $this->user->id)
            ->where('is_count', 0)
            ->orderBy('tahun', 'desc')
            ->when($this->tahunFilter, function ($query) {
                $query->whereYear('tahun', $this->tahunFilter);
            })
            ->when($this->cutiTypeFilter, function ($query) {
                $query->where('cuti_type_id', $this->cutiTypeFilter);
            });

        $total = $query->count();
        $data = $query->skip(($this->currentPageKuota - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();

        return (object) [
            'data' => $data,
            'total' => $total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPageKuota,
            'last_page' => ceil($total / $this->perPage),
            'from' => (($this->currentPageKuota - 1) * $this->perPage) + 1,
            'to' => min($this->currentPageKuota * $this->perPage, $total)
        ];
    }
    public function getViewCutiKuotaTahunanProperty()
    {
        $query = ViewCutiKuota::where('user_id', $this->user->id)
            ->where('is_count', 1)
            ->orderBy('tahun', 'desc');


        $total = $query->count();
        $data = $query->skip(($this->currentPageTahunan - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();

        return (object) [
            'data' => $data,
            'total' => $total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPageTahunan,
            'last_page' => ceil($total / $this->perPage),
            'from' => (($this->currentPageTahunan - 1) * $this->perPage) + 1,
            'to' => min($this->currentPageTahunan * $this->perPage, $total)
        ];
    }

    // Method untuk tabel Riwayat Cuti dengan pagination manual
    public function getRiwayatCutiProperty()
    {
        $query = Cuti::where('user_id', $this->user->id)
            ->when($this->tahunRiwayat, function ($query) {
                $query->whereYear('created_at', $this->tahunRiwayat);
            })
            ->where('status', 'success')
            ->orderBy('created_at', 'desc')
            ->whereHas('cutiType', function ($query) {
                $query->where('is_count', 1);
            });

        $total = $query->count();

        $data = $query->skip(($this->currentPageRiwayat - 1) * $this->perPage)
            ->take($this->perPage)
            ->get()
            ->map(function ($item) {
                if (!empty($item->kuota_used)) {
                    $years = collect(explode(',', $item->kuota_used))
                        ->map(fn($year) => trim($year))
                        ->countBy()
                        ->sortKeys()
                        ->map(fn($count, $year) => $year . ' (' . $count . ')')
                        ->implode(', ');

                    $item->kuota_used_grouped = $years;
                } else {
                    $item->kuota_used_grouped = '-';
                }

                return $item;
            });

        return (object) [
            'data' => $data,
            'total' => $total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPageRiwayat,
            'last_page' => ceil($total / $this->perPage),
            'from' => (($this->currentPageRiwayat - 1) * $this->perPage) + 1,
            'to' => min($this->currentPageRiwayat * $this->perPage, $total)
        ];
    }
    //cuti reguler
    public function nextPageKuota()
    {
        $this->currentPageKuota++;
    }

    public function previousPageKuota()
    {
        $this->currentPageKuota--;
    }

    public function gotoPageKuota($page)
    {
        $this->currentPageKuota = $page;
    }
    //cuti tahunan
    public function nextPageTahunan()
    {
        $this->currentPageTahunan++;
    }

    public function previousPageTahunan()
    {
        $this->currentPageTahunan--;
    }

    public function gotoPageTahunan($page)
    {
        $this->currentPageTahunan = $page;
    }
    //cuti riwayat
    public function nextPageRiwayat()
    {

        $this->currentPageRiwayat++;
    }

    public function previousPageRiwayat()
    {
        $this->currentPageRiwayat--;
    }

    public function gotoPageRiwayat($page)
    {
        $this->currentPageRiwayat = $page;
    }

    public function updatedTahunFilter()
    {
        $this->currentPageKuota = 1;
    }

    public function updatedCutiTypeFilter()
    {
        $this->currentPageKuota = 1;
    }

    public function updatedTahunRiwayat()
    {
        $this->currentPageRiwayat = 1;
    }
}
