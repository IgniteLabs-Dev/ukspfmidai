<div class="bg-white rounded-xl p-4">
    <h2 class="text-3xl mb-4 font-bold text-center ">
        Pengajuan Cuti
    </h2>

    <div class="w-full">
        <!-- Jenis Cuti -->
        <x-select label="Jenis Cuti" for="cuti_type_id" wire="cuti_type_id" :options="$cutiTypes" :required="true" />
        <!-- Tanggal Cuti -->
        <div class="mb-4 flex gap-2 mt-2">
            <x-input label="Tanggal Mulai" for="tanggal_start" wire="tanggal_start" type="date" placeholder="Tanggal" :required="true" />

            <x-input label="Tanggal Selesai" for="tanggal_end" wire="tanggal_end" type="date" placeholder="Tanggal" :required="true" />
        </div>

        <x-textarea label="Alasan" for="alasan" wire="alasan" type="text" placeholder="Masukkan Alasan"
            :required="true" rows="5" />
        <div class="mt-3">
            <x-button wire:click="create" bg="[var(--primary)]" label="Submit" />
        </div>
    </div>


</div>


