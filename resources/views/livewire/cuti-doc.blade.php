@php
    $totalCutiTahunan = count($cutiTahunan);
@endphp
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
    @font-face {
        font-family: "DejaVu Sans";
        /* path absolut ke file .ttf di server */
        src: url("{{ storage_path('fonts/DejaVuSans.ttf') }}") format("truetype");
        font-weight: normal;
        font-style: normal;
    }

    .pdf-body {
        font-family: "DejaVu Sans", sans-serif;
    }

    .centang {
        font-family: "DejaVu Sans", sans-serif;
        font-size: 14px;
        line-height: 1;
    }
</style>
<div>
    <div style="font-family: Arial, sans-serif; margin: 30px; font-size: 16px;">
        <div style="text-align: center; margin-bottom: 10px;">
            Mamuju, {{ $data['created_at']->format('d F Y') }}
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="border: 0px solid transparent; padding: 5px; width: 55%; vertical-align: top;"></td>
                <td
                    style="border: 0px solid transparent; padding: 5px; width: 45%; height: 120px; vertical-align: bottom; text-align: right;">
                    <div style="text-align: right; margin-bottom: 10px; line-height: 1.6;">
                        <div style="text-align: left;">
                            <div>Kepada</div>
                            <div>Yth. <strong>BUPATI MAMUJU</strong></div>
                            <div><strong>Cq. Kepala BKPP Kab. Mamuju</strong></div>
                            <div>di -</div>
                            <div style="letter-spacing: 3px;">Mamuju</div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="border: 0px solid transparent; padding: 5px; width: 30%; vertical-align: top;"></td>
                <td style="border: 0px solid transparent; padding: 5px; width: 50%; vertical-align: bottom;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h3 style="margin: 5px 0; text-align: left;"><u>PERMINTAAN DAN PEMBERIAN CUTI</u></h3>
                        <div style="text-align: left;">Nomor : {{ $data['nomor_surat'] ?? '-' }}</div>
                    </div>
                </td>
                <td style="border: 0px solid transparent; padding: 5px; width: 25%; vertical-align: bottom;"></td>
            </tr>
        </table>

        <!-- I. DATA PEGAWAI -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
            <tr>
                <td colspan="4" style="border: 1px solid black; padding: 5px; background-color: transparent;">
                    <strong>I. DATA PEGAWAI</strong>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; width: 15%;">Nama</td>
                <td style="border: 1px solid black; padding: 5px; width: 35%;">
                    <strong>{{ $data['user']['name'] ?? '-' }}</strong>
                </td>
                <td style="border: 1px solid black; padding: 5px; width: 15%;">NIP</td>
                <td style="border: 1px solid black; padding: 5px; width: 35%;">{{ $data['user']['nip'] ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">Jabatan</td>
                <td style="border: 1px solid black; padding: 5px;">{{ $data['user']['jabatan']['name'] ?? '-' }}</td>
                <td style="border: 1px solid black; padding: 5px;">Masa Kerja</td>
                <td style="border: 1px solid black; padding: 5px;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">Unit Kerja</td>
                <td style="border: 1px solid black; padding: 5px;">BPKAD Kab.Mamuju</td>
                <td style="border: 1px solid black; padding: 5px;"></td>
                <td style="border: 1px solid black; padding: 5px;"></td>
            </tr>
        </table>

        <!-- II. JENIS CUTI -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 0px;">
            <tr>
                <td colspan="3" style="border: 1px solid black; padding: 5px; border-bottom: 0px solid black">
                    <strong>II. JENIS CUTI YANG DIAMBIL *</strong>
                </td>
            </tr>
        </table>

        <!-- Checklist: two-column table (DomPDF-friendly) -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom:15px;">
            <tr>
                {{-- Kolom kiri --}}
                <td style="vertical-align: top; padding:0; width:50%;">
                    <table style="width:100%; border-collapse: collapse;">
                        @foreach ($leftItems as $index => $item)
                            <tr>
                                <td style="border:1px solid black; padding:5px;">
                                    {{ $loop->iteration * 2 - 1 }}. {{ $item->cuti->name ?? '-' }}
                                </td>
                                <td style="border:1px solid black; border-left:0; width:40px; text-align:center;"
                                    class="centang">
                                    {!! $data->cuti_type_id == $item->cuti_type_id ? '&#10003;' : '' !!}
                                    {{-- &#10003; = ✓ --}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>

                {{-- Kolom kanan --}}
                <td style="vertical-align: top; padding:0; width:50%;">
                    <table style="width:100%; border-collapse: collapse;">
                        @foreach ($rightItems as $index => $item)
                            <tr>
                                <td style="border:1px solid black; border-left:0px solid black; padding:5px;">
                                    {{ $loop->iteration * 2 }}. {{ $item->cuti->name ?? '-' }}
                                </td>
                                <td style="border:1px solid black; border-left:0; width:40px; text-align:center;">
                                    {{ $data->cuti_type_id == $item->cuti_type_id ? '✓' : '' }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>

        <!-- III. ALASAN CUTI -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
            <tr>
                <td style="border: 1px solid black; padding: 5px; background-color: transparent;"><strong>III. ALASAN
                        CUTI</strong></td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">{{ $data['alasan'] ?? '-' }}</td>
            </tr>
        </table>

        <!-- IV. LAMANYA CUTI -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
            <tr>
                <td style="border: 1px solid black; padding: 5px; background-color: transparent;"><strong>IV. LAMANYA
                        CUTI</strong></td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px;">{{ $tanggalCuti['jumlah'] ?? '-' }} Hari kerja, Mulai
                    tanggal {{ $tanggalCuti['terkecil'] }} s/d {{ $tanggalCuti['terbesar'] ?? '-'  }}</td>
            </tr>
        </table>

        <!-- V. CATATAN CUTI -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 0px;">
            <tr>
                <td colspan="3" style="border: 1px solid black; padding: 5px; border-bottom: 0px solid black">
                    <strong>V. CATATAN CUTI ***</strong>
                </td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom:15px;">
            <tr>
                <td style="vertical-align: top; padding:0; width:50%;">
                    <table style="width:100%; border-collapse: collapse;">
                        <tr>
                            <td style="border:1px solid black; padding:5px;" colspan="3">CUTI TAHUNAN</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid black; padding:5px;">TAHUN</td>
                            <td style="border:1px solid black; padding:5px;">SISA</td>
                            <td style="border:1px solid black; padding:5px;border-right: 1px solid black">KETERANGAN
                            </td>
                        </tr>
                        @forelse ($cutiTahunan as $item)
                            @php
                                $index = $totalCutiTahunan - $loop->iteration;
                            @endphp
                            <tr>
                                <td style="border:1px solid black; padding:5px;">
                                    N{{ $index == 0 ? '' : '-' . $index }}
                                </td>
                                <td style="border:1px solid black; padding:5px;">
                                    @if ($loop->last)
                                        {{ $item->sisa_kuota ?? '-' }}
                                    @else
                                        {{ $item->sisa_cuti_tersimpan ?? '-'}}
                                    @endif
                                </td>
                                <td style="border:1px solid black; padding:5px; border-right:1px solid black;"></td>
                            </tr>
                        @empty
                        @endforelse
                    </table>
                </td>
                <td style="vertical-align: top; padding:0; width:50%;">
                    <table style="width:100%; border-collapse: collapse;">
                        @forelse($cuti_type as $item)
                            <tr>
                                <td
                                    style="border:1px solid black;{{ $loop->iteration > 5 ? 'border-left:1px solid black; ' : ' border-left:0;' }} solid black; padding:5px;">
                                    {{ $loop->iteration + 1 }}.
                                    {{ $item->cuti_type ?? '-' }}</td>
                                <td
                                    style="border:1px solid black; border-left:1px solid black; border-bottom:1px solid black; width:70px; text-align:center;">
                                    {{ $item->sisa_kuota ?? '-' }}
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </table>
                </td>
            </tr>
        </table>

        <!-- VI. ALAMAT YANG MENJALANKAN CUTI -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
            <tr>
                <td colspan="3" style="border: 1px solid black; padding: 5px; background-color: transparent;">
                    <strong>VI. ALAMAT YANG MENJALANKAN CUTI</strong>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; width: 25%; vertical-align: top;">TELP</td>
                <td style="border: 1px solid black; padding: 5px; width: 25%; vertical-align: top;">TELP</td>
                <td style="border: 1px solid black; padding: 5px; width: 25%; vertical-align: top;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; width: 25%; vertical-align: top;"></td>
                <td style="border: 1px solid black; padding: 5px; width: 25%; vertical-align: top;"></td>
                <td style="border: 1px solid black; padding: 5px; width: 25%; vertical-align: top; text-align:center;">
                    <div><strong>{{ $data->user->name ?? '-' }}</strong></div>
                    <div style="text-align:center ;margin-top:5px; margin-bottom:5px">
                        @if ($isPrint == 'true')
                            <img style="width: 90px; height:90px" alt=""
                                src="data:image/png;base64, {!! $qrUser !!}">
                        @else
                            <div style="display:flex; justify-content:center; align-items:center; height:90px;">
                                {!! QrCode::format('svg')->size(90)->errorCorrection('H')->generate($data->user->name ?? '-') !!}
                            </div>
                        @endif
                    </div>
                    <div style=""><strong><u>{{ $data->user->name  ?? '-' }}</u></strong></div>
                    <div>Pangkat : {{ $data->user->pangkat ?? '-' }}</div>
                    <div>Nip. {{ $data->user->nip ?? '-' }}</div>
                </td>
            </tr>
        </table>

        <!-- VII. PERTIMBANGAN ATASAN LANGSUNG -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
            <tr>
                <td colspan="4" style="border: 1px solid black; padding: 5px; background-color: transparent;">
                    <strong>VII. PERTIMBANGAN ATASAN LANGSUNG **</strong>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; width: 23%; text-align: center;">DISETUJUI</td>
                <td style="border: 1px solid black; padding: 5px; width: 23%; text-align: center;">PERUBAHAN ****</td>
                <td style="border: 1px solid black; padding: 5px; width: 23%; text-align: center;">DITANGGUHKAN****</td>
                <td style="border: 1px solid black; padding: 5px; width: 30%; text-align: center;">DISETUJUI</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; height: 100px; vertical-align: top;"></td>
                <td style="border: 1px solid black; padding: 5px; vertical-align: top;"></td>
                <td style="border: 1px solid black; padding: 5px; vertical-align: top;"></td>
                <td style="border: 1px solid black; padding: 5px; vertical-align: bottom; text-align: right;  ">
                    <div style="text-align:center; ">
                        <div>{{ $atasan1->jabatan->name ?? '-' }}</div>
                        <div style="text-align:center;margin-top:5px; margin-bottom:5px">

                            @if ($isPrint == 'true')
                                <img style="width: 90px; height:90px" alt=""
                                    src="data:image/png;base64, {!! $qrAtasan1 !!}">
                            @else
                                <div style="display:flex; justify-content:center; align-items:center; height:90px;">
                                    {!! QrCode::format('svg')->size(90)->errorCorrection('H')->generate($atasan2->name ?? '-') !!}
                                </div>
                            @endif
                        </div>
                        <div style=""><strong><u>{{ $atasan1->name ?? '-' }}</u></strong></div>
                        <div style="font-size: 16px;">Pangkat : {{ $atasan1->pangkatRef->name ?? '-' }}</div>
                        <div style="font-size: 16px;">Nip.{{ $atasan1->nip ?? '-' }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- VIII. KEPUTUSAN PEJABAT -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
            <tr>
                <td colspan="4" style="border: 1px solid black; padding: 5px; background-color: transparent;">
                    <strong>VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **</strong>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; width: 23%; text-align: center;">DISETUJUI</td>
                <td style="border: 1px solid black; padding: 5px; width: 23%; text-align: center;">PERUBAHAN ****</td>
                <td style="border: 1px solid black; padding: 5px; width: 23%; text-align: center;">DITANGGUHKAN****
                </td>
                <td style="border: 1px solid black; padding: 5px; width: 30%; text-align: center;">DISETUJUI</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 5px; height: 120px; vertical-align: top;"></td>
                <td style="border: 1px solid black; padding: 5px; vertical-align: top;"></td>
                <td style="border: 1px solid black; padding: 5px; vertical-align: top;"></td>
                <td style="border: 1px solid black; padding: 5px; vertical-align: bottom; text-align: right;">
                    <div style="text-align:center">
                        <div>a.n. Bupati Mamuju</div>
                        <div>{{ $atasan2->jabatan->name ?? '-' }}</div>
                        <div style="text-align:center ;margin-top:5px; margin-bottom:5px">
                            @if ($isPrint == 'true')
                                <img style="width: 90px; height:90px" alt=""
                                    src="data:image/png;base64, {!! $qrAtasan1 !!}">
                            @else
                                <div style="display:flex; justify-content:center; align-items:center; height:90px;">
                                    {!! QrCode::format('svg')->size(90)->errorCorrection('H')->generate($atasan1->name  ?? '-') !!}
                                </div>
                            @endif
                        </div>
                        <div style=""><strong><u>{{ $atasan2->name  ?? '-' }}</u></strong></div>
                        <div style="font-size: 16px;">Pangkat : {{ $atasan2->pangkatRef->name  ?? '-' }}</div>
                        <div style="font-size: 16px;">Nip.{{ $atasan2->nip  ?? '-' }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- CATATAN -->
        <div style="margin-top: 20px; font-size: 10px; line-height: 1.5;">
            <div>Catatan :</div>
            <div>* &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Coret yang tidak perlu</div>
            <div>** &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pilih salah satu dengan memberi centang</div>
            <div>*** &nbsp;&nbsp;&nbsp;&nbsp; Di isi oleh pejabat yang menangani bidang kepegawaian sebelum PNS
                mengajukan cuti</div>
            <div>**** &nbsp;&nbsp;&nbsp; Di beri tanda centang dan alasannya</div>
            <div>N &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; = Cuti berjalan</div>
            <div>N-1 &nbsp;&nbsp;&nbsp;&nbsp; = Sisa cuti 1 tahun sebelumnya</div>
            <div>N-2 &nbsp;&nbsp;&nbsp;&nbsp; = Sisa cuti 2 tahun sebelumnya</div>
        </div>
    </div>
</div>
