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
    <title>@yield('title', 'UKSPFMIDAI')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
</head>
<body class="bg-gray-50 text-gray-900">

<!-- Navbar -->
<nav class="sticky top-0 z-50  bg-white/80 shadow-xs backdrop-blur-md border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center ">
                <a href="{{ route('index') }}" >
                    <span class="text-2xl font-bold tracking-tight text-[var(--primary)]">UKSPFMIDAI</span>
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

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white my-4 rounded-xl shadow-sm ">
    <article class="prose lg:prose-xl">
        <h1 class="text-4xl font-bold">{{ $data->title }}</h1>
        <div class="flex gap-2 mt-2">

        <p class="text-sm text-gray-500"><i class="fa-solid fa-user"></i></i> {{ $data->user->name }}</p>
        <p class="text-sm text-gray-500"><i class="fa-solid fa-calendar-days"></i> {{ $data->created_at->format('d M Y') }}</p>
        </div>
        <img src="{{ asset('files/news/' . $data->cover) }}" alt="{{ $data->title }}" class="w-full rounded-lg my-4 h-55 md:h-100 object-cover">
        <div>{!! $data->content !!}</div>
    </article>
</main>

<footer class="bg-gray-900 text-white   py-4 text-center">
    <span class="text-gray-300">{{ now()->year }} - UKSPFMIDAI</span>
</footer>
</body>
</html>
