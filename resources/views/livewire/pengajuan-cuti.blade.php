<div class="bg-white rounded-xl p-4">
    <h2 class="text-3xl mb-4 font-bold text-center ">
        Pengajuan Cuti
    </h2>

    <div class="w-full">
        <!-- Jenis Cuti -->
        <x-select label="Jenis Cuti" for="cuti_type_id" wire="cuti_type_id" :options="$cutiTypes" :required="true" />
        <!-- Tanggal Cuti -->
        <div class="mb-4">
            <label for="tanggal-cuti" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                Cuti</label>
            <input type="text" class="date border rounded-lg p-2" placeholder="Pilih tanggal" />
        </div>

        <x-textarea label="Alasan" for="alasan" wire="alasan" type="text" placeholder="Masukkan Alasan"
            :required="true" rows="5" />
        <div class="mt-3">
            <x-button wire:click="create" bg="[var(--primary)]" label="Submit" />
        </div>
    </div>


</div>

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#datepicker", {
            mode: "multiple",
            dateFormat: "d/m/Y",
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".date", {
                mode: "multiple",
                dateFormat: "d-m-Y",
                onChange: function(selectedDates, dateStr, instance) {
                    let formattedDates = selectedDates.map(date =>
                        instance.formatDate(date, "d-m-Y")
                    ).join(", ");

                    @this.set('tanggal', formattedDates);
                }
            });
        });
    </script>
@endpush
