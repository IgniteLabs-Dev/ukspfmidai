<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pengajuan</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;  color: #334155;">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
    <tr>
        <td align="center" style="padding: 40px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;background-color: #ffffff;border-radius: 16px;overflow: hidden;border: 1px solid #e5e7eb;box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <!-- Header Banner (Dynamic Color) -->
                <tr>
                    <td align="center" style="background-color: {{ $status == 'success' ? '#10b981' : '#ef4444' }}; padding: 40px 20px;">
                        <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; letter-spacing: 0.05em; text-transform: uppercase;">
                            Pengajuan {{$tipe}} {{ $status == 'success' ? 'Disetujui' : 'Ditolak' }}
                        </h1>
                    </td>
                </tr>

                <!-- Main Content -->
                <tr>
                    <td style="padding: 40px 30px;">
                        <p style="margin-top: 0; font-size: 18px; line-height: 1.6;">
                            Halo, <strong>{{ $nama }}</strong>
                        </p>

                        <p style="font-size: 16px; line-height: 1.6; color: #475569;">
                            @if($status == 'success')
                                Kabar baik! Pengajuan <strong>{{ $jenis }}</strong> kamu telah ditinjau dan statusnya kini adalah <span style="color: #10b981; font-weight: bold; background-color: #ecfdf5; padding: 1px 8px; border-radius: 4px;">DISETUJUI</span>.
                            @else
                                Mohon maaf, pengajuan <strong>{{ $jenis }}</strong> kamu telah ditinjau dan statusnya kini adalah <span style="color: #ef4444; font-weight: bold; background-color: #fef2f2; padding: 1px 8px; border-radius: 4px;">DITOLAK</span>.
                            @endif
                        </p>

                        <!-- Data Card -->
                        <div style="margin-top: 30px; background-color: #f1f5f9; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="40%" style="padding: 8px 0; font-size: 13px; color: #64748b; font-weight: 600; text-transform: uppercase;">Tanggal Mulai</td>
                                    <td style="padding: 8px 0; font-size: 14px; color: #1e293b; ">: {{ $tanggal_mulai }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b; font-weight: 600; text-transform: uppercase;">Tanggal Selesai</td>
                                    <td style="padding: 8px 0; font-size: 14px; color: #1e293b; ">: {{ $tanggal_selesai }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 13px; color: #64748b; font-weight: 600; text-transform: uppercase;">Keperluan</td>
                                    <td style="padding: 8px 0; font-size: 14px; color: #1e293b;">: {{ $keterangan }}</td>
                                </tr>

                                {{-- Row tambahan jika ditolak --}}
                                @if($status == 'failed')
                                    <tr>
                                        <td colspan="2" style="padding-top: 15px; border-top: 1px solid #cbd5e1;">
                                            <p style="margin: 0; font-size: 13px; color: #1e293b; font-weight: 700; text-transform: uppercase;">Alasan Ditolak :</p>
                                            <p style="margin: 5px 0 0 0; font-size: 14px; color: #64748b;">
                                                {{ $alasan ?? 'Tidak ada alasan spesifik yang diberikan.' }}
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <div style="margin-top: 40px; text-align: center;">
                            <a href="{{ $status == 'cuti' ? url('/riwayat-cuti') : url('/riwayat-izin') }}" style="background-color: #1e293b; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-block;">
                                Lihat Riwayat Pengajuan
                            </a>
                        </div>
                    </td>
                </tr>


            </table>
        </td>
    </tr>
</table>
</body>
</html>
