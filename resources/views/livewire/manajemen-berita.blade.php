<div class="bg-white rounded-xl p-4">

        <div class="w-full">
            <h2 class="text-3xl font-bold text-center">Manajemen Berita</h2>
        </div>
        <div class="w-full">
            <div class="w-full flex items-end gap-2 mt-4">
                <div class="flex-1">

                    <div class="relative">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input wire:model.live="filter" type="text" placeholder="Cari Berita"
                               class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2" />
                    </div>
                </div>

                <a href="{{ route('manajemen-berita-create') }}">
                    <x-button  label="Tambah Berita" class="whitespace-nowrap" />
                </a>
            </div>


            <div class="w-full mt-3 py-2">
                <div class="relative overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Judul</th>
                            <th scope="col" class="px-6 py-3 ">Cover</th>
                            <th scope="col" class="px-6 py-3 ">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($data as $item)
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="px-6 py-4">{{ $data->firstItem() + $loop->index }}</td>
                                <td class="px-6 py-4">{{ $item->title }}</td>
                                <td class="px-6 py-4"><img class="h-15 rounded-md" alt="cover" src="{{ asset('files/news/'.  $item->cover) }}"> </td>
                                <td class="px-6 py-4 justify-center ">
                                    @if ($item->is_published == '1')
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-white bg-[var(--success)] rounded-full">
                                                Aktif
                                            </span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold text-white bg-[var(--danger)] rounded-full">
                                                Tidak Aktif
                                            </span>
                                    @endif
                                </td>
                                <div wire:ignore>


                                </div>
                                <td class="text-center justify-center">
                                    @if ($deleteId != $item->id)
                                        <div class="flex flex-row gap-1 justify-center">
                                            <a href="{{ route('manajemen-berita-edit', $item->id) }}" class="w-auto">
                                            <x-button  bg="[var(--warning)]"
                                                      px="1.5" py="1.5"
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
                                            <x-button wire:click="delete({{ $item->id }})" bg="[var(--danger)]"
                                                      px="1.5" py="1.5"
                                                      label='<i class="fa-solid fa-check"></i>' />

                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center py-3" colspan="4">Data Tidak Ada</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $data->links('vendor.livewire.tailwind') }}
                </div>
            </div>

        </div>
</div>
