<!DOCTYPE html>
<html lang="en">

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
    @livewireStyles
    @stack('styles') {{-- buat custom CSS per page --}}
</head>

<body style="background-color: #f3f8fa !important;">

    <div class="flex h-screen overflow-hidden">
        @include('partials.sidebar')
        <div class="flex flex-col flex-1 overflow-y-auto">
            @include('partials.navbar')
            <div class="pt-18 md:pt-18 mt-4 md:mt-0 px-5 pb-4">
                @yield('content')
            </div>
        </div>
    </div>


    @livewireScripts
    @include('partials.script')

</body>

</html>
