<x-navbar-home title="{{ $data->title }}" />

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
    <main class=" mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white my-4 rounded-xl shadow-sm  ">
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
</div>


<x-footer-home/>
