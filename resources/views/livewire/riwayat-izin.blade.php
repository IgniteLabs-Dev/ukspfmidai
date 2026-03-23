<div class="bg-white rounded-xl p-4">
    <h2 class="text-2xl mb-5 font-bold text-center">
        Riwayat Izin
    </h2>
    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4 mb-6">
        <div class="flex-1">
            <x-select label="Tipe Izin" for="izinType" wire="izinType" wireType="change" placeholder="Semua Tipe Izin"
                :options="$izinTypesData" :required="false" />
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
                placeholder="Masukkan Keperluan" />
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
                        Izin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Keperluan</th>
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
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->izinType->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @foreach (explode(',', $item->tanggal) as $tgl)
                                <span
                                    class="inline-block bg-[var(--info)] text-white text-xs font-semibold mb-0.5 px-1.5 py-0.5 rounded">
                                    {{ trim($tgl) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->keperluan }}</td>
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
</div>
