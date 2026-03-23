<div>
    <div class="w-full">
        <h2 class="text-3xl font-bold text-center mb-4">Manajemen Langkah Approval Izin</h2>
    </div>
    <div class="relative flex items-center space-x-4">
        <div class="items-center flex flex-wrap">
            <ol
                class="grid grid-flow-col auto-cols-fr overflow-hidden rounded-lg text-sm text-gray-600 me-3
        {{ count($data) > 1 ? 'divide-x divide-gray-100 border border-gray-100' : 'border-0 divide-x-0' }}">

                @forelse ($data as $item)
                    <li class="relative  justify-center gap-2 p-4 odd:bg-gray-100 even:bg-gray-200">

                        {{-- Panah kiri (bukan item pertama) → ikut warna sebelumnya --}}
                        @if (!$loop->first)
                            <span
                                class="absolute top-1/2 -left-2 hidden size-4 -translate-y-1/2 rotate-45 border border-gray-100 sm:block
                        border-s-0 border-t-0
                        {{ $loop->even ? 'bg-gray-100' : 'bg-gray-200' }}">
                            </span>
                        @endif

                        {{-- Panah kanan (bukan item terakhir) → ikut warna sekarang --}}
                        @if (!$loop->last)
                            <span
                                class="absolute top-1/2 -right-2 hidden size-4 -translate-y-1/2 rotate-45 border border-gray-100 sm:block
                        border-e-0 border-b-0
                        {{ $loop->odd ? 'bg-gray-100' : 'bg-gray-200' }}">
                            </span>
                        @endif

                        {{-- Isi utama item --}}
                        @if ($editId !== $item->id)
                            <div class="flex items-center justify-between w-full">
                                <div class="flex items-center me-2">
                                    <span
                                        class="flex items-center justify-center w-5 h-5 me-2 text-xs font-bold border-2 rounded-full shrink-0">
                                        {{ $loop->index + 1 }}
                                    </span>
                                    <h3 class="font-semibold text-lg">{{ $item->jabatan->name }}</h3>
                                </div>

                                <div class="flex gap-1 ">
                                    @if ($deleteId != $item->id)
                                        <x-button wire:click="edit({{ $item->id }})" bg="[var(--warning)]"
                                            px="1" py="0.5"
                                            label='<i class="fa-solid fa-xs fa-pen"></i>' />
                                        <x-button wire:click="$set('deleteId', {{ $item->id }})"
                                            bg="[var(--danger)]" px="1" py="0.5"
                                            label='<i class="fa-solid fa-xs fa-trash"></i>' />
                                    @else
                                        <div class="flex-col">
                                            <p class="text-center">Apa anda yakin?</p>
                                            <div class="flex flex-row gap-1 justify-center mb-1">
                                                <x-button wire:click="$set('deleteId', null)" bg="[var(--success)]"
                                                    px="0.5" py="0.5"
                                                    label='<i class="fa-solid fa-x"></i>' />
                                                <x-button wire:click="delete({{ $item->id }})" bg="[var(--danger)]"
                                                    px="0.5" py="0.5"
                                                    label='<i class="fa-solid fa-check"></i>' />
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            {{-- Mode edit --}}
                            <div class="flex-col items-center gap-2">
                                <div class="">
                                    <x-select label="Pilih Jabatan" for="jabatan_id" wire="jabatan_id" :options="$jabatanTypes"
                                        :required="true" />
                                </div>
                                <div class="div">
                                    <x-select label="Tanda Tangan" for="is_sign" wire="is_sign" :options="[
                                        'true' => 'Ya',
                                        'false' => 'Tidak',
                                    ]"
                                        :required="true" />
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <x-button wire:click="resetInput({{ $item->id }})" bg="[var(--danger)]"
                                        px="1.5" py="1" label='<i class="fa-solid fa-sm fa-x"></i>' />
                                    <x-button wire:click="update({{ $item->id }})" bg="[var(--success)]"
                                        px="1.5" py="1" label='<i class="fa-solid fa-sm fa-check"></i>' />
                                </div>
                            </div>
                        @endif

                    </li>

                @empty

                @endforelse
                @if ($mode == 'create')
                    <div class="px-3 w-auto items-center justify-between">
                        <div class="flex-col items-center gap-2">
                            <div class="">
                                <x-select label="Pilih Jabatan" for="jabatan_id" wire="jabatan_id" :options="$jabatanTypes"
                                    :required="true" />
                            </div>
                            <div class="div">
                                <x-select label="Tanda Tangan" for="is_sign" wire="is_sign" :options="[
                                    'true' => 'Ya',
                                    'false' => 'Tidak',
                                ]"
                                    :required="true" />
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                  <x-button wire:click="resetInput" bg="[var(--danger)]" px="1" py="1"
                                label='<i class="fa-solid  fa-x"></i>' />
                            <x-button wire:click="create" bg="[var(--success)]" px="1" py="1"
                                label='<i class="fa-solid  fa-check"></i>' />
                            </div>
                        </div>
                    </div>
                @endif
            </ol>
            @if ($mode == 'view')
                {{-- Tombol tambah --}}
                <div class="">
                    <x-button wire:click="toggleMode" bg="[var(--success)]" px="1" py="1"
                        label='<i class="fa-solid fa-lg fa-plus"></i>' />
                </div>
            @endif
        </div>




    </div>
</div>
