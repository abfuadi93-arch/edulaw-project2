@props([
    'popularInsights',
    'topics',
    'trendingIssues',
    'cardData',
])

<section class="mt-10 border-t border-slate-200 bg-white lg:mt-[72px]">
    <div class="container mx-auto grid gap-5 px-6 py-10 lg:grid-cols-[1.1fr_0.7fr_1.1fr]">
        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="text-lg font-extrabold text-slate-950">Paling Banyak Dibaca</h2>
            <div class="mt-4 divide-y divide-slate-100">
                @foreach($popularInsights as $popular)
                    @php($popularData = $cardData($popular))
                    <a href="{{ route('insight.show', $popular->slug) }}" class="flex gap-4 py-3 transition hover:text-[#0F2868]">
                        <span class="mt-0.5 text-lg font-extrabold text-[#0F2868]">{{ $loop->iteration }}</span>
                        <div class="min-w-0 flex-1">
                            <h3 class="line-clamp-2 text-sm font-bold leading-snug text-slate-950">{{ $popular->title }}</h3>
                            <p class="mt-1 text-xs text-slate-500">{{ $popularData['categoryName'] }} · {{ \Carbon\Carbon::parse($popularData['date'])->translatedFormat('d M Y') }}</p>
                        </div>
                        <span class="shrink-0 text-xs font-semibold text-slate-400">{{ number_format($popular->views_count ?? 0, 0, ',', '.') }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="text-lg font-extrabold text-slate-950">Topik Populer</h2>
            <div class="mt-4 flex flex-wrap gap-3">
                @foreach($topics->take(10) as $topic)
                    <a href="{{ route('insights.index', ['topic' => $topic]) }}" class="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-bold text-[#0F2868] transition hover:border-[#0F2868] hover:bg-[#0F2868] hover:text-white">
                        #{{ str_replace(' ', '', $topic) }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="text-lg font-extrabold text-slate-950">Trending Issue</h2>
            <div class="mt-4 divide-y divide-slate-100">
                @foreach($trendingIssues as $issue)
                    <a href="{{ route('insights.index', ['search' => $issue['query']]) }}" class="group flex items-center justify-between gap-4 py-3">
                        <div>
                            <p class="text-sm font-bold text-slate-950 transition group-hover:text-[#0F2868]">{{ $issue['label'] }}</p>
                            <p class="mt-1 text-xs leading-5 text-slate-500">Pembahasan publik dan catatan kritis dari berbagai kalangan.</p>
                        </div>
                        <span class="text-xl font-bold text-[#0F2868] transition group-hover:translate-x-1">→</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
