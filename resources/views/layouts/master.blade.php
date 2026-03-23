<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-mamuju.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>@yield('title', 'Cuti Web')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}" />
    @livewireStyles
    @stack('styles') {{-- buat custom CSS per page --}}
</head>

<body style="background-color: #f3f8fa !important;">

    <div class="flex h-screen ">
        @include('partials.sidebar')
        <div class="flex flex-col flex-1 overflow-y-auto">
            @include('partials.navbar')
            <div class="pt-10 mt-8 px-5 ">
                @yield('content')
            </div>
        </div>
    </div>


    @livewireScripts
    @include('partials.script')

</body>

</html>
