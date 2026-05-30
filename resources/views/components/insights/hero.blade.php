@props([
    'featuredInsight',
    'featured',
    'totalInsights',
    'topicsCount',
])

<section class="border-b border-slate-200 bg-white">
    <div class="container mx-auto grid gap-6 px-6 py-9 lg:grid-cols-[0.42fr_0.82fr_0.76fr] lg:items-stretch xl:grid-cols-[0.36fr_0.9fr_0.74fr]">
        <div class="flex flex-col justify-center">
            <span class="edulaw-eyebrow">Editorial</span>
            <h1 class="mt-3 text-5xl font-extrabold leading-tight text-slate-950 lg:text-[3.25rem]">
                Edulaw Insight
            </h1>
            <div class="mt-7 grid max-w-xs grid-cols-2 divide-x divide-slate-200 rounded-lg border border-slate-200 bg-white p-3 shadow-sm">
                <div class="flex items-center gap-2.5 pr-4">
                    <span class="flex h-9 w-9 items-center justify-center rounded-md bg-[#0F2868]/8 text-[#0F2868]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 4h7l3 3v13H7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 4v4h4M9 13h6M9 17h4"/></svg>
                    </span>
                    <div>
                        <p class="text-xl font-extrabold text-slate-950">{{ number_format($totalInsights, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-500">Tulisan</p>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 pl-4">
                    <span class="flex h-9 w-9 items-center justify-center rounded-md bg-[#0F2868]/8 text-[#0F2868]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 5v14l7-3 7 3V5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 8h6"/></svg>
                    </span>
                    <div>
                        <p class="text-xl font-extrabold text-slate-950">{{ $topicsCount }}</p>
                        <p class="text-xs text-slate-500">Topik</p>
                    </div>
                </div>
            </div>
        </div>

        @if($featuredInsight)
            <a href="{{ route('insight.show', $featuredInsight->slug) }}" class="group relative block min-h-[260px] overflow-hidden rounded-lg border border-slate-200 bg-slate-200 shadow-sm lg:min-h-[315px]">
                @if($featured['image'])
                    <img src="{{ asset('storage/' . $featured['image']) }}" alt="{{ $featuredInsight->title }}" class="h-full w-full object-cover object-[center_35%] transition duration-700 group-hover:scale-105">
                @else
                    <x-insights.fallback-thumbnail label="Insight" />
                @endif
            </a>

            <article class="flex flex-col justify-center rounded-lg border border-slate-200 bg-white p-5 shadow-sm lg:p-6">
                <span class="mb-3 inline-flex w-fit rounded bg-[#0F2868] px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.14em] text-white">
                    Featured Insight
                </span>
                <div class="mb-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-semibold text-slate-500">
                    <span>{{ $featured['categoryName'] }}</span>
                    <span class="text-slate-300">/</span>
                    <span>{{ \Carbon\Carbon::parse($featured['date'])->translatedFormat('d M Y') }}</span>
                </div>

                <h2 class="text-xl font-extrabold leading-[1.12] tracking-[-0.02em] text-slate-950 md:text-[1.45rem]">
                    <a href="{{ route('insight.show', $featuredInsight->slug) }}" class="transition hover:text-[#0F2868]">
                        {{ $featuredInsight->title }}
                    </a>
                </h2>

                @if($featured['excerpt'])
                    <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-600">{{ $featured['excerpt'] }}</p>
                @endif

                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        @if($featuredInsight->author_photo)
                            <img src="{{ asset('storage/' . $featuredInsight->author_photo) }}" alt="{{ $featured['authorName'] }}" class="h-9 w-9 rounded-full object-cover">
                        @else
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0F2868] text-xs font-bold text-white">
                                {{ strtoupper(substr($featured['authorName'], 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-xs font-bold text-slate-950">{{ $featured['authorName'] }}</p>
                            <p class="text-[11px] text-slate-500">{{ $featured['authorAffiliation'] }}</p>
                        </div>
                    </div>

                    <a href="{{ route('insight.show', $featuredInsight->slug) }}" class="inline-flex items-center justify-center rounded-md bg-[#0F2868] px-4 py-2 text-xs font-bold text-white transition hover:bg-[#071A3D]">
                        Baca Analisis Lengkap →
                    </a>
                </div>
            </article>
        @endif
    </div>
</section>
