<div class="bg-white rounded-xl p-4">
    @if ($mode == 'view')

        <div class="w-full">
            <h2 class="text-3xl font-bold text-center">Manajemen Berita</h2>
        </div>
        <div class="w-full">
            <div class="w-full flex items-end gap-2 mt-4">
                <div class="flex-1">

                    <div class="relative">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input wire:model.live="filter" type="text" placeholder="Masukkan Berita"
                               class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2" />
                    </div>
                </div>

                <div>
                    <x-button wire:click="toggleMode" label="Tambah Berita" class="whitespace-nowrap" />
                </div>
            </div>


            <div class="w-full mt-3 py-2">
                <div class="relative overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Berita</th>
                            <th scope="col" class="px-6 py-3 ">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($data as $item)
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="px-6 py-4">{{ $data->firstItem() + $loop->index }}</td>
                                <td class="px-6 py-4">{{ $item->tahun }}</td>
                                <td class="px-6 py-4 justify-center ">
                                    @if ($item->status == 'active')
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
                                    <label class="block mb-2 text-sm font-medium text-gray-900">
                                        Konten <span class="text-red-500">*</span>
                                    </label>

                                    <div id="editor"
                                         style="height: 300px; background-color: white; border: 1px solid #d1d5db; border-radius: 0.5rem;">
                                    </div>
                                </div>
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
                <h2 class="text-2xl font-bold text-center">Tambah Berita Baru</h2>
            @else
                <h2 class="text-2xl font-bold text-center">Edit Data {{ $tahun }}</h2>
            @endif
        </div>
        <div class="w-full mt-4">
            <div class="flex flex-col gap-4">
                <x-input label="Judul" for="title" wire="title" type="text" placeholder="judul"
                         :required="true" />
                <x-select label="Aktif" for="is_published" wire="is_published" :options="[
                    '0' => 'Aktif',
                    '1' => 'Tidak Aktif',
                ]" :required="true" />
                <div class="mb-3">
                    <label for="cover" class="block mb-1 text-sm font-medium text-gray-900">Cover
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="file" id="cover" wire:model="cover" accept=".jpg,.png,.jpeg" class="bg-gray-50 w-full rounded-md file:bg-gray-400 file:text-white border-1 border-gray-200 cursor-pointer" />
                    <p class="mt-1 text-xs text-gray-500">Format yang diterima: <span class="font-medium">JPG, JPEG, PNG</span> &bull; Maksimal <span class="font-medium">10 MB</span></p>
                    @error('cover') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-2 flex justify-center items-end gap-2">
                    <x-button wire:click="resetInput" bg="[var(--danger)]" label="Batal" />
                    @if ($editId)
                        <x-button wire:click="update" bg="[var(--success)]" label="Simpan Perubahan" />
                    @else
                        <x-button wire:click="create" bg="[var(--success)]" label="Simpan Berita" />
                    @endif
                </div>


            </div>

            @endif
        </div>



        @push('scripts')
            <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

            <script>
                let quill;

                function initQuill() {
                    const el = document.getElementById('editor');
                    if (!el) return;

                    // destroy isi lama biar bersih
                    el.innerHTML = '';

                    quill = new Quill(el, {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{ header: [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['link', 'image']
                            ]
                        }
                    });

                    // 🔥 ambil dari cache (biar ga ilang)
                    if (window.quillContent) {
                        quill.root.innerHTML = window.quillContent;
                    }

                    quill.on('text-change', () => {
                        let html = quill.root.innerHTML;

                        // simpan ke global
                        window.quillContent = html;

                        // kirim ke Livewire
                        Livewire.dispatch('setContent', { value: html });
                    });
                }

                // pertama kali load
                document.addEventListener('DOMContentLoaded', initQuill);

                // tiap Livewire update (INI KUNCI)
                document.addEventListener('livewire:commit', () => {
                    setTimeout(() => {
                        initQuill();
                    }, 50);
                });
            </script>
        @endpush

</div>
