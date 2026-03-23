<div>
    <div>

        <div class="bg-white rounded-xl p-4">
            <div class="p-4">
                @if ($mode == 'view')
                    <div class="flex justify-between">
                        <a href="{{ route('manajemen-user') }}">
                            <button
                                class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-[var(--primary)] text-white p-0 m-0">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                        </a>
                        <h2 class="p-0 m-0 text-center text-2xl font-bold">Manajemen Cuti {{ $user->name }}</h2>
                        <button wire:click="$set('mode', 'add')"
                            class="px-3 py-1 rounded-md bg-[var(--primary)] hover:cursor-pointer text-white">Tambah
                            Cuti</button>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mt-3">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-2">
                                <div class="w-auto flex items-center">
                                    <h4 class="m-0 text-xl font-bold">Daftar Cuti</h4>
                                </div>

                                <div class="w-75 flex  space-x-2">
                                    <div class="w-full">
                                        <x-select label="" for="cutiTypeFilter" wire="cutiTypeFilter"
                                            wireType="change" placeholder="Semua Cuti" :options="$cutiTypes" />
                                    </div>

                                    <div class="w-full">
                                        <x-select label="" for="tahunFilter" wire="tahunFilter" wireType="change"
                                            placeholder="Semua Tahun" :options="$tahunData" />
                                    </div>
                                </div>

                            </div>
                            <div class="w-full mt-3 py-2">
                                <div class="relative overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">No</th>
                                                <th scope="col" class="px-6 py-3">Tahun</th>
                                                <th scope="col" class="px-6 py-3">Jenis Cuti</th>
                                                <th scope="col" class="px-6 py-3">Kuota Cuti</th>
                                                <th scope="col" class="px-6 py-3">Cuti Digunakan</th>
                                                <th scope="col" class="px-6 py-3 text-center">Sisa Cuti</th>
                                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($viewCutiKuotaReguler->data as $item)
                                                <tr class="odd:bg-white even:bg-gray-50">
                                                    <td class="px-6 py-4">
                                                        {{ $loop->iteration + ($viewCutiKuotaReguler->current_page - 1) * $viewCutiKuotaReguler->per_page }}
                                                    </td>
                                                    <td class="px-6 py-4">{{ $item->tahun }}</td>
                                                    <td class="px-6 py-4">{{ $item->cuti_type }}</td>
                                                    <td class="px-6 py-4">{{ $item->kuota }}</td>
                                                    <td class="px-6 py-4">{{ $item->total_dipakai }}</td>
                                                    <td class="px-6 py-4">{{ $item->sisa_kuota }}</td>

                                                    <td class="text-center justify-center">
                                                        @if ($confirmDeleteId != $item->id_cuti)
                                                            <div class="flex flex-row gap-1 justify-center">
                                                                <x-button wire:click="edit({{ $item->id_cuti }})"
                                                                    bg="[var(--warning)]" px="1.5" py="1.5"
                                                                    label='<i class="fa-solid fa-pen"></i>' />
                                                                <x-button
                                                                    wire:click="$set('deleteId', {{ $item->id_cuti }})"
                                                                    bg="[var(--danger)]" px="1.5" py="1.5"
                                                                    label='<i class="fa-solid fa-trash"></i>' />
                                                            </div>
                                                        @else
                                                            <p class="text-center">Apa anda yakin?</p>
                                                            <div class="flex flex-row gap-1 justify-center mb-1">
                                                                <x-button wire:click="$set('deleteId', null)"
                                                                    bg="[var(--success)]" px="1.5" py="1.5"
                                                                    label='<i class="fa-solid fa-x"></i>' />
                                                                <x-button wire:click="delete({{ $item->id_cuti }})"
                                                                    bg="[var(--danger)]" px="1.5" py="1.5"
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
                            </div>

                            @if ($this->viewCutiKuotaReguler->last_page > 1)
                                <div class="flex justify-center items-center mt-4">
                                    <div class="inline-flex rounded-md overflow-hidden border">
                                        <button wire:click="previousPageKuota"
                                            @if ($this->viewCutiKuotaReguler->current_page == 1) disabled @endif
                                            class="px-3 py-1 border-r text-sm {{ $this->viewCutiKuotaReguler->current_page == 1 ? 'text-gray-400' : 'text-gray-700' }}">
                                            &lt;
                                        </button>

                                        @for ($i = 1; $i <= $this->viewCutiKuotaReguler->last_page; $i++)
                                            <button wire:click="gotoPageKuota({{ $i }})"
                                                class="px-3 py-1 text-sm {{ $i == $this->viewCutiKuotaReguler->current_page ? 'bg-[var(--primary)] text-white' : 'text-gray-700' }}">
                                                {{ $i }}
                                            </button>
                                        @endfor

                                        <button wire:click="nextPageKuota"
                                            @if ($this->viewCutiKuotaReguler->current_page == $this->viewCutiKuotaReguler->last_page) disabled @endif
                                            class="px-3 py-1 border-l text-sm {{ $this->viewCutiKuotaReguler->current_page == $this->viewCutiKuotaReguler->last_page ? 'text-gray-400' : 'text-gray-700' }}">
                                            &gt;
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mt-6">
                        <div class="flex-1">
                            <h4 class="m-0 text-xl font-bold">Daftar Cuti Tahunan</h4>
                            <div class="w-full mt-3 py-2">
                                <div class="relative overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">No</th>
                                                <th scope="col" class="px-6 py-3">Tahun</th>
                                                <th scope="col" class="px-6 py-3">Kuota Cuti</th>
                                                <th scope="col" class="px-6 py-3">Cuti Digunakan</th>
                                                <th scope="col" class="px-6 py-3">Sisa Cuti</th>
                                                <th scope="col" class="px-6 py-3">Cuti Tersimpan</th>
                                                <th scope="col" class="px-6 py-3">Cuti Tersimpan Digunakan</th>
                                                <th scope="col" class="px-6 py-3">Sisa Cuti Tersimpan</th>
                                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($viewCutiKuotaTahunan->data as $item)
                                                <tr class="odd:bg-white even:bg-gray-50">
                                                    <td class="px-6 py-4">
                                                        {{ $loop->iteration + ($viewCutiKuotaTahunan->current_page - 1) * $viewCutiKuotaTahunan->per_page }}
                                                    </td>
                                                    <td class="px-6 py-4">{{ $item->tahun }}</td>
                                                    <td class="px-6 py-4">{{ $item->kuota }}</td>
                                                    <td class="px-6 py-4">{{ $item->total_dipakai }}</td>
                                                    <td class="px-6 py-4">{{ $item->sisa_kuota }}</td>
                                                    <td class="px-6 py-4">{{ $item->cuti_tersimpan }}</td>
                                                    <td class="px-6 py-4">{{ $item->cuti_tersimpan_digunakan }}</td>
                                                    <td class="px-6 py-4">{{ $item->sisa_cuti_tersimpan }}</td>

                                                    <td class="text-center justify-center">
                                                        @if ($confirmDeleteId != $item->id_cuti)
                                                            <div class="flex flex-row gap-1 justify-center">
                                                                <x-button wire:click="edit({{ $item->id_cuti }})"
                                                                    bg="[var(--warning)]" px="1.5"
                                                                    py="1.5"
                                                                    label='<i class="fa-solid fa-pen"></i>' />
                                                                <x-button
                                                                    wire:click="confirmDelete({{ $item->id_cuti }})"
                                                                    bg="[var(--danger)]" px="1.5"
                                                                    py="1.5"
                                                                    label='<i class="fa-solid fa-trash"></i>'
                                                                    :disabled="$item->total_dipakai != 0 ||
                                                                        $item->cuti_tersimpan_digunakan != 0" />

                                                            </div>
                                                        @else
                                                            <p class="text-center">Apa anda yakin?</p>
                                                            <div class="flex flex-row gap-1 justify-center mb-1">
                                                                <x-button wire:click="batalDelete"
                                                                    bg="[var(--success)]" px="1.5"
                                                                    py="1.5"
                                                                    label='<i class="fa-solid fa-x"></i>' />
                                                                <x-button wire:click="delete({{ $item->id_cuti }})"
                                                                    bg="[var(--danger)]" px="1.5"
                                                                    py="1.5"
                                                                    label='<i class="fa-solid fa-check"></i>' />

                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center py-3" colspan="9">Data Tidak Ada</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <small class="block mt-1 text-xs text-gray-600">Catatan : Kuota cuti yang digunakan adalah <b>Sisa
                            Cuti</b> untuk
                        tahun terbaru, dan <b>Sisa Cuti Tersimpan</b> untuk tahun-tahun sebelumnya.</small>

                    @if ($this->viewCutiKuotaTahunan->last_page > 1)
                        <div class="flex justify-center items-center mt-2">
                            <div class="inline-flex rounded-md overflow-hidden border">
                                <button wire:click="previousPageTahunan"
                                    @if ($this->viewCutiKuotaTahunan->current_page == 1) disabled @endif
                                    class="px-3 py-1 border-r text-sm">
                                    &lt;
                                </button>

                                @for ($i = 1; $i <= $this->viewCutiKuotaTahunan->last_page; $i++)
                                    <button wire:click="gotoPageTahunan({{ $i }})"
                                        class="px-3 py-1 text-sm {{ $i == $this->viewCutiKuotaTahunan->current_page ? 'bg-[var(--primary)] text-white' : 'text-gray-700' }}">
                                        {{ $i }}
                                    </button>
                                @endfor

                                <button wire:click="nextPageTahunan" @if ($this->viewCutiKuotaTahunan->current_page == $this->viewCutiKuotaTahunan->last_page) disabled @endif
                                    class="px-3 py-1 border-l text-sm">
                                    &gt;
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="w-full border border-gray-300 rounded-md p-3 mt-3">
                        <div class="flex justify-between items-center flex-wrap">
                            <h4 class="m-0 text-xl font-bold">Riwayat Cuti Tahunan</h4>

                            @if ($modeRiwayat != 'mapping')
                                <div class="w-full md:w-1/3 lg:w-1/6">
                                    <x-select label="" for="tahunRiwayat" wire="tahunRiwayat"
                                        wireType="change" placeholder="Semua Tahun" :options="$tahunData" />
                                </div>
                            @endif
                        </div>

                        @if ($modeRiwayat == 'view')
                            <div class="w-full mt-3 py-2">
                                <div class="relative overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">No</th>
                                                <th scope="col" class="px-6 py-3">Total Hari</th>
                                                <th scope="col" class="px-6 py-3">Kuota Yang Digunakan</th>
                                                <th scope="col" class="px-6 py-3">Tanggal</th>
                                                <th scope="col" class="px-6 py-3">Pengajuan</th>
                                                <th scope="col" class="px-6 py-3">Tanggal ACC</th>
                                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($riwayatCuti->data as $item)
                                                <tr class="odd:bg-white even:bg-gray-50">
                                                    <td class="px-6 py-4">
                                                        {{ $loop->iteration + ($riwayatCuti->current_page - 1) * $riwayatCuti->per_page }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $item->total_hari }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        @if (!empty($item->kuota_used_grouped))
                                                            @foreach (explode(',', $item->kuota_used_grouped) as $kuota_used_grouped)
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0 rounded-full text-xs font-medium bg-[var(--info)] text-white mr-0">{{ trim($kuota_used_grouped) }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        @if (!empty($item->tanggal))
                                                            @foreach (explode(',', $item->tanggal) as $tanggal)
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[var(--primary)] text-white mr-0">{{ trim($tanggal) }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ \Carbon\Carbon::parse($item->tanggal_acc)->locale('id')->isoFormat('D MMMM YYYY') }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <button wire:click="mappingKuotaUsed({{ $item->id }})"
                                                            class="text-white bg-[var(--info)] hover:brightness-90 font-medium rounded-lg text-sm w-full sm:w-auto px-1.5 py-1.5 text-center hover:cursor-pointer hover:scale-102 transition-transform duration-200"><i
                                                                class="fa-solid fa-gear"></i></button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center py-3" colspan="7">Data Tidak Ada</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if ($this->riwayatCuti->last_page > 1)
                                <div class="flex justify-center items-center mt-4">
                                    <div class="inline-flex rounded-md overflow-hidden border">
                                        <button wire:click="previousPageRiwayat"
                                            @if ($this->riwayatCuti->current_page == 1) disabled @endif
                                            class="px-3 py-1 border-r text-sm">
                                            &lt;
                                        </button>

                                        @for ($i = 1; $i <= $this->riwayatCuti->last_page; $i++)
                                            <button wire:click="gotoPageRiwayat({{ $i }})"
                                                class="px-3 py-1 text-sm {{ $i == $this->riwayatCuti->current_page ? 'bg-[var(--primary)] text-white' : 'text-gray-700' }}">
                                                {{ $i }}
                                            </button>
                                        @endfor

                                        <button wire:click="nextPageRiwayat"
                                            @if ($this->riwayatCuti->current_page == $this->riwayatCuti->last_page) disabled @endif
                                            class="px-3 py-1 border-l text-sm">
                                            &gt;
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="flex gap-4 mt-2">
                                <div class="w-1/2">
                                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-center">Tanggal</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($dataMapped as $index => $item)
                                                <tr class="odd:bg-white even:bg-gray-50 text-center">
                                                    <td class="px-6 py-4">{{ $item['tanggal'] ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center py-3" colspan="6">Data Tidak Ada</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="w-1/2">

                                    <table class="w-full text-sm text-left text-gray-700 overflow-hidden">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded-t-xl">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-center">Kuota Terpakai</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($dataMapped as $index => $item)
                                                <tr style="height:50px;">
                                                    <td class="p-2 text-center align-middle">
                                                        <select wire:model="dataMapped.{{ $index }}.kuota_used"
                                                            name="tahun"
                                                            class="block w-full rounded border px-2 py-1 text-sm">
                                                            <option value="" disabled>Pilih Tahun</option>
                                                            @forelse ($tahunDataMapped as $item)
                                                                <option value="{{ $item->tahun }}">
                                                                    {{ $item->tahun }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center py-3" colspan="1">Data Tidak Ada</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-3 text-center flex justify-center gap-2 flex-wrap">
                                <x-button wire:click="backView" bg="[var(--danger)]" label="Batal" />
                                <x-button wire:click="saveMappingKuota" bg="[var(--primary)]" label="Simpan" />
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex flex-wrap -mx-2">
                        <div class="w-full lg:w-1/2 px-2 mb-3">
                            <x-select label="Jenis Cuti" for="cuti_type_id" wire="cuti_type_id" wireType="change"
                                placeholder="Semua Cuti" :options="$cutiTypes" />
                        </div>

                        <div class="w-full lg:w-1/2 px-2 mb-3">
                            <x-select label="Tahun" for="tahun" wire="tahun" wireType="change"
                                placeholder="Semua Tahun" :options="$tahunData" />

                        </div>

                        <div class="w-full lg:w-1/2 px-2 mb-3">


                            <input wire:model.defer="kuota" type="number" placeholder="Kuota" required
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                        </div>

                        @if ($this->isCutiTahunan == 1)
                            <div class="w-full lg:w-1/2 px-2 mb-3">
                                <input wire:model.defer="cuti_tersimpan" type="number" placeholder="Cuti Tersimpan"
                                    required
                                    class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-center gap-2">
                        <x-button wire:click="resetInput" bg="[var(--danger)]" label="Batal" />

                        @if ($this->mode == 'add')
                            <x-button wire:click="store" bg="[var(--primary)]" label="Tambah Cuti" />
                        @else
                            <x-button wire:click="update" bg="[var(--primary)]" label="Perbarui Data" />
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
