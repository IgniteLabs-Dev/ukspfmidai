<div class="bg-white rounded-xl p-4">
    <h2 class="text-3xl mb-4 font-bold text-center ">
        Pengajuan Izin
    </h2>
    <div class="w-full">



        <!-- Jenis Izin -->
        <x-select label="Jenis Cuti" for="izin_type_id" wire="izin_type_id" :options="$izinTypes" :required="true" />

        <!-- Tanggal Izin -->
        <x-input label="Tanggal" for="tanggal" wire="tanggal" type="date" placeholder="Tanggal" :required="true" />

        {{-- JAM --}}
        <div class="div flex gap-2 mb-4">
            <div class="div">
                <label for="tanggal-izin" class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                <div class="relative">
                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="time" id="time" wire:model.defer="mulai_pukul"
                        class=" border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        min="09:00" max="18:00" value="00:00" required />
                </div>
            </div>
            <div class="div">
                <label for="tanggal-izin" class="block text-sm font-medium text-gray-700 mb-2">Jam
                    Selesai</label>
                <div class="relative">
                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                clip-rule="evenodd" />
                        </svg>`
                    </div>
                    <input type="time" id="time" wire:model.defer="sampai_pukul"
                        class=" border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        min="09:00" max="18:00" value="00:00" required />
                </div>
            </div>
        </div>

        <!-- Alasan -->
        <x-textarea label="Keperluan" for="keperluan" wire="keperluan" type="text" placeholder="Masukkan Keperluan"
            :required="true" rows="5" />
        <div class="mt-3">
            <div class="mt-3">
                <x-button wire:click="create" bg="[var(--primary)]" label="Submit" />
            </div>
        </div>
    </div>
</div>
