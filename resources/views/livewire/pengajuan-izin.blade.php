<div class="bg-white rounded-xl p-4">
    <h2 class="text-3xl mb-4 font-bold text-center ">
        Pengajuan Izin
    </h2>
    <div class="w-full">
        <!-- Jenis Izin -->
        <div class="mb-3">
        <x-select label="Jenis Izin" for="izin_type_id" wire="izin_type_id" :options="$izinTypes" :required="true" />
        </div>

        <!-- Tanggal Izin -->
        <div class="mb-3 flex gap-2">
        <x-input label="Waktu Mulai" for="tanggal_mulai" wire="tanggal_mulai" type="datetime-local" placeholder="Tanggal" :required="true" />
        <x-input label="Waktu Selsai" for="tanggal_selesai" wire="tanggal_selesai" type="datetime-local" placeholder="Tanggal" :required="true" />
        </div>

        <div class="mb-3">
            <label for="doc" class="block mb-1 text-sm font-medium text-gray-900">Dokumen
                <span class="text-red-500">*</span>
            </label>
            <input type="file" id="doc" wire:model="doc" accept=".pdf,.doc,.docx" class="bg-gray-50 w-full rounded-md file:bg-gray-400 file:text-white border-1 border-gray-200 cursor-pointer" />
            <p class="mt-1 text-xs text-gray-500">Format yang diterima: <span class="font-medium">PDF, DOC, DOCX</span> &bull; Maksimal <span class="font-medium">10 MB</span></p>
            @error('doc') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <!-- Alasan -->
        <x-textarea label="Keperluan" for="keperluan" wire="keperluan" type="text" placeholder="Masukkan Keperluan"
            :required="false" rows="5" />
        <div class="mt-3">
            <div class="mt-3">
                <x-button wire:click="create" bg="[var(--primary)]" label="Submit" />
            </div>
        </div>
    </div>
</div>
