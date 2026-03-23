<div class="bg-white rounded-xl p-4">
    @if ($mode == 'view')

        <div class="w-full">
            <h2 class="text-3xl font-bold text-center">Manajemen Role</h2>
        </div>
        <div class="w-full">
            <div class="w-full flex items-end gap-2 mt-4">
                <div class="flex-1">

                    <div class="relative">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input wire:model.live="filter" type="text" placeholder="Masukkan Keterangan Role"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2" />
                    </div>
                </div>

                <div>
                    <x-button wire:click="toggleMode" label="Tambah Role" class="whitespace-nowrap" />
                </div>
            </div>


            <div class="w-full mt-3 py-2">
                <div class="relative overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Nama Role</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr class="odd:bg-white even:bg-gray-50">
                                    <td class="px-6 py-4">{{ $data->firstItem() + $loop->index }}</td>
                                    <td class="px-6 py-4">{{ $item->name }}</td>
                                    <td class="text-center justify-center">
                                        @if ($deleteId != $item->id)
                                            <div class="flex flex-row gap-1 justify-center">
                                                <x-button wire:click="edit({{ $item->id }})" bg="[var(--warning)]"
                                                    px="1.5" py="1.5"
                                                    label='<i class="fa-solid fa-pen"></i>' />
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
                                    <td class="text-center py-3" colspan="6">Data Tidak Ada</td>
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
    @elseif($mode == 'edit')
        <div class="w-full">
            @if ($editId == null)
                <h2 class="text-2xl font-bold text-center">Tambah Role Baru</h2>
            @else
                <h2 class="text-2xl font-bold text-center">Edit Data {{ $name }}</h2>
            @endif
        </div>
        <div class="w-full mt-4">
            <div class="grid grid-cols-2 gap-4">
                <x-input label="Name" for="name" wire="name" type="text" placeholder="Name"
                    :required="true" />
                <div class="col-span-2 flex justify-center items-end gap-2">
                    <x-button wire:click="resetInput" bg="[var(--danger)]" label="Batal" />
                    @if ($editId)
                        <x-button wire:click="update" bg="[var(--success)]" label="Simpan Perubahan" />
                    @else
                        <x-button wire:click="create" bg="[var(--success)]" label="Simpan Role" />
                    @endif

                </div>

            </div>

    @endif
</div>
