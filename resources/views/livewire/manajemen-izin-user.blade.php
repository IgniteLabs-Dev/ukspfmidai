<div>
    <div>

        <div class="bg-white rounded-xl p-4">
            <div class="p-4">
                <div class="flex justify-between">
                    <div class="flex gap-2">

                        <h2 class="p-0 m-0 text-start text-2xl font-bold">Izin {{ $user->name }}</h2>
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
                        <x-select label="" for="izinTypeFilter" wire="izinTypeFilter" wireType="change" placeholder="Semua Izin" :options="$izinTypes" />
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
                                        <th scope="col" class="px-6 py-3 text-center">Jenis Izin</th>
                                        <th scope="col" class="px-6 py-3 text-center">Bulan</th>
                                        <th scope="col" class="px-6 py-3 text-center">Izin Digunakan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp

                                    @forelse($data as $item)
                                        <tr class="bg-white border-b border-gray-200">
                                            <td class="px-6 py-3">{{ $no++ }}</td>
                                            <td class="px-6 py-3 text-center">{{ $item->tahun }}</td>
                                            <td class="px-6 py-3 text-center">
                                                {{ $item->nama_izin }}
                                            </td>
                                            <td class="px-6 py-3 text-center">
                                                {{ \Carbon\Carbon::create()->month($item->bulan)->locale('id')->translatedFormat('F') }}
                                            </td>
                                            <td class="px-6 py-3 text-center">{{ $item->total }}</td>
                                        </tr>
                                    @empty
                                        <tr class="bg-white border-b border-gray-200">
                                            <td colspan="5" class="px-6 py-3 text-center">Tidak ada data izin.</td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>

</div>
