<div>
    <div class="bg-white rounded-xl p-4">
        <div class="  rounded-xl  ">
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
        @if ($cutiIzinApprover['is_cuti_approver'] == true || $cutiIzinApprover['is_izin_approver'] == true)
        <div class="p-3 border rounded-xl bg-gray-50 border-gray-300 mt-3">
            @if ($cutiIzinApprover['is_cuti_approver'] == true)
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
            @endif

            @if ($cutiIzinApprover['is_izin_approver'] == true)
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
            @endif
        </div>
            @endif
    </div>
</div>
