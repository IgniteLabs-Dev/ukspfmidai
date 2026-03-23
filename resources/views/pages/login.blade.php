<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-mamuju.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title', 'Login | SiapBPKAD Mamuju')</title>
    @stack('styles') {{-- buat custom CSS per page --}}
    @livewireStyles
</head>

<body>
    <div class="min-h-screen flex items-center justify-center">
        <!-- Background radial gradient -->
        <div class="absolute inset-0 -z-10"
            style="background: radial-gradient(ellipse at 10% 10%, rgba(249,152,27,0.12), transparent 10%), radial-gradient(circle at 90% 90%, rgba(25,118,210,0.06), transparent 10%), #fff;">
        </div>

        <div class="w-full px-4">
            <div class="mx-auto w-full max-w-md md:max-w-lg lg:max-w-sm">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-8">
                        <img src="{{ asset('images/logo_kab_mamuju.png') }}" alt="logo"
                            class="mx-auto w-24 h-auto" />

                        <h4 class="text-center text-2xl font-extrabold tracking-tight">SiapBPKAD Mamuju</h4>
                        <p class="text-center text-sm text-gray-500 mt-1 mb-6">
                            Sistem Informasi dokumen perizinan dan cuti kepegawaian dan kantoor BPKAD di Kabupaten
                            Memuju
                        </p>

                        <form action="{{ route('login-store') }}" method="POST" class="space-y-4">
                            @csrf

                            @if (Session::has('error'))
                                <div class="rounded-md bg-red-50 border border-red-200 text-red-700 px-4 py-2 text-sm">
                                    {{ Session::get('error') }}
                                </div>
                            @endif

                            <div>
                                <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                <input name="nip" type="nip" id="nip" aria-describedby="nip"
                                    class="block w-full rounded-lg border border-gray-200 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500"
                                    value="{{ old('nip') }}" />
                                @error('nip')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input name="password" type="password" id="password"
                                    class="block w-full rounded-lg border border-gray-200 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500" />
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full py-3 text-base font-semibold rounded-lg bg-[var(--primary)] text-white hover:brightness-90 hover:cursor-pointer transition">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
