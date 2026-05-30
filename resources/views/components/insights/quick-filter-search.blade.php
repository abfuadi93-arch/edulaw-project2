@props([
    'categories',
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

<section class="sticky top-[88px] z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
    <form method="GET" action="{{ route('insights.index') }}" class="container mx-auto flex flex-col gap-4 px-6 py-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex gap-2 overflow-x-auto pb-1 lg:pb-0">
            <a href="{{ $filterUrl([], ['category']) }}" class="shrink-0 rounded-md border px-4 py-2 text-sm font-bold transition {{ request('category') ? 'border-slate-200 text-slate-600 hover:border-[#0F2868] hover:text-[#0F2868]' : 'border-[#0F2868] bg-[#0F2868] text-white' }}">Semua</a>
            @foreach($categories->take(5) as $category)
                <a href="{{ $filterUrl(['category' => $category->id], ['category']) }}" class="shrink-0 rounded-md border px-4 py-2 text-sm font-bold transition {{ (string) request('category') === (string) $category->id ? 'border-[#0F2868] bg-[#0F2868] text-white' : 'border-slate-200 text-slate-600 hover:border-[#0F2868] hover:text-[#0F2868]' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <div class="flex flex-1 gap-3 lg:max-w-2xl">
            @foreach(request()->except(['search', 'page']) as $key => $value)
                @if(is_scalar($value) && filled($value))
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari judul, penulis, atau topik hukum..."
                class="min-w-0 flex-1 rounded-md border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#0F2868]"
            >
            <button type="submit" class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-md border border-slate-200 text-[#0F2868] transition hover:border-[#0F2868]" aria-label="Cari insight">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
            </button>
        </div>

        <details class="rounded-md border border-slate-200 bg-white p-3 lg:hidden">
            <summary class="cursor-pointer text-sm font-bold text-[#0F2868]">Filter lanjutan</summary>
            <div class="mt-3 grid gap-3 sm:grid-cols-3">
                <select name="year" class="w-full rounded-md border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-[#0F2868]">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" @selected((string) request('year') === (string) $year)>{{ $year }}</option>
                    @endforeach
                </select>
                <select name="author" class="w-full rounded-md border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-[#0F2868]">
                    <option value="">Semua Penulis</option>
                    @foreach($authors as $author)
                        <option value="{{ $author }}" @selected(request('author') === $author)>{{ $author }}</option>
                    @endforeach
                </select>
                <select name="reading_time" class="w-full rounded-md border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none focus:border-[#0F2868]">
                    <option value="">Semua Durasi</option>
                    <option value="short" @selected(request('reading_time') === 'short')>Ringkas</option>
                    <option value="medium" @selected(request('reading_time') === 'medium')>Sedang</option>
                    <option value="long" @selected(request('reading_time') === 'long')>Mendalam</option>
                </select>
            </div>
            <div class="mt-3 flex items-center justify-between gap-3">
                @if($activeFilters)
                    <a href="{{ route('insights.index') }}" class="text-xs font-bold text-[#0F2868]">Reset filter</a>
                @endif
                <button type="submit" class="ml-auto rounded-md border border-[#0F2868] bg-white px-4 py-2 text-sm font-bold text-[#0F2868] transition hover:bg-[#0F2868] hover:text-white">Terapkan</button>
            </div>
        </details>
    </form>
</section>
