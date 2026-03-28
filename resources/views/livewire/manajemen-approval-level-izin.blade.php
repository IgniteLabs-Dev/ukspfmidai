<div class="w-full">
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-xl sm:text-3xl font-bold text-center text-gray-800">Manajemen Langkah Approval Izin</h2>
    </div>

    <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
        {{-- List Steps --}}
        <div class="w-full lg:flex-1">
            <ol class="flex flex-col md:grid md:grid-flow-col md:auto-cols-fr overflow-hidden rounded-lg text-sm text-gray-600 border border-gray-200 shadow-sm">

                @forelse ($data as $item)
                    <li class="relative flex flex-col justify-center p-4 odd:bg-gray-50 even:bg-gray-100 border-b md:border-b-0 last:border-b-0">

                        {{-- Panah Dekoratif: Hanya muncul di Desktop (md ke atas) --}}
                        @if (!$loop->first)
                            <span class="absolute top-1/2 -left-2 hidden md:block size-4 -translate-y-1/2 rotate-45 border border-gray-100 z-10
                                border-s-0 border-t-0 {{ $loop->even ? 'bg-gray-50' : 'bg-gray-100' }}">
                            </span>
                        @endif

                        @if (!$loop->last)
                            <span class="absolute top-1/2 -right-2 hidden md:block size-4 -translate-y-1/2 rotate-45 border border-gray-100 z-10
                                border-e-0 border-b-0 {{ $loop->odd ? 'bg-gray-50' : 'bg-gray-100' }}">
                            </span>
                        @endif

                        {{-- Isi Item --}}
                        @if ($editId !== $item->id)
                            <div class="flex items-center justify-between w-full gap-3">
                                <div class="flex items-center min-w-0">
                                    <span class="flex items-center justify-center w-6 h-6 me-2 text-xs font-bold border-2 border-gray-400 rounded-full shrink-0">
                                        {{ $loop->index + 1 }}
                                    </span>
                                    <h3 class="font-semibold text-base sm:text-lg truncate">{{ $item->jabatan->name }}</h3>
                                </div>

                                <div class="flex gap-1 shrink-0">
                                    @if ($deleteId != $item->id)
                                        <x-button wire:click="edit({{ $item->id }})" bg="[var(--warning)]" px="1.5" py="1" label='<i class="fa-solid fa-xs fa-pen"></i>' />
                                        <x-button wire:click="$set('deleteId', {{ $item->id }})" bg="[var(--danger)]" px="1.5" py="1" label='<i class="fa-solid fa-xs fa-trash"></i>' />
                                    @else
                                        <div class="flex flex-col items-center bg-white p-1 rounded shadow-sm border border-red-200">
                                            <span class="text-[10px] font-bold text-red-600 mb-1">Yakin?</span>
                                            <div class="flex gap-1">
                                                <x-button wire:click="$set('deleteId', null)" bg="gray-500" px="1.5" py="1" label='<i class="fa-solid fa-x fa-xs"></i>' />
                                                <x-button wire:click="delete({{ $item->id }})" bg="[var(--danger)]" px="1.5" py="1" label='<i class="fa-solid fa-check fa-xs"></i>' />
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            {{-- Mode Edit --}}
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                <div class="flex-1">
                                    <x-select label="" placeholder="Pilih Jabatan" for="jabatan_id" wire="jabatan_id" :options="$jabatanTypes" :required="true" />
                                </div>
                                <div class="flex justify-end gap-1">
                                    <x-button wire:click="update({{ $item->id }})" bg="[var(--success)]" px="1.5" py="1" label='<i class="fa-solid fa-check"></i>' />
                                    <x-button wire:click="resetInput({{ $item->id }})" bg="[var(--danger)]" px="1.5" py="1" label='<i class="fa-solid fa-x"></i>' />
                                </div>
                            </div>
                        @endif
                    </li>
                @empty
                    <li class="p-8 text-center text-gray-400 italic bg-gray-50 w-full">Belum ada langkah approval izin.</li>
                @endforelse

                {{-- Mode Create --}}
                @if ($mode == 'create')
                    <li class="p-4 bg-emerald-50 border-2 border-dashed border-emerald-200">
                        <div class="flex flex-col sm:flex-row items-center gap-2">
                            <div class="w-full">
                                <x-select label="" placeholder="Pilih Jabatan Baru" for="jabatan_id" wire="jabatan_id" :options="$jabatanTypes" :required="true" />
                            </div>
                            <div class="flex gap-1 shrink-0">
                                <x-button wire:click="create" bg="[var(--success)]" px="1" py="1" label='<i class="fa-solid fa-check"></i>' />
                                <x-button wire:click="resetInput" bg="[var(--danger)]" px="1" py="1`" label='<i class="fa-solid fa-x"></i>' />
                            </div>
                        </div>
                    </li>
                @endif
            </ol>
        </div>

        {{-- Tombol Tambah --}}
        @if ($mode == 'view')
            <div class="shrink-0 self-center lg:self-auto">
                <x-button wire:click="toggleMode" bg="[var(--success)]" px="1.5" py="1"
                          label='<i class="fa-solid fa-plus"></i> <span class="lg:hidden ms-2">Tambah</span>' />
            </div>
        @endif
    </div>
</div>
