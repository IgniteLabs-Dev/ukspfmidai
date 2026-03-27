<?php

namespace App\Livewire;

use App\Models\Izin;
use App\Models\IzinType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenIzinUser extends Component
{
    use WithPagination;


    public $user;
    public $tahun = '';
    public $bulan;
    public $izinTypeFilter;


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
        $data = Izin::select(
            'izin_type_id',
            'izin_type.name as nama_izin',
            DB::raw('YEAR(tanggal_mulai) as tahun'),
            DB::raw('MONTH(tanggal_mulai) as bulan'),
            DB::raw('SUM(DATEDIFF(tanggal_selesai, tanggal_mulai) + 1) as total')
        )
            ->join('izin_type', 'izin_type.id', '=', 'izin.izin_type_id')
            ->where('izin.user_id', $this->user->id)
            ->where('izin.status', 'success')

            ->when($this->tahun, function ($q) {
                $q->whereYear('tanggal_mulai', $this->tahun);
            })

            ->when($this->bulan, function ($q) {
                $q->whereMonth('tanggal_mulai', $this->bulan);
            })

            ->when($this->izinTypeFilter, function ($q) {
                $q->where('izin_type_id', $this->izinTypeFilter);
            })

            ->groupBy('izin_type_id', 'nama_izin', 'tahun', 'bulan')
            ->orderBy('tahun')
            ->paginate(10);



        $tahunData = Izin::where('user_id', $this->user->id)
            ->selectRaw('YEAR(tanggal_mulai) as tahun')
            ->where('izin.status', 'success')
            ->distinct()
            ->orderBy('tahun', 'asc')
            ->pluck('tahun', 'tahun'); // 🔥 key & value sama

        $izinTypes = IzinType::pluck('name', 'id');

        return view('livewire.manajemen-izin-user', compact( 'data', 'tahunData', 'izinTypes'));
    }

    public function updatedBulan()
    {
        $this->resetPage();
    }
    public function updatedIzinTypeFilter()
    {
        $this->resetPage();
    }
    public function updatedTahun()
    {
        $this->resetPage();
    }
}
