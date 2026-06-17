<div class="bg-white rounded-xl p-4 shadow-sm">
    <h2 class="text-3xl mb-4 font-bold text-center ">
        Pengajuan Cuti
    </h2>

    <div class="w-full">
        <!-- Jenis Cuti -->
        <div class="mb-3">
        <x-select label="Jenis Cuti" for="cuti_type_id" wire="cuti_type_id" :options="$cutiTypes" :required="true" />
        </div>
        <!-- Tanggal Cuti -->
        <div class="mb-3 flex gap-2 ">
            <x-input label="Tanggal Mulai" for="tanggal_start" wire="tanggal_start" type="date" placeholder="Tanggal" :required="true" />

            <x-input label="Tanggal Selesai" for="tanggal_end" wire="tanggal_end" type="date" placeholder="Tanggal" :required="true" />
        </div>

        <div class="mb-3">
            <label for="doc" class="block mb-1 text-sm font-medium text-gray-900">Dokumen
                <span class="text-red-500">*</span>
            </label>
            <input type="file" id="doc" wire:model="doc" accept=".pdf,.doc,.docx" class="bg-gray-50 w-full rounded-md file:bg-gray-400 file:text-white border-1 border-gray-200 cursor-pointer" />
            <p class="mt-1 text-xs text-gray-500">Format yang diterima: <span class="font-medium">PDF, DOC, DOCX</span> &bull; Maksimal <span class="font-medium">10 MB</span></p>
            @error('doc') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <x-textarea label="Alasan" for="alasan" wire="alasan" type="text" placeholder="Masukkan Alasan"
            :required="false" rows="5" />
        <div class="mt-3">
            <x-button wire:click="create" bg="[var(--primary)]" label="Submit" />
        </div>
    </div>


</div>


