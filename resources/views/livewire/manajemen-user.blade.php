<div class="bg-white rounded-xl p-4">
    @if ($mode == 'view')

        <div class="w-full">
            <h2 class="text-2xl font-bold text-center">Manajemen User</h2>
        </div>
        <div class="w-full">
            <div class="w-full flex items-end gap-2 mt-4">
                <div class="flex-1">
                    <label for="user" class="block mb-2 text-sm font-medium text-gray-900">
                        Cari User
                    </label>
                    <div class="relative">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input wire:model.live="filter" type="text" placeholder="Masukkan Nama, NIP atau Nomor WA"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2" />
                    </div>
                </div>

                <div>
                    <x-button wire:click="toggleMode" label="Tambah User" class="whitespace-nowrap" />
                </div>
            </div>


            <div class="w-full mt-3 py-2">
                <div class="relative overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">NIP</th>
                                <th scope="col" class="px-6 py-3">Role</th>
                                <th scope="col" class="px-6 py-3">Jabatan</th>
                                <th scope="col" class="px-6 py-3">Pangkat</th>
                                <th scope="col" class="px-6 py-3">Nomor WA</th>
                                <th scope="col" class="px-6 py-3 text-center">Setting Cuti</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr class="odd:bg-white even:bg-gray-50">
                                    <td class="px-6 py-4">{{ $item->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $item->nip ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $item->role ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $item->jabatan->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $item->pangkatRef->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $item->nomor_wa ?? '-' }}</td>
                                    <td class="text-center justify-center">
                                        <a href="{{ route('manajemen-cuti-user', ['id' => $item->id]) }}">
                                            <button type="button"
                                                class="text-white bg-[var(--info)] hover:brightness-90 font-medium rounded-lg text-sm w-full sm:w-auto px-1.5 py-1.5 text-center hover:cursor-pointer hover:scale-102 transition-transform duration-200">
                                                <i class="fa-solid fa-list-check"></i>
                                            </button>
                                        </a>
                                    </td>
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
                <h2 class="text-2xl font-bold text-center">Tambah User Baru</h2>
            @else
                <h2 class="text-2xl font-bold text-center">Edit Data {{ $name }}</h2>
            @endif
        </div>
        <div class="w-full mt-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input label="Nama" for="name" wire="name" type="text" placeholder="Deskripsi"
                        :required="true" />
                </div>

                <div>
                    <x-input label="NIP" for="nip" wire="nip" type="text" placeholder="Deskripsi"
                        :required="true" />
                </div>

                <div>
                    <x-select label="Role" for="role" wire="role" wireType="change" placeholder="Semua role"
                        :options="[
                            'USER' => 'User',
                            'ADMIN' => 'Admin',
                            'SUPERADMIN' => 'Superadmin',
                        ]" :required="true" />
                </div>

                <div>
                    <x-select label="Semua Jabatan" for="jabatan_id" wire="jabatan_id" wireType="change"
                        placeholder="Semua Jabatan" :options="$jabatanData" :required="true" />
                </div>
                <div>
                    <x-select label="Semua Pangkat" for="pangkat_id" wire="pangkat_id" wireType="change"
                        placeholder="Semua Pangkat" :options="$pangkatData" :required="true" />
                </div>

                <div>
                    <x-input label="Nomor WA" for="nomor_wa" wire="nomor_wa" type="text"
                        placeholder="Nomor WA" />
                </div>

                <div>
                    <x-input label="Password" for="password" wire="password" type="text" placeholder="Password"
                        type="password" />
                </div>

                <div class="col-span-2 flex justify-center items-end gap-2">
                    <x-button wire:click="resetInput" bg="[var(--danger)]" label="Batal" />
                    @if ($editId)
                        <x-button wire:click="update" bg="[var(--success)]" label="Simpan Perubahan" />
                    @else
                        <x-button wire:click="create" bg="[var(--success)]" label="Simpan User" />
                    @endif

                </div>

            </div>

    @endif
</div>
