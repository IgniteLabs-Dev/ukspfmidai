<div>
    <div id="main-wrapper"
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-200 relative overflow-hidden">
        <div class="flex items-center justify-center w-full">
            <div class="w-full flex justify-center">
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-lg rounded-xl">
                        <div class="p-6">
                            <img src="{{ asset('images/logo_kab_mamuju.png') }}" width="100" alt=""
                                class="mx-auto" />
                            <h4 class="text-center font-bold text-xl mb-1">SiapBPKAD Mamuju</h4>
                            <p class="text-center text-gray-600 mb-6">
                                Sistem Informasi dokumen perizinan dan cuti kepegawaian dan kantoor BPKAD di Kabupaten
                                Memuju
                            </p>

                            <div>
                                <div class="mb-4">
                                    <label for="nama"
                                        class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                    <input wire:model.defer="name" type="text" id="nama"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    @error('name')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="nip"
                                        class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                    <input wire:model.defer="nip" type="nip" id="nip"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    @error('nip')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="password"
                                        class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                    <input wire:model.defer="password" type="password" id="password"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    @error('password')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button wire:click="registerStore"
                                    class="w-full py-3 text-base font-semibold rounded-lg bg-[var(--primary)] text-white hover:brightness-90 hover:cursor-pointer transition">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
