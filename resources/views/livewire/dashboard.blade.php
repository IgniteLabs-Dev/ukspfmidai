<div>
    <div class="bg-white rounded-xl p-4">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="text-2xl font-semibold tracking-tight">Hak Cuti</h2>
        </div>
        <div class="mt-4 mb-6 flex flex-row gap-4">
            <!-- Tabel Tahun/Sisa -->
            <div class="w-auto">
                <div class="rounded-xl border border-gray-300 bg-gray-50 p-2 ">
                    <div class="div">
                        <table class="min-w-full text-sm border-0">
                            <thead>
                                <tr class="text-gray-600 border-0">
                                    <th class="py-3 px-3 text-center font-semibold">Tahun</th>
                                    <th class="py-3 px-3 text-center font-semibold">Sisa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y border-0">
                                @forelse ($cutiTahunan as $item)
                                    <tr class="border-b-0">
                                        <td class="py-1 px-3">{{ $item->tahun }}</td>
                                        <td class="py-1 px-3">
                                            @if ($loop->last)
                                                {{ $item->sisa_kuota }} Hari
                                            @else
                                                {{ $item->sisa_cuti_tersimpan }} Hari
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">-</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <div class="rounded-xl border border-gray-300 bg-gray-50 p-4">
                    <div class="grid grid-cols-3 ps-3 font-semibold text-gray-600  pb-2 text-sm">
                        <div class="text-left">Tipe Cuti</div>
                        <div class="text-center">Sisa</div>
                        <div class="text-left">Deskripsi</div>
                    </div>

                    @forelse($cuti_type as $item)
                        <div class="grid grid-cols-3 ps-3 text-sm py-1">
                            <div class="text-left">{{ $item->cuti_type }}</div>
                            <div class="text-center">{{ $item->sisa_kuota }} Hari</div>
                            <div class="text-left">{{ $item->cuti_type }}</div>
                        </div>
                    @empty
                        <div class="grid grid-cols-1 justify-center text-center ps-3 text-sm py-1">
                            <div class="text-left">-</div>
                        </div>
                    @endforelse
                </div>
            </div>


        </div>



        <div class="p-3 border rounded-xl bg-gray-50 border-gray-300 mb-3">
            <!-- Riwayat Cuti -->
            <h2 class="text-2xl font-semibold mb-3">Riwayat Cuti</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--danger)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Ditolak</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $CutiFailed }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('riwayat-cuti', ['status' => 'failed']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--danger)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--warning)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Dalam Proses</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $CutiPending }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('riwayat-cuti', ['status' => 'pending']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--warning)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--success)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Diterima</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $CutiSuccess }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('riwayat-cuti', ['status' => 'success']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--success)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Riwayat Izin -->
            <h2 class="text-2xl font-semibold mb-3">Riwayat Izin</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--danger)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Ditolak</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $IzinFailed }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('riwayat-izin', ['status' => 'failed']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--danger)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--warning)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Dalam Proses</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $IzinPending }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('riwayat-izin', ['status' => 'pending']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--warning)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--success)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Diterima</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $permohonanIzinSuccess }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('riwayat-izin', ['status' => 'success']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--success)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <div class="p-3 border rounded-xl bg-gray-50 border-gray-300">
            <!-- Permohonan cuti -->
            <h2 class="text-2xl font-semibold mb-3">Permohonan Cuti</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--danger)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Ditolak</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $permohonanCutiFailed }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('permohonan-cuti', ['status' => 'failed']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--danger)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--warning)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Dalam Proses</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $permohonanCutiWaiting }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('permohonan-cuti', ['status' => 'waiting']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--warning)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--success)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Diterima</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $permohonanCutiSuccess }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('permohonan-cuti', ['status' => 'success']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--success)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
            </div>
            <!-- Permohohonan Izin -->
            <h2 class="text-2xl font-semibold mb-3">Permohohonan Izin</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--danger)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Ditolak</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $permohonanIzinFailed }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('permohonan-izin', ['status' => 'failed']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--danger)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--warning)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Dalam Proses</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $permohonanIzinWaiting }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('permohonan-izin', ['status' => 'waiting']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--warning)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <div class="px-4 py-3 shadow bg-[var(--success)] flex items-center justify-between">
                        <h4 class="font-semibold text-white text-xl">Diterima</h4>
                        <h4 class="font-semibold text-white text-xl">{{ $IzinSuccess }}</h4>
                    </div>

                    <div class="p-4 flex items-center justify-between">
                        <h5 class="font-medium text-lg">Rincian</h5>
                        <a href="{{ route('permohonan-izin', ['status' => 'success']) }}">
                            <button>
                                <i
                                    class="fa-regular cursor-pointer hover:scale-110  text-[var(--success)] fa-xl fa-circle-right"></i>
                            </button>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
