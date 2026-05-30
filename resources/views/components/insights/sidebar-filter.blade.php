@props([
    'categories',
    'topics',
    'years',
    'authors',
    'activeFilters' => 0,
])

@php
    $filterUrl = fn (array $params = [], array $remove = []) => route(
        'insights.index',
        array_merge(request()->except(array_merge(['page'], $remove)), $params)
    );
@endphp

<aside class="hidden lg:block">
    <form method="GET" action="{{ route('insights.index') }}" class="sticky top-[170px] rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        @foreach(['search', 'category', 'topic'] as $key)
            @if(filled(request($key)))
                <input type="hidden" name="{{ $key }}" value="{{ request($key) }}">
            @endif
        @endforeach

        <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
            <h2 class="text-lg font-extrabold text-slate-950">Filter Insight</h2>
            @if($activeFilters)
                <a href="{{ route('insights.index') }}" class="text-xs font-bold text-[#0F2868]">Reset</a>
            @endif
        </div>

        <div class="space-y-6">
            <div>
                <p class="mb-3 text-xs font-extrabold text-[#0F2868]">Kategori</p>
                <div class="space-y-2">
                    <a href="{{ $filterUrl([], ['category']) }}" class="flex items-center gap-3 text-sm font-semibold {{ request('category') ? 'text-slate-600 hover:text-[#0F2868]' : 'text-[#0F2868]' }}">
                        <span class="flex h-4 w-4 items-center justify-center rounded border {{ request('category') ? 'border-slate-300' : 'border-[#0F2868] bg-[#0F2868]' }}">
                            @unless(request('category'))<span class="h-1.5 w-1.5 rounded-full bg-white"></span>@endunless
                        </span>
                        Semua
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ $filterUrl(['category' => $category->id], ['category']) }}" class="flex items-center gap-3 text-sm font-semibold {{ (string) request('category') === (string) $category->id ? 'text-[#0F2868]' : 'text-slate-600 hover:text-[#0F2868]' }}">
                            <span class="flex h-4 w-4 items-center justify-center rounded border {{ (string) request('category') === (string) $category->id ? 'border-[#0F2868] bg-[#0F2868]' : 'border-slate-300' }}">
                                @if((string) request('category') === (string) $category->id)<span class="h-1.5 w-1.5 rounded-full bg-white"></span>@endif
                            </span>
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="mb-3 text-xs font-extrabold text-[#0F2868]">Topik</p>
                <div class="space-y-2">
                    <a href="{{ $filterUrl([], ['topic']) }}" class="flex items-center gap-3 text-sm font-semibold {{ request('topic') ? 'text-slate-600 hover:text-[#0F2868]' : 'text-[#0F2868]' }}">
                        <span class="flex h-4 w-4 items-center justify-center rounded border {{ request('topic') ? 'border-slate-300' : 'border-[#0F2868] bg-[#0F2868]' }}">
                            @unless(request('topic'))<span class="h-1.5 w-1.5 rounded-full bg-white"></span>@endunless
                        </span>
                        Semua
                    </a>
                    @foreach($topics->take(5) as $topic)
                        <a href="{{ $filterUrl(['topic' => $topic], ['topic']) }}" class="flex items-center gap-3 text-sm font-semibold {{ request('topic') === $topic ? 'text-[#0F2868]' : 'text-slate-600 hover:text-[#0F2868]' }}">
                            <span class="flex h-4 w-4 items-center justify-center rounded border {{ request('topic') === $topic ? 'border-[#0F2868] bg-[#0F2868]' : 'border-slate-300' }}">
                                @if(request('topic') === $topic)<span class="h-1.5 w-1.5 rounded-full bg-white"></span>@endif
                            </span>
                            {{ $topic }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="mb-2 block text-xs font-extrabold text-[#0F2868]" for="year-filter">Tahun</label>
                <select id="year-filter" name="year" class="w-full rounded-md border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-[#0F2868]">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" @selected((string) request('year') === (string) $year)>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-xs font-extrabold text-[#0F2868]" for="author-filter">Penulis</label>
                <select id="author-filter" name="author" class="w-full rounded-md border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-[#0F2868]">
                    <option value="">Semua Penulis</option>
                    @foreach($authors as $author)
                        <option value="{{ $author }}" @selected(request('author') === $author)>{{ $author }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-xs font-extrabold text-[#0F2868]" for="reading-filter">Durasi Baca</label>
                <select id="reading-filter" name="reading_time" class="w-full rounded-md border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-[#0F2868]">
                    <option value="">Semua Durasi</option>
                    <option value="short" @selected(request('reading_time') === 'short')>Ringkas</option>
                    <option value="medium" @selected(request('reading_time') === 'medium')>Sedang</option>
                    <option value="long" @selected(request('reading_time') === 'long')>Mendalam</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-xs font-extrabold text-[#0F2868]" for="sort-filter">Urutan</label>
                <select id="sort-filter" name="sort" class="w-full rounded-md border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-[#0F2868]">
                    <option value="">Terbaru</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
                    <option value="reading_asc" @selected(request('sort') === 'reading_asc')>Bacaan Ringkas</option>
                </select>
            </div>

            <button type="submit" class="w-full rounded-md border border-[#0F2868] bg-white px-5 py-3 text-sm font-bold text-[#0F2868] transition hover:bg-[#0F2868] hover:text-white">
                Terapkan Filter
            </button>
        </div>
    </form>
</aside>
