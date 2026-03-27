<div>
    <div>
<div class="my-3 flex justify-between">
    <a href="{{ route('manajemen-user') }}">
        <button
            class="inline-flex cursor-pointer items-center justify-center w-8 h-8 rounded-md bg-[var(--primary)] text-white p-0 m-0">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </a>
    <h2 class="p-0 m-0 text-start text-2xl font-bold">Manajemen Cuti dan Izin {{ $user->name }}</h2>
    <div class="div">

    </div>
</div>
        <div class="bg-white rounded-xl p-4">

            <div class="p-4">
                    <div class="flex justify-between">
                        <div class="flex gap-2">


                        <h2 class="p-0 m-0 text-start text-2xl font-bold">Cuti {{ $user->name }}</h2>
                        </div>
                        <div class="flex gap-2">
                            <x-select label="" for="tahun" wire="tahun" wireType="change" placeholder="Semua Tahun"
                                      :options="$tahunData" :required="false" />
                            <x-select label="" for="bulan" wire="bulan" wireType="change" placeholder="Semua Bulan"
                                      :options="[
                                            '1' => 'Januari',
                                            '2' => 'Februari',
                                            '3' => 'Maret',
                                            '4' => 'April',
                                            '5' => 'Mei',
                                            '6' => 'Juni',
                                            '7' => 'Juli',
                                            '8' => 'Agustus',
                                            '9' => 'September',
                                            '10' => 'Oktober',
                                            '11' => 'November',
                                            '12' => 'Desember',
                                        ]" :required="false" />
                        <x-select label="" for="cutiTypeFilter" wire="cutiTypeFilter" wireType="change" placeholder="Semua Cuti" :options="$cutiTypes" />
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mt-3">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-2">

                                <div class="w-75 flex  space-x-2">
                                    <div class="w-full">

                                    </div>

                                    <div class="w-full">

                                    </div>
                                </div>

                            </div>
                            <div class="w-full mt-3 py-2">
                                <div class="relative overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">No</th>
                                                <th scope="col" class="px-6 py-3 text-center">Tahun</th>
                                                <th scope="col" class="px-6 py-3 text-center">Jenis Cuti</th>
                                                <th scope="col" class="px-6 py-3 text-center">Bulan</th>
                                                <th scope="col" class="px-6 py-3 text-center">Cuti Digunakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @forelse($data as $item)
                                            <tr class="bg-white border-b border-gray-200">
                                                <td class="px-6 py-3">{{ $data->firstItem() + $loop->index }}</td>
                                                <td class="px-6 py-3 text-center">{{ $item->tahun }}</td>
                                                <td class="px-6 py-3 text-center">
                                                    {{ $item->nama_cuti }}
                                                </td>
                                                <td class="px-6 py-3 text-center">
                                                    {{ \Carbon\Carbon::create()->month($item->bulan)->locale('id')->translatedFormat('F') }}
                                                </td>
                                                <td class="px-6 py-3 text-center">{{ $item->total }}</td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white border-b border-gray-200">
                                                <td colspan="5" class="px-6 py-3 text-center">Tidak ada data cuti.</td>
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                                <div class="mt-3">
                                {{ $data->links() }}
                                </div>
                        </div>
                    </div>


            </div>
        </div>
    </div>

    <div class="mt-3">
        @livewire('manajemen-izin-user', ['id' => $user->id])
    </div>
</div>
