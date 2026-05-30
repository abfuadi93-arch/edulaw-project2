@props([
    'insight',
    'card',
])

<article class="group flex h-full flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-[3px] hover:border-[#0F2868]/25 hover:shadow-[0_16px_36px_rgba(15,23,42,0.08)]">
    <a href="{{ route('insight.show', $insight->slug) }}" class="relative block aspect-[16/10] overflow-hidden bg-slate-200">
        @if($card['image'])
            <img src="{{ asset('storage/' . $card['image']) }}" alt="{{ $insight->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
        @else
            <x-insights.fallback-thumbnail label="Insight" :compact="true" />
        @endif
    </a>

    <div class="flex flex-1 flex-col p-4">
        <div class="mb-3 flex flex-wrap items-center gap-x-2 gap-y-1 text-[10px] font-extrabold uppercase tracking-[0.08em] text-slate-400">
            <span class="text-[#0F2868]">{{ $card['categoryName'] }}</span>
            @if($card['topicName'] !== 'Umum')
                <span class="text-slate-300">/</span>
                <span>{{ \Illuminate\Support\Str::limit($card['topicName'], 24) }}</span>
            @endif
            <span class="text-slate-300">/</span>
            <span>{{ \Carbon\Carbon::parse($card['date'])->translatedFormat('d M Y') }}</span>
        </div>

        <h3 class="line-clamp-2 text-base font-extrabold leading-snug text-slate-950">
            <a href="{{ route('insight.show', $insight->slug) }}" class="transition hover:text-[#0F2868]">
                {{ $insight->title }}
            </a>
        </h3>

        @if($card['excerpt'])
            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">{{ $card['excerpt'] }}</p>
        @endif

        <div class="mt-5 flex items-center gap-3">
            @if($insight->author_photo)
                <img src="{{ asset('storage/' . $insight->author_photo) }}" alt="{{ $card['authorName'] }}" class="h-8 w-8 rounded-full object-cover">
            @else
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#e7f1ee] text-xs font-bold text-[#0F2868]">
                    {{ strtoupper(substr($card['authorName'], 0, 1)) }}
                </div>
            @endif
            <div class="min-w-0">
                <p class="truncate text-xs font-bold text-slate-900">{{ $card['authorName'] }}</p>
                <p class="truncate text-[11px] text-slate-500">{{ $card['authorAffiliation'] }}</p>
            </div>
        </div>

        <div class="mt-auto flex flex-wrap items-center justify-between gap-3 pt-4 text-xs">
            <span class="font-semibold text-slate-500">
                {{ $card['readingMinutes'] }} menit baca · {{ number_format($card['wordCount'], 0, ',', '.') }} kata
            </span>
            <a href="{{ route('insight.show', $insight->slug) }}" class="font-bold text-[#0F2868] transition hover:underline">
                Baca selengkapnya →
            </a>
        </div>
    </div>
</article>
