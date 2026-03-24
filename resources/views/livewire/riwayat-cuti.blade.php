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
        </div>        <div class="flex-1">
            <x-select label="Bulan" for="bulan" wire="bulan" wireType="change" placeholder="Semua Bulan"
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
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Alasan</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($data as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $data->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->cutiType->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 text-center">
                            {{ \Carbon\Carbon::parse($item->tanggal_start)->translatedFormat('d F Y') }} 🠖
                            {{ \Carbon\Carbon::parse($item->tanggal_end)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->alasan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 text-center">
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
                        <td class="px-6 py-4 text-sm text-gray-900 flex justify-center gap-1">
                            <button @click="$dispatch('open-pdf', { url: '{{ asset('files/'. $item->doc) }}' })"
                                    class="bg-[var(--primary)] text-white px-1 py-1 rounded-md hover:cursor-pointer hover:scale-105">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <a href="{{ asset('files/'. $item->doc) }}" download
                               class="bg-[var(--warning)] text-white px-1 py-1 rounded-md hover:cursor-pointer hover:scale-105 inline-flex items-center">
                                <i class="fa-solid fa-download"></i>
                            </a>
                            <button @click="$dispatch('open-edit')"
                                    wire:click="edit({{ $item->id }})"
                                    class="bg-[var(--info)] text-white px-1 py-1 rounded-md hover:cursor-pointer hover:scale-105">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button wire:click="destroy({{ $item->id }})"
                                    wire:confirm="Apakah anda yakin ingin menghapus data ini?"
                                    class="bg-[var(--danger)] text-white px-1 py-1 rounded-md hover:cursor-pointer hover:scale-105">
                                <i class="fa-solid fa-x"></i>
                            </button>
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

    <div x-data="{ viewPDF: false, pdfUrl: '', editModal: false }"
         @open-pdf.window="viewPDF = true; pdfUrl = $event.detail.url"
         @open-edit.window="editModal = true"
         @close-edit.window="editModal = false">

        <div wire:ignore>


        <!-- Backdrop PDF -->
        <div x-show="viewPDF" x-cloak @click="viewPDF = false"
             class="fixed inset-0 bg-black/50 z-40">
        </div>

        <!-- Modal PDF -->
        <div x-show="viewPDF" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl h-[90vh] flex flex-col">
                <div class="flex items-center justify-between p-4 border-b border-gray-200 shrink-0">
                    <h3 class="text-lg font-semibold text-gray-800">Preview Dokumen</h3>
                    <button @click="viewPDF = false; pdfUrl = ''"
                            class="text-gray-600 px-0 py-1 cursor-pointer bg-gray-300 rounded-md hover:text-gray-600 transition">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button>
                </div>
                <div class="flex-1 overflow-hidden p-0">
                    <iframe
                        :src="`/pdfjs/web/viewer.html?file=${encodeURIComponent(pdfUrl)}`"
                        class="w-full h-full rounded-md border border-gray-200">
                    </iframe>
                </div>
            </div>
        </div>
        </div>
        <!-- Backdrop Edit -->
        <div x-show="editModal" x-cloak @click="editModal = false"
             class="fixed inset-0 bg-black/50 z-40">
        </div>

        <!-- Modal Edit -->
        <div x-show="editModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg flex flex-col">

                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Cuti</h3>
                    <button @click="editModal = false" wire:click="resetInput"
                            class="text-gray-400 hover:text-gray-600 transition cursor-pointer">
                        <i class="fa-solid fa-xmark fa-xl"></i>
                    </button>
                </div>
                    <div class="div" wire:loading wire:target="edit">
                                    <div class="w-full flex items-center justify-center p-8" >
                                        <i class="fa-solid fa-spinner fa-spin text-2xl text-gray-400"></i>
                                    </div>
                    </div>
                <!-- Body -->
                <div class="p-4 flex flex-col gap-3" wire:loading.remove wire:target="edit">

                    <!-- Jenis Cuti -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Jenis Cuti</label>
                        <select wire:model="form.cuti_type_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]">
                            <option value="">-- Pilih Jenis Cuti --</option>
                            @foreach($cutiTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('form.cuti_type_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Alasan -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Alasan</label>
                        <textarea wire:model="form.alasan" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"
                                  placeholder="Masukkan alasan cuti..."></textarea>
                        @error('form.alasan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-row justify-between gap-2">                <!-- Tanggal Mulai -->
                        <div class="w-full">
                            <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" wire:model="form.tanggal_mulai"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"/>
                            @error('form.tanggal_mulai') <p
                                class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="w-full">
                            <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" wire:model="form.tanggal_selesai"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary)]"/>
                            @error('form.tanggal_selesai') <p
                                class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Dokumen</label>

                        <!-- Tampil file lama -->
                        @if($editDoc)
                            <div class="flex items-center gap-2 mb-2 p-2 bg-gray-50 border border-gray-200 rounded-lg">
                                <i class="fa-solid fa-file-pdf text-[var(--primary)]"></i>
                                <span class="text-sm text-gray-600 flex-1 truncate">{{ $editDoc }}</span>
                                <button type="button" wire:click="$set('editDoc', null)"
                                        class="text-xs bg-red-500 text-white rounded-md p-2 hover:scale-102 cursor-pointer">
                                    <i class="fa-solid fa-xmark"></i> Ganti
                                </button>
                            </div>
                        @endif

                        <!-- Input file baru, muncul kalau editDoc null -->
                        @if(!$editDoc)
                            <input type="file" wire:model="form.doc" accept=".pdf,.doc,.docx"
                                   class="bg-gray-50 w-full rounded-md file:bg-gray-400 file:text-white border border-gray-200 cursor-pointer" />
                            <p class="mt-1 text-xs text-gray-500">Format: <span class="font-medium">PDF, DOC, DOCX</span> &bull; Maks <span class="font-medium">10 MB</span></p>
                            @error('form.doc') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-2 p-4 border-t border-gray-200">
                    <button @click="editModal = false"
                            class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition cursor-pointer">
                        Batal
                    </button>
                    <button wire:click="update"
                            class="px-4 py-2 text-sm text-white bg-[var(--primary)] rounded-lg hover:opacity-90 transition cursor-pointer">
                        Simpan
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>
