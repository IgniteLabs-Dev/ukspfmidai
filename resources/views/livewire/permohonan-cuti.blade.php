<div class="bg-white rounded-xl p-4 shadow-sm">
    <h2 class="text-2xl mb-5 font-bold text-center">
        Permohonan Cuti
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
                    'waiting' => 'Menunggu',
                    'success' => 'Diterima',
                ]" />
        </div>
        <div class="flex-1">
            <x-input label="Pencarian" for="filter" wire="filter" wireType="live" type="text"
                placeholder="Masukkan Nama atau Alasan" />
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                        Cuti</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Alasan</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Proses</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dokumen</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($data as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $data->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->cuti->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->cuti->cutiType->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($item->cuti->tanggal_start)->locale('id')->translatedFormat('d F Y') }} 🠖
                            {{ \Carbon\Carbon::parse($item->cuti->tanggal_end)->locale('id')->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $item->cuti->alasan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 flex justify-center ">
                            <span
                                class="px-3 py-1 rounded-full text-white text-center text-xs my-1 font-semibold
                                    @if ($item->status === 'success') bg-[var(--success)]
                                    @elseif ($item->status === 'failed') bg-[var(--danger)]
                                    @else bg-[var(--warning)] @endif">
                                @if ($item->status === 'success')
                                    Diterima
                                @elseif ($item->status === 'failed')
                                    Ditolak
                                @elseif($item->status === 'waiting')
                                    Menunggu Persetujuan Anda
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900  text-center  ">
                            <button wire:click="viewFlow({{ $item->cuti->id }})" type="button"
                                data-modal-target="default-modal" data-modal-toggle="default-modal"
                                class="text-white cursor-pointer bg-[var(--info)] hover:brightness-90 hover:cursor-pointer font-medium rounded-lg text-sm px-1.5 py-1.5 me-2 "><i
                                    class="fa-solid fa-sitemap"></i></button>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900   ">
                            <div class="flex justify-center gap-1">
                            <button @click="$dispatch('open-pdf', { url: '{{ asset('files/cuti/'. $item->cuti->doc) }}' })"
                                    class="bg-[var(--primary)] text-white px-1 py-1 rounded-md cursor-pointer hover:scale-105">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <a href="{{ asset('files/cuti/'. $item->cuti->doc) }}" download
                               class="bg-[var(--warning)] text-white px-1 py-1 rounded-md cursor-pointer hover:scale-105 inline-flex items-center">
                                <i class="fa-solid fa-download"></i>
                            </a>
                            </div>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900   ">
                            <div class="flex justify-center gap-1">
                                @if ($item->status === 'waiting')
                                    <input type="hidden" wire:model="alasanDitolak" id="alasanDitolakField" />


                                    <div wire:loading.remove class="flex gap-1">
                                        <x-button
                                            wire:anow-confirm.reject="Apakah anda yakin ingin menolak?"
                                            wire:click="reject({{ $item->cuti->id }})"
                                            bg="[var(--danger)]"
                                            px="1"
                                            py="1"
                                            label='<i class="fa-solid fa-circle-xmark"></i>'
                                        />

                                        <x-button
                                            wire:anow-confirm="Apakah anda yakin?"
                                            wire:click="approve({{ $item->cuti->id }})"
                                            bg="[var(--success)]"
                                            px="1"
                                            py="1"
                                            label='<i class="fa-solid fa-circle-check"></i>'
                                        />
                                    </div>
                                    <div wire:loading>
                                        <span class="text-sm text-gray-500 animate-pulse">Memproses...</span>
                                    </div>
                                @else
                                    <x-button wire:anow-confirm="Apakah anda yakin?" wire:click="backToWaiting({{ $item->cuti->id }})" bg="[var(--warning)]"
                                              px="1" py="1" label='<i class="fa-solid fa-clock"></i>' />
                                @endif
                            </div>
                         </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500 bg-gray-50">
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
                        class="text-gray-700 cursor-pointer bg-gray-300 hover:cursor-pointer  hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                        data-modal-hide="default-modal">
                        <i class="fa-solid fa-xmark fa-xl"></i>
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
                                    <div class="flex-1 ">
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
                                        {{-- Label di bawah icon --}}
                                        <div class="text-xs text-center md:text-base">
                                            <div class="flex flex-col items-center justify-center">
                                                <div>
                                                    {{ $item->approvalLevel->jabatan->name ?? '' }}

                                                </div>
                                                <div class="text-gray-500 text-[10px] md:text-xs mt-0">
                                                    @if ($item->updated_at && $item->updated_at != $item->created_at)
                                                        {{ $item->updated_at->locale('id')->translatedFormat('d M Y H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                                <div class="div">
                                                    @if ($item->approvalLevel->jabatan->id == $user->jabatan_id)
                                                        <span
                                                            class="px-1 py-0.5 ms-1 text-[10px] leading-none rounded-full text-white font-medium bg-[var(--warning)]">
                                                            Anda
                                                        </span>
                                                    @endif
                                                </div>
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
    </div>


    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.directive('anow-confirm', ({
                                                        el
                                                        , directive
                                                    }) => {
                    let message = directive.expression.replaceAll('\\n', '\n') || "{{ __('Are you sure?') }}";
                    let isReject = directive.modifiers.includes('reject');

                    el.__livewire_confirm = (action, instead) => {
                        const createModal = (content) => {
                            const backdrop = document.createElement('div');
                            backdrop.className = 'fixed inset-0 bg-black/20 z-40';

                            const modal = document.createElement('div');
                            modal.className = 'fixed inset-0 flex items-center justify-center z-50';
                            modal.innerHTML = content;

                            document.body.appendChild(backdrop);
                            document.body.appendChild(modal);
                            return { modal, backdrop };
                        };

                        const removeModal = (backdrop, modal) => {
                            backdrop.style.opacity = '0';
                            modal.style.opacity = '0';
                            modal.style.transform = 'scale(0.95)';
                            setTimeout(() => {
                                document.body.removeChild(backdrop);
                                document.body.removeChild(modal);
                            }, 150);
                        };

                        const btnBg = el.style.backgroundColor || getComputedStyle(el).backgroundColor || '#3b82f6';

                        const rejectExtra = isReject ? `
                        <div style="margin-bottom:1.25rem;">
                            <label style="display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.375rem;">
                                Alasan ditolak <span style="color:${btnBg}">*</span>
                            </label>
                            <textarea id="alasanInput" rows="3" placeholder="Masukkan alasan penolakan..." style="
                                width: 100%;
                                border-radius: 0.5rem;
                                border: 1px solid #e5e7eb;
                                padding: 0.5rem 0.75rem;
                                font-size: 0.875rem;
                                color: #111827;
                                background: #f3f4f6;
                                resize: none;
                                outline: none;
                                box-sizing: border-box;
                                transition: border 0.15s;
                            " onfocus="this.style.borderColor='${btnBg}'" onblur="this.style.borderColor='#e5e7eb'"></textarea>
                            <p id="alasanError" style="display:none; margin:0.25rem 0 0; font-size:0.75rem; color:${btnBg};">
                                Alasan wajib diisi.
                            </p>
                        </div>
                    ` : '';

                        const modalContent = `
                        <div style="
                            background: white;
                            border-radius: 1rem;
                            box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 4px 16px rgba(0,0,0,0.08);
                            padding: 1.75rem;
                            width: 100%;
                            max-width: 420px;
                            transition: all 0.15s ease;
                        ">
                            <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1.25rem;">
                                <div style="
                                    width: 40px; height: 40px;
                                    border-radius: 20%;
                                    background: #eaeaea;
                                    display: flex; align-items: center; justify-content: center;
                                    flex-shrink: 0;
                                ">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="${btnBg}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                        <line x1="12" y1="9" x2="12" y2="13"/>
                                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                                    </svg>
                                </div>
                                <div>
                                    <p style="margin:0; font-size:1rem; font-weight:600; color:#111827;">Konfirmasi</p>
                                    <p style="margin:0; font-size:0.875rem; color:#6b7280;">${message}</p>
                                </div>
                            </div>
                            ${rejectExtra}
                            <div style="display:flex; justify-content:center; gap:0.5rem;">
                                <button id="cancelButton" style="
                                    padding: 0.5rem 1.25rem;
                                    border-radius: 0.5rem;
                                    border: 1px solid #e5e7eb;
                                    background: #e5e7eb;
                                    color: #374151;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    cursor: pointer;
                                    transition: background 0.15s;
                                " onmouseover="this.style.background='#d1d5db'" onmouseout="this.style.background='#e5e7eb'">
                                    Batal
                                </button>
                                <button id="confirmButton" style="
                                    padding: 0.5rem 1.25rem;
                                    border-radius: 0.5rem;
                                    border: none;
                                    background: ${btnBg};
                                    color: white;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    cursor: pointer;
                                    transition: opacity 0.15s;
                                " onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                    Ya, Lanjutkan
                                </button>
                            </div>
                        </div>`;

                        const { modal, backdrop } = createModal(modalContent);

                        const box = modal.querySelector('div');
                        box.style.opacity = '0';
                        box.style.transform = 'scale(0.95)';
                        requestAnimationFrame(() => {
                            box.style.transition = 'all 0.15s ease';
                            box.style.opacity = '1';
                            box.style.transform = 'scale(1)';
                        });

                        modal.querySelector('#confirmButton').addEventListener('click', () => {
                            if (isReject) {
                                const alasan = modal.querySelector('#alasanInput').value.trim();
                                const errorEl = modal.querySelector('#alasanError');
                                if (!alasan) {
                                    errorEl.style.display = 'block';
                                    modal.querySelector('#alasanInput').style.borderColor = btnBg;
                                    return;
                                }
                                // Set ke hidden input lalu trigger sync ke Livewire
                                const field = document.getElementById('alasanDitolakField');
                                field.value = alasan;
                                field.dispatchEvent(new Event('input'));
                            }
                            action();
                            removeModal(backdrop, modal);
                        });

                        modal.querySelector('#cancelButton').addEventListener('click', () => {
                            instead();
                            removeModal(backdrop, modal);
                        });

                        backdrop.addEventListener('click', () => {
                            instead();
                            removeModal(backdrop, modal);
                        });
                    };
                });
            });
        </script>
    @endpush
</div>
