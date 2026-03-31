<x-navbar-home/>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 pt-4">
    @php
        $first = $data->first();
    @endphp
    <!-- Hero Section (Berita Utama) -->
    @if($first)
        <a href="{{ route('detail.berita', $first->id) }}" >
        <section class="mb-5">
            <div class="relative group cursor-pointer overflow-hidden rounded-2xl bg-gray-900 aspect-[16/9] md:aspect-[21/9]">

                <!-- IMAGE -->
                <img src="{{ asset('files/news/' . $first->cover) }}"
                     alt="{{ $first->title }}"
                     class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:scale-105 transition duration-700">

                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                <!-- CONTENT -->
                <div class="absolute bottom-0 p-6 md:p-12 text-white">
                <span class="inline-block px-3 py-1 bg-indigo-600 text-xs font-bold uppercase tracking-wider rounded-full mb-4">
                    Berita Terbaru
                </span>
                    <h1 class="text-3xl md:text-5xl font-bold mb-4 md:max-w-full max-w-3xl leading-tight">
                        {{ $first->title }}
                    </h1>

                    <p class="text-gray-300 max-w-2xl md:max-w-full mb-4">
                        {{ \Illuminate\Support\Str::limit(strip_tags($first->content), 150) }}
                    </p>

                    <div class="flex items-center gap-4 text-sm text-gray-300">
                        <span><i class="fa-solid fa-user"></i> {{ $first->user->name ?? 'Admin' }}</span>
                        <span><i class="fa-solid fa-calendar-days"></i> {{ $first->created_at->diffForHumans() }}</span>
                    </div>
                </div>

            </div>
        </section>
        </a>
    @endif

    <!-- Kategori & Filter -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            Berita Terbaru
        </h2>

    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

       @forelse($data as $item)
            @if($loop->index == 0)
                @continue
            @endif
        <a href="{{ route('detail.berita', $item->id) }}" >
            <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow group">
                <div class="relative overflow-hidden h-48">
                    <img src="{{ asset('files/news/'. $item->cover) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="News 1">
                </div>
                <div class="p-5 flex flex-col justify-between ">
                    <h3 class="font-bold text-xl mb-3 line-clamp-2 group-hover:text-indigo-600 transition">{{$item->title}}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{!! Str::limit(strip_tags($item->content), 97, '...') !!}</p>
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span><i class="fa-solid fa-user"></i> {{$item->user->name}}</span>
                        <span><i class="fa-solid fa-calendar-days"></i> {{ $item->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </article>
        </a>
       @empty
            <div class="col-span-full text-center py-10">
                <h3 class="text-xl font-semibold text-gray-500">Belum ada berita terbaru saat ini.</h3>
            </div>
       @endforelse


    </div>

    <!-- Load More -->
    <div class="mt-16 text-center">
            {{ $data->links() }}
    </div>

</main>

<x-footer-home/>
