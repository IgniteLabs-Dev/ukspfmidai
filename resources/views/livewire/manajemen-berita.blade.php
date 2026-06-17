
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="w-full mb-6">
            <h2 class="text-xl sm:text-3xl font-bold text-center text-gray-800">Manajemen Berita</h2>
        </div>

        @if (session('success'))
            <div id="alert-success" class="mb-4 flex justify-center w-full">
                <div class="relative px-4 py-3 rounded-lg bg-green-100 text-green-700 text-sm font-semibold w-full">

                    {{ session('success') }}

                    <button onclick="closeAlert('alert-success')"
                        class="absolute cursor-pointer top-2 right-2 w-8 h-8 flex items-center justify-center text-green-600 hover:text-green-800 text-xl font-bold rounded-full hover:bg-green-200 transition">
                        <i class="fa-solid fa-circle-xmark "></i>
                    </button>

                </div>
            </div>
        @endif

        @if (session('error'))
            <div id="alert-error" class="mb-4 flex justify-center">
                <div
                    class="relative px-4 py-2 rounded-lg bg-red-100 text-red-700 border border-red-300 text-sm font-semibold shadow-sm">

                    {{ session('error') }}

                    <button onclick="closeAlert('alert-success')"
                        class="absolute cursor-pointer top-2 right-2 w-8 h-8 flex items-center justify-center text-green-600 hover:text-green-800 text-xl font-bold rounded-full hover:bg-green-200 transition">
                        <i class="fa-solid fa-circle-xmark "></i>
                    </button>

                </div>
            </div>
        @endif

        <div class="w-full">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mt-4">
                <div class="flex-1">
                    <div class="relative">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input wire:model.live="filter" type="text" placeholder="Cari Berita..."
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2.5" />
                    </div>
                </div>

                <a href="{{ route('manajemen-berita-create') }}" class="w-full sm:w-auto">
                    <x-button label="Tambah Berita" class="w-full whitespace-nowrap justify-center" />
                </a>
            </div>

            <div class="w-full mt-5">
                <div class="relative overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-center font-bold">No</th>
                                <th scope="col" class="px-4 py-4 font-bold min-w-[200px]">Judul Berita</th>
                                <th scope="col" class="px-4 py-4 text-center font-bold">Cover</th>
                                <th scope="col" class="px-4 py-4 text-center font-bold">Status</th>
                                <th scope="col" class="px-4 py-4 text-center font-bold min-w-[120px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($data as $item)
                                <tr class="hover:bg-blue-50/50 transition-colors odd:bg-white even:bg-gray-50/50">
                                    <td class="px-4 py-4 text-center font-medium text-gray-500">
                                        {{ $data->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-4 py-4  text-gray-900 leading-relaxed">
                                        {{ $item->title }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-center">
                                            <img class="h-12 w-20 object-cover rounded-lg shadow-sm border border-gray-200"
                                                alt="cover" src="{{ asset('files/news/' . $item->cover) }}">
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if ($item->is_published == '1')
                                            <span
                                                class="inline-flex px-3 py-1 text-[10px] uppercase tracking-wider font-bold text-white bg-[var(--success)] rounded-full shadow-sm">
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex px-3 py-1 text-[10px] uppercase tracking-wider font-bold text-white bg-[var(--danger)] rounded-full shadow-sm">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-col items-center justify-center">
                                            @if ($deleteId != $item->id)
                                                <div class="flex flex-row gap-1 justify-center">
                                                    <a href="{{ route('manajemen-berita-edit', $item->id) }}"
                                                        class="w-auto">
                                                        <x-button bg="[var(--warning)]" px="1.5" py="1.5"
                                                            label='<i class="fa-solid fa-pen"></i>' />
                                                    </a>
                                                    <x-button wire:click="$set('deleteId', {{ $item->id }})"
                                                        bg="[var(--danger)]" px="1.5" py="1.5"
                                                        label='<i class="fa-solid fa-trash"></i>' />
                                                </div>
                                            @else
                                                <p class="text-center">Apa anda yakin?</p>
                                                <div class="flex flex-row gap-1 justify-center mb-1">
                                                    <x-button wire:click="$set('deleteId', null)" bg="[var(--success)]"
                                                        px="1.5" py="1.5"
                                                        label='<i class="fa-solid fa-x"></i>' />
                                                    <x-button wire:click="delete({{ $item->id }})"
                                                        bg="[var(--danger)]" px="1.5" py="1.5"
                                                        label='<i class="fa-solid fa-check"></i>' />

                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center py-10 text-gray-400 italic" colspan="5">
                                        <div class="flex flex-col items-center">
                                            <i class="fa-regular fa-folder-open text-3xl mb-2"></i>
                                            <span>Data Berita Tidak Ditemukan</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 px-2">
                    {{ $data->links('vendor.livewire.tailwind') }}
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                function closeAlert(id) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.style.transition = "opacity 0.3s";
                        el.style.opacity = "0";
                        setTimeout(() => el.remove(), 300);
                    }
                }
            </script>
        @endpush
    </div>

