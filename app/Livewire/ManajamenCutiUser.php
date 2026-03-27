<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\CutiType;
use App\Models\CutiUser;
use App\Models\Tahun;
use App\Models\User;
use App\Models\ViewCutiKuota;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;

class ManajamenCutiUser extends Component
{
    use WithPagination;


    public $user;
    public $tahun = '';
    public $bulan;
    public $cutiTypeFilter;


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
        $this->tahun = Carbon::now()->year; // Set tahun default ke tahun saat ini
    }
    public function render()
    {
        $data = Cuti::select(
            'cuti_type_id',
            'cuti_type.name as nama_cuti',
            DB::raw('YEAR(tanggal_start) as tahun'),
            DB::raw('MONTH(tanggal_start) as bulan'),
            DB::raw('SUM(DATEDIFF(tanggal_end, tanggal_start) + 1) as total')
        )
            ->join('cuti_type', 'cuti_type.id', '=', 'cuti.cuti_type_id')
            ->where('cuti.user_id', $this->user->id)
            ->where('cuti.status', 'success')

            ->when($this->tahun, function ($q) {
                $q->whereYear('tanggal_start', $this->tahun);
            })

            ->when($this->bulan, function ($q) {
                $q->whereMonth('tanggal_start', $this->bulan);
            })

            ->when($this->cutiTypeFilter, function ($q) {
                $q->where('cuti_type_id', $this->cutiTypeFilter);
            })

            ->groupBy('cuti_type_id', 'nama_cuti', 'tahun', 'bulan')
            ->orderBy('tahun')
            ->paginate(10);


        $tahunData = Cuti::where('user_id', $this->user->id)
            ->selectRaw('YEAR(tanggal_start) as tahun')
            ->where('cuti.status', 'success')
            ->distinct()
            ->orderBy('tahun', 'asc')
            ->pluck('tahun', 'tahun'); // 🔥 key & value sama

        $cutiTypes = CutiType::pluck('name', 'id');

        return view('livewire.manajamen-cuti-user', compact( 'data', 'tahunData', 'cutiTypes'));
    }
    public function updatedBulan()
    {
        $this->resetPage();
    }
        public function updatedCutiTypeFilter()
        {
            $this->resetPage();
        }
        public function updatedTahun()
        {
            $this->resetPage();
        }

}
