@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto p-4 sm:p-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="text-2xl font-semibold tracking-tight">Hak Cuti</h2>
        </div>
        <div class="mt-4 mb-6 flex flex-row gap-4">
            <!-- Tabel Tahun/Sisa -->
            <div class="w-auto">
                <div class="rounded-xl border border-gray-200 bg-white p-2 ">
                    <div class="div">
                        <table class="min-w-full text-sm border-0">
                            <thead>
                                <tr class="text-gray-600 border-0">
                                    <th class="py-3 px-3 text-center font-semibold">Tahun</th>
                                    <th class="py-3 px-3 text-center font-semibold">Sisa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y border-0">
                                <tr class="border-b-0">
                                    <td class="py-1 px-3">2025</td>
                                    <td class="py-1 px-3">12 Hari</td>
                                </tr>
                                <tr class="border-b-0">
                                    <td class="py-1 px-3">2024</td>
                                    <td class="py-1 px-3">6 Hari</td>
                                </tr>
                                <tr class="border-b-0">
                                    <td class="py-1 px-3">2023</td>
                                    <td class="py-1 px-3">3 Hari</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <div class="grid grid-cols-3 ps-3 font-semibold text-gray-600  pb-2 text-sm">
                        <div class="text-left">Tipe Cuti</div>
                        <div class="text-center">Sisa</div>
                        <div class="text-left">Deskripsi</div>
                    </div>

                    <div class="grid grid-cols-3 ps-3 text-sm py-1">
                        <div class="text-left">Cuti Tahunan</div>
                        <div class="text-center">9 Hari</div>
                        <div class="text-left">Cuti Tahunan Hari</div>
                    </div>

                    <div class="grid grid-cols-3 ps-3 text-sm py-1">
                        <div class="text-left">Cuti Sakit</div>
                        <div class="text-center">12 Hari</div>
                        <div class="text-left">Cuti Sakit Hari</div>
                    </div>

                    <div class="grid grid-cols-3 ps-3 text-sm py-1">
                        <div class="text-left">Cuti Alasan Penting</div>
                        <div class="text-center">10 Hari</div>
                        <div class="text-left">Cuti Alasan Penting Hari</div>
                    </div>
                </div>
            </div>


        </div>

        <h2 class="text-2xl font-semibold mb-3">Riwayat <span class="font-extrabold">Cuti</span></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                <div class="px-4 py-3 shadow bg-red-500 flex items-center justify-between">
                    <h4 class="font-semibold text-white text-xl">Ditolak</h4>
                    <h4 class="font-semibold text-white text-xl">3</h4>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <h5 class="font-medium text-lg">Rincian</h5>
                    <button>
                        <i class="fa-regular cursor-pointer hover:scale-110  text-red-500 fa-xl fa-circle-right"></i>
                    </button>

                </div>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                <div class="px-4 py-3 shadow bg-[#f9981b] flex items-center justify-between">
                    <h4 class="font-semibold text-white text-xl">Dalam Proses</h4>
                    <h4 class="font-semibold text-white text-xl">3</h4>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <h5 class="font-medium text-lg">Rincian</h5>
                    <button>
                        <i class="fa-regular cursor-pointer hover:scale-110  text-[#f9981b] fa-xl fa-circle-right"></i>
                    </button>

                </div>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                <div class="px-4 py-3 shadow bg-green-500 flex items-center justify-between">
                    <h4 class="font-semibold text-white text-xl">Diterima</h4>
                    <h4 class="font-semibold text-white text-xl">3</h4>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <h5 class="font-medium text-lg">Rincian</h5>
                    <button>
                        <i class="fa-regular cursor-pointer hover:scale-110  text-green-500 fa-xl fa-circle-right"></i>
                    </button>

                </div>
            </div>
        </div>

        <!-- Riwayat Izin -->
        <h2 class="text-2xl font-semibold mb-3">Riwayat <span class="font-extrabold">Izin</span></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                <div class="px-4 py-3 shadow bg-red-500 flex items-center justify-between">
                    <h4 class="font-semibold text-white text-xl">Ditolak</h4>
                    <h4 class="font-semibold text-white text-xl">3</h4>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <h5 class="font-medium text-lg">Rincian</h5>
                    <button>
                        <i class="fa-regular cursor-pointer hover:scale-110  text-red-500 fa-xl fa-circle-right"></i>
                    </button>

                </div>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                <div class="px-4 py-3 shadow bg-[#f9981b] flex items-center justify-between">
                    <h4 class="font-semibold text-white text-xl">Dalam Proses</h4>
                    <h4 class="font-semibold text-white text-xl">3</h4>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <h5 class="font-medium text-lg">Rincian</h5>
                    <button>
                        <i class="fa-regular cursor-pointer hover:scale-110  text-[#f9981b] fa-xl fa-circle-right"></i>
                    </button>

                </div>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                <div class="px-4 py-3 shadow bg-green-500 flex items-center justify-between">
                    <h4 class="font-semibold text-white text-xl">Diterima</h4>
                    <h4 class="font-semibold text-white text-xl">3</h4>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <h5 class="font-medium text-lg">Rincian</h5>
                    <button>
                        <i class="fa-regular cursor-pointer hover:scale-110  text-green-500 fa-xl fa-circle-right"></i>
                    </button>

                </div>
            </div>
        </div>

    @endsection
