<div class="bg-white rounded-xl p-4">
    <h2 class="text-2xl mb-5 font-bold text-center">
        Riwayat Cuti
    </h2>
    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4 mb-6">
        <div class="flex-1">
            <x-select label="Tipe Cuti" for="cutiType" wire="cutiType" wireType="change" placeholder="Semua Tipe Cuti"
                :options="$cutiTypesData" :required="false" />
        </div>
        <div class="flex-1">
            <x-select label="Tahun" for="tahun" wire="tahun" wireType="change" placeholder="Semua Tahun"
                :options="$tahunData" :required="false" />
        </div>
        <div class="flex-1">
            <x-select label="Status" for="status" wire="status" wireType="change" placeholder="Semua Status"
                :options="[
                    'failed' => 'Ditolak',
                    'pending' => 'Menunggu',
                    'success' => 'Diterima',
                ]" />
        </div>
        <div class="flex-1">
            <x-input label="Pencarian" for="filter" wire="filter" wireType="live" type="text"
                placeholder="Masukkan Alasan" />
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                        Cuti</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Alasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($data as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $data->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->cutiType->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @foreach (explode(',', $item->tanggal) as $tgl)
                                <span
                                    class="inline-block bg-[var(--info)] text-white text-xs font-semibold mb-0.5 px-1.5 py-0.5 rounded">
                                    {{ trim($tgl) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->alasan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span
                                class="px-3 py-1 rounded-full text-white text-xs font-semibold
        @if ($item->status === 'success') bg-[var(--success)]
        @elseif($item->status === 'failed')
            bg-[var(--danger)]
        @else
            bg-[var(--warning)] @endif">
                                @if ($item->status === 'success')
                                    Diterima
                                @elseif($item->status === 'failed')
                                    Ditolak
                                @else
                                    Menunggu
                                @endif
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-900">
                            <button wire:click="viewFlow({{ $item->id }})" type="button"
                                data-modal-target="default-modal" data-modal-toggle="default-modal"
                                class="text-white bg-[var(--info)] hover:brightness-90 hover:cursor-pointer font-medium rounded-lg text-sm px-1 py-1 me-2 mb-2"><i
                                    class="fa-solid fa-sitemap"></i></button>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if ($item->status === 'success')
                                <button wire:click="downloadPdf({{ $item->id }})"
                                    class="bg-[var(--primary)] text-white px-1 py-1 rounded-md hover:cursor-pointer hover:scale-105"><i
                                        class="fa-solid fa-print"></i></button>
                            @else
                                <x-button disabled="true" bg="gray-500" px="1" py="1"
                                    label='<i class="fa-solid fa-print"></i>' />
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 bg-gray-50">
                            Data Tidak Ada
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $data->links('vendor.livewire.tailwind') }}
    </div>

    <div wire:ignore.self id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Tahapan Approval Cuti
                    </h3>
                    <button type="button"
                        class="text-gray-400 hover:cursor-pointer bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <!-- component -->
                    <div class="w-full py-6">
                        <div class="flex ">
                            @if ($flowData)
                                @forelse ($flowData as $index => $item)
                                    <div class="flex-1">
                                        <div class="relative mb-2">
                                            {{-- Garis penghubung antar step --}}
                                            @if ($index > 0)
                                                <div class="absolute flex items-center"
                                                    style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                                                    <div class="w-full bg-gray-200 rounded">
                                                        <div class="w-0 bg-green-500 py-1 rounded"
                                                            style="width: {{ $item->progress ?? '100%' }};"></div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Icon step --}}
                                            <div
                                                class="w-10 h-10 mx-auto rounded-full flex items-center justify-center text-white
                                                @if ($item->status == 'success') bg-[var(--success)]
                                                @elseif ($item->status == 'waiting')
                                                    bg-[var(--warning)]
                                                @elseif ($item->status == 'failed')
                                                    bg-[var(--danger)]
                                                @elseif ($item->status == 'pending')
                                                    bg-gray-500
                                                @else
                                                    bg-gray-300 @endif">
                                                <span class="w-full text-center">
                                                    @if ($item->status == 'success')
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    @elseif ($item->status == 'waiting')
                                                        <i class="fa-solid fa-hourglass-start"></i>
                                                    @elseif ($item->status == 'pending')
                                                        <i class="fa-solid fa-clock"></i>
                                                    @elseif ($item->status == 'failed')
                                                        <i class="fa-solid fa-circle-xmark"></i>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>


                                        <div class="text-xs text-center md:text-base">
                                            <div class="flex flex-col items-center justify-center">
                                                <div>
                                                    {{ $item->approvalLevel->jabatan->name ?? 'Unknown' }}
                                                </div>
                                                @if ($item->updated_at && $item->updated_at != $item->created_at)
                                                    <div class="text-gray-500 text-[10px] md:text-xs mt-0">
                                                        {{ $item->updated_at->locale('id')->translatedFormat('d M Y H:i') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>




                                    </div>
                                @empty
                                    <div class="text-center text-gray-500">Belum ada data flow</div>
                                @endforelse
                            @endif
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
