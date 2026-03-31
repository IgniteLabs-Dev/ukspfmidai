@props([
    'title' => '',
])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
          integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{ $title ? $title . ' - ' : '' }}UKSPFMIDAI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
</head>

<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="">
                <a href="{{ route('index') }}" class="flex gap-2 items-center" >
                    <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto" alt="Logo">
                    <span class="text-2xl font-bold tracking-tight text-black">UKSPFMIDAI</span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                @php
                    try {
                        $user = JWTAuth::parseToken()->authenticate();
                 } catch (\Exception $e) {
                     $user = null;
                 }
                @endphp

                @if($user == null)
                    <a href="{{ route('login') }}" >
                        <button class="px-3 py-1.5  cursor-pointer  hover:scale-105 text-white rounded-md bg-[var(--primary)]">
                            Login
                        </button>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" >
                        <button class="px-3 py-1.5  cursor-pointer  hover:scale-105 text-white rounded-md bg-[var(--primary)]">
                            Dashboard
                        </button>
                    </a>
                @endif

            </div>
        </div>
    </div>
</nav>

