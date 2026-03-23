<?php

namespace App\Livewire;

use App\Models\Cuti;
use App\Models\CutiApprovalWorkflow;
use App\Models\CutiUser;
use App\Models\User;
use App\Models\ViewCutiKuota;
use App\Models\ViewCutiTahunan;
use Carbon\Carbon;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CutiDoc extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $data = Cuti::find($this->id);
        $atasan = CutiApprovalWorkflow::where('cuti_id', $this->id)->wherehas('approvalLevel', function ($q) {
            $q->where('is_sign', true);
        })->get();

        $jabatanAtasan1 = $atasan[0]->approvalLevel->jabatan_id ?? null;
        $jabatanAtasan2 = $atasan[1]->approvalLevel->jabatan_id ?? null;

        $atasan1 = User::where('jabatan_id', $jabatanAtasan1)->first();
        $atasan2 = User::where('jabatan_id', $jabatanAtasan2)->first();

        $cutiData = CutiUser::where('user_id', $data->user_id)
            ->where('tahun', date('Y'))
            ->with(['cuti' => function ($q) {
                $q->orderBy('is_count', 'desc');
            }])
            ->get();

        $splitData = $this->splitCutiData($cutiData);
        $leftItems = $splitData['leftItems'];
        $rightItems = $splitData['rightItems'];

        $tanggalCuti = $this->summaryDate($data->tanggal);


        $cutiTypeTanpaTahunan = ViewCutiKuota::where('user_id', $data->user_id)
            ->where('is_count', '0')
            ->where('tahun', now()->setTimezone('Asia/Jakarta')->year)
            ->select('cuti_type_id', 'cuti_type', 'sisa_kuota')
            ->get();

        $cutiTypeTahunan = ViewCutiTahunan::where('user_id', $data->user_id)
            ->select('cuti_type_id', 'cuti_type', 'sisa_kuota')
            ->get();
        $cuti_type = $cutiTypeTanpaTahunan->concat($cutiTypeTahunan)->values();
        $cutiTahunan = ViewCutiKuota::where('user_id', $data->user_id)
            ->where('is_count', '1')
            ->select('tahun', 'sisa_kuota', 'sisa_cuti_tersimpan')
            ->take(3)
            ->orderBy('tahun', 'desc') // ambil 3 terbaru
            ->get();

        // Urutkan naik (lama -> baru)
        $cutiTahunan = $cutiTahunan->sortBy('tahun')->values();

        // tambahin placeholder di depan sampai total 3
        while ($cutiTahunan->count() < 3) {
            $cutiTahunan->prepend((object)[
                'tahun' => null,
                'sisa_kuota' => 0,
                'sisa_cuti_tersimpan' => 0,
            ]);
        }

        // $qrAtasan1 = base64_encode(
        //     QrCode::format('png')->size(100)->generate($atasan1->name)
        // );
        // $qrAtasan2 = base64_encode(
        //     QrCode::format('png')->size(100)->generate($atasan2->name)
        // );
        $qrUser = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data->user->name));
        $qrAtasan1 = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($atasan1->name));
        $qrAtasan2 = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($atasan2->name));

        $isPrint = 'false';

        return view('livewire.cuti-doc', compact('data', 'atasan1', 'atasan2', 'cutiData', 'leftItems', 'rightItems', 'tanggalCuti', 'cutiTahunan', 'cuti_type',  'qrUser', 'qrAtasan1', 'qrAtasan2', 'isPrint'));
    }

    private function splitCutiData($cutiData)
    {
        $leftItems = collect();
        $rightItems = collect();

        foreach ($cutiData as $index => $item) {
            // $index dimulai dari 0, jadi tambahin 1 biar urut mulai dari 1
            if (($index + 1) % 2 === 1) {
                $leftItems->push($item);
            } else {
                $rightItems->push($item);
            }
        }

        return [
            'leftItems' => $leftItems,
            'rightItems' => $rightItems,
        ];
    }
    public function summaryDate($tanggalString)
    {
        // Pisahkan tanggal berdasarkan koma
        Carbon::setLocale('id');

        // Pisahkan tanggal berdasarkan koma
        $tanggalArray = array_map('trim', explode(',', $tanggalString));

        // Ubah ke Carbon
        $tanggalCarbon = collect($tanggalArray)->map(function ($t) {
            return Carbon::createFromFormat('d-m-Y', $t);
        });

        // Urutkan tanggal
        $sorted = $tanggalCarbon->sort();

        // Ambil data
        $jumlah = $tanggalCarbon->count();
        $terkecil = $sorted->first()->translatedFormat('d F Y'); // hasil: 07 Oktober 2025
        $terbesar = $sorted->last()->translatedFormat('d F Y');  // hasil: 12 Oktober 2025

        $jumlahTeks = $this->terbilang($jumlah);
        // Return hasil
        return [
            'jumlah' => "{$jumlah} ({$jumlahTeks})",
            'terkecil' => $terkecil,
            'terbesar' => $terbesar,
        ];
    }
    protected function terbilang($angka)
    {
        $angka = (int) $angka;
        if ($angka === 0) {
            return 'nol';
        }

        $angka = abs($angka);
        $satuan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];

        if ($angka < 12) {
            return $satuan[$angka];
        }
        if ($angka < 20) {
            return $this->terbilang($angka - 10) . ' Belas';
        }
        if ($angka < 100) {
            return $this->terbilang(intval($angka / 10)) . ' Puluh' . ($angka % 10 ? ' ' . $this->terbilang($angka % 10) : '');
        }


        return 'angka terlalu besar';
    }
}
