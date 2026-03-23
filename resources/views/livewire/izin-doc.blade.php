<div>
    <div style="font-family: 'Times New Roman', Times, serif; margin: 0; padding: 20px; background-color: transparent;">
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #000; padding-bottom: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0px;">

                <!-- Kiri (25%) -->
                <div style="width: 10%; text-align: left;">
                    @if ($isPrint == 'true')
                        <img src="data:image/png;base64,{{ $logoData }}" alt="logo"
                            style="width:80px; height:auto;">
                    @else
                        <img src="{{ asset('images/logo_kab_mamuju.png') }}" alt=""
                            style="width: 80px; height: auto;">
                    @endif
                </div>

                <!-- Tengah (50%) -->
                <div style=" text-align: center;">
                    <h2 style="margin: 0; font-size: 22px; font-weight: bold;">PEMERINTAH KABUPATEN MAMUJU</h2>
                    <h3 style="margin: 5px 0; font-size: 20px; font-weight: bold;">
                        BADAN PENGELOLA KEUANGAN DAN ASET DAERAH
                    </h3>
                    <p style="margin: 5px 0; font-size: 15px; font-style: italic;">
                        Jl. Soekarno-Hatta No. 17 Mamuju Tlp. (0426) 21065 Kode Pos 91511
                    </p>
                </div>

                <!-- Kanan (25%) -->
                <div style="width: 1%; text-align: right;">

                </div>

            </div>
        </div>


        <!-- Title -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h4 style="margin: 5px 0; font-size: 16px; text-decoration: underline;">SURAT IZIN</h4>
            <p style="margin: 5px 0; font-size: 16px;">NOMOR {{ $data['nomor_surat'] }}</p>
            <p style="margin: 5px 0; font-size: 16px;">TENTANG</p>
            <h4 style="margin: 5px 0; font-size: 16px; font-weight: bold;">IZIN MENINGGALKAN TUGAS SEMENTARA</h4>
        </div>

        <!-- Content -->
        <div style="margin-bottom: 30px; line-height: 1.8;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <tr>
                    <td style="width: 25%; vertical-align: top; padding: 5px 0;">Dasar</td>
                    <td style="width: 5%; vertical-align: top; padding: 5px 0;">:</td>
                    <td style="vertical-align: top; padding: 5px 0;">Permohonan sdr(i)
                        <strong>{{ $data['user']['name'] }}</strong> Nip.{{ $data['user']['nip'] }}
                    </td>
                </tr>
            </table>
        </div>

        <div style="text-align: center; margin: 30px 0; font-size: 14px;">
            MEMBERI IZIN
        </div>

        <!-- Employee Details -->
        <div style="margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px; line-height: 1.8;">
                <tr>
                    <td style="width: 25%; vertical-align: top; padding: 5px 0;">Kepada</td>
                    <td style="width: 5%; vertical-align: top; padding: 5px 0;">:</td>
                    <td style="vertical-align: top; padding: 5px 0;"></td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding: 5px 0;">Nama</td>
                    <td style="vertical-align: top; padding: 5px 0;">:</td>
                    <td style="vertical-align: top; padding: 5px 0;"><strong>{{ $data['user']['name'] }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding: 5px 0;">NIP</td>
                    <td style="vertical-align: top; padding: 5px 0;">:</td>
                    <td style="vertical-align: top; padding: 5px 0;">{{ $data['user']['nip'] }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding: 5px 0;">Pangkat/Gol Ruang</td>
                    <td style="vertical-align: top; padding: 5px 0;">:</td>
                    <td style="vertical-align: top; padding: 5px 0;">{{ $data['user']['pangkatRef']['name'] ?? '' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding: 5px 0;">Jabatan</td>
                    <td style="vertical-align: top; padding: 5px 0;">:</td>
                    <td style="vertical-align: top; padding: 5px 0;">{{ $data['user']['jabatan']['name'] ?? '' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding: 5px 0;">Instansi</td>
                    <td style="vertical-align: top; padding: 5px 0;">:</td>
                    <td style="vertical-align: top; padding: 5px 0;">Pemerintah Kabupaten Mamuju</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding: 5px 0;">Untuk</td>
                    <td style="vertical-align: top; padding: 5px 0;">:</td>
                    <td style="vertical-align: top; padding: 5px 0;">{{ $data['keperluan'] }}</td>
                </tr>
            </table>
        </div>

        <!-- Signature Section -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px; border:0px transparent">
            <tr>
                <td style="width: 60%; border: 1px solid black; padding: 5px; text-align: left;border:0px transparent">
                </td>
                <td style="width: 40%; border: 1px solid black; padding: 5px; text-align: left; border:0px transparent">
                    <div style="margin-top: 0; text-align: left; font-size: 14px;">
                        <p style="margin: 5px 0;">Mamuju,
                            {{ \Carbon\Carbon::parse($data->updated_at)->locale('id')->isoFormat('D MMMM YYYY') }}
                        </p>
                        <p style="margin: 5px 0;">{{ $data->user->jabatan->name  ?? ''}},</p>
                        @if ($isPrint == true)
                            <img style="width: 90px; heigh:90px" alt=""
                                src="data:image/png;base64, {!! $qrcode !!}">
                        @else
                            {!! QrCode::format('svg')->size(90)->errorCorrection('H')->generate($data->user->name) !!}
                        @endif
                        <p style="margin: 5px 0; font-weight: bold;">{{ $data->user->name }}</p>
                        <p style="margin: 5px 0;">Pangkat : {{ $data->user->pangkatRef->name ?? '' }}</p>
                        <p style="margin: 5px 0;">NIP.{{ $data->user->nip }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
