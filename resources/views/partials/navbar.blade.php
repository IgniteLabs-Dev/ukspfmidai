@php
    $user = JWTAuth::parseToken()->authenticate();
    $service = new \App\Services\CutiIzinCountService();
    $izinCount = $service->IzinCount('waiting');
    $cutiCount = $service->CutiCount('waiting');
    $cutiIzinApprover = $service->IsApprovalUser();
@endphp

<header x-data="{ open: false }" class="antialiased fixed top-0 left-0 w-full z-50">
    <nav class="bg-white border-b border-gray-200 px-4 py-2.5 shadow-sm">
        <div class="flex justify-between items-center max-w-full">
            {{-- Bagian Kiri: Logo --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 transition-transform hover:scale-105">
                <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto" alt="Logo">
                    <span class="font-bold text-lg hidden md:block tracking-tight text-gray-800 uppercase">UKSPFMIDAI</span>
                </a>
            </div>

            {{-- Bagian Tengah: Nama User --}}
            <div class="flex items-center px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-sm font-semibold text-gray-700 truncate max-w-[80px] sm:max-w-[150px]">
                        {{ $user->name }}
                    </span>
                </div>
            </div>

            {{-- Bagian Kanan --}}
            <div class="flex items-center gap-2">
                <div class="hidden lg:block">
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 bg-[var(--danger)] text-white cursor-pointer px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:opacity-90 transition-all">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>

                <button @click="open = true" class="p-2 text-gray-600 rounded-lg bg-gray-100 cursor-pointer lg:hidden hover:bg-gray-200 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- MODAL SIDEBAR MOBILE (Slide-in dari Kiri) --}}
    <div x-show="open" class="fixed inset-0 z-[60] lg:hidden" style="display: none;">
        <div x-show="open" x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="open = false"></div>

        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="absolute left-0 top-0 h-full w-72 bg-white shadow-2xl flex flex-col">

            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="h-6" alt="">
                    <span class="font-bold text-gray-800 uppercase text-sm tracking-tight">UKSPFMIDAI</span>
                </div>
                <button @click="open = false" class="p-2 text-gray-400 hover:text-red-500">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-gray-900' : 'group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3 font-medium">Dashboard</span>
                </a>

                {{-- Pengajuan Cuti --}}
                <a href="{{ route('pengajuan-cuti') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('pengajuan-cuti') ? 'bg-gray-100' : '' }}">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 {{ request()->routeIs('pengajuan-cuti') ? 'text-gray-900' : 'group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                    </svg>
                    <span class="ms-3 font-medium">Pengajuan Cuti</span>
                </a>

                {{-- Pengajuan Izin --}}
                <a href="{{ route('pengajuan-izin') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('pengajuan-izin') ? 'bg-gray-100' : '' }}">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 {{ request()->routeIs('pengajuan-izin') ? 'text-gray-900' : 'group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="ms-3 font-medium">Pengajuan Izin</span>
                </a>

                {{-- Riwayat Izin --}}
                <a href="{{ route('riwayat-izin') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('riwayat-izin') ? 'bg-gray-100' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left w-5 text-center text-gray-500 {{ request()->routeIs('riwayat-izin') ? 'text-gray-900' : 'group-hover:text-gray-900' }}"></i>
                    <span class="ms-3 font-medium">Riwayat Izin</span>
                </a>

                {{-- Riwayat Cuti --}}
                <a href="{{ route('riwayat-cuti') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('riwayat-cuti') ? 'bg-gray-100' : '' }}">
                    <i class="fa-regular fa-calendar-days w-5 text-center text-gray-500 {{ request()->routeIs('riwayat-cuti') ? 'text-gray-900' : 'group-hover:text-gray-900' }}"></i>
                    <span class="ms-3 font-medium">Riwayat Cuti</span>
                </a>

                {{-- Group Atasan --}}
                @if ($cutiIzinApprover['is_cuti_approver'] || $cutiIzinApprover['is_izin_approver'])
                    <li class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider list-none pt-4">Atasan</li>
                    @if ($cutiIzinApprover['is_cuti_approver'])
                        <a href="{{ route('permohonan-cuti') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('permohonan-cuti') ? 'bg-gray-100' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 {{ request()->routeIs('permohonan-cuti') ? 'text-gray-900' : 'group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                            </svg>
                            <span class="ms-3 font-medium">Permohonan Cuti</span>
                            @if ($cutiCount > 0)
                                <span class="inline-flex items-center justify-center w-5 h-5 ms-auto text-xs font-medium text-blue-800 bg-blue-100 rounded-full">{{ $cutiCount }}</span>
                            @endif
                        </a>
                    @endif
                    @if ($cutiIzinApprover['is_izin_approver'])
                        <a href="{{ route('permohonan-izin') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('permohonan-izin') ? 'bg-gray-100' : '' }}">
                            <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 {{ request()->routeIs('permohonan-izin') ? 'text-gray-900' : 'group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                            </svg>
                            <span class="ms-3 font-medium">Permohonan Izin</span>
                            @if ($izinCount > 0)
                                <span class="inline-flex items-center justify-center w-5 h-5 ms-auto text-xs font-medium text-blue-800 bg-blue-100 rounded-full">{{ $izinCount }}</span>
                            @endif
                        </a>
                    @endif
                @endif

                {{-- Group Admin --}}
                @if ($user->role == 'SUPERADMIN' || $user->role == 'ADMIN')
                    <li class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider list-none pt-4">Admin</li>
                    @if ($user->role == 'SUPERADMIN')
                    <a href="{{ route('manajemen-web') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('manajemen-web') ? 'bg-gray-100' : '' }}">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 {{ request()->routeIs('manajemen-web') ? 'text-gray-900' : 'group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                        </svg>
                        <span class="ms-3 font-medium">Manajemen Web</span>
                    </a>
                    @endif
                    <a href="{{ route('manajemen-user') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('manajemen-user') ? 'bg-gray-100' : '' }}">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 {{ request()->routeIs('manajemen-user') ? 'text-gray-900' : 'group-hover:text-gray-900' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z" />
                            <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z" />
                            <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z" />
                        </svg>
                        <span class="ms-3 font-medium">Manajemen User</span>
                    </a>

                    <a href="{{ route('manajemen-berita') }}"
                       class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->routeIs('manajemen-berita*') ? 'bg-gray-100' : '' }}">

                        <svg class="w-5 h-5 text-gray-500 transition duration-75 {{ request()->routeIs('manajemen-berita*') ? 'text-gray-900' : 'group-hover:text-gray-900' }}"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" />
                            <path d="M8 8l4 0" /><path d="M8 12l4 0" /><path d="M8 16l4 0" />
                        </svg>

                        <span class="ms-3 font-medium">Manajemen Berita</span>
                    </a>
                @endif

                {{-- Logout --}}
                <div class="pt-4 mt-4 border-t border-gray-100 flex justify-center w-full">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 bg-[var(--danger)] text-white cursor-pointer px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:opacity-90 transition-all w-full">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="h-16"></div>
