@extends('layouts.app')

@section('title', $authorName . ' - Author Profile Edulaw')
@section('meta_description', 'Profil author ' . $authorName . ' di Edulaw Project: jejak kontribusi, fokus tulisan, dan publikasi opini pribadi yang melalui kurasi editorial.')

@section('content')
@php
    $publicationCount = $authorInsights->total();
    $categoryTags = collect($categories)->values();
    $focusTags = $categoryTags->isNotEmpty()
        ? $categoryTags
        : collect(['Insight', 'Opini', 'Hukum Publik', 'Kebijakan Publik']);
    $displayTags = $focusTags->take(4);
    $firstYear = $firstPublishedAt ? \Carbon\Carbon::parse($firstPublishedAt)->translatedFormat('Y') : now()->translatedFormat('Y');
    $latestDate = $latestPublishedAt ? \Carbon\Carbon::parse($latestPublishedAt)->translatedFormat('d M Y') : 'Belum tersedia';
    $authorBio = $authorName . ' menulis analisis hukum, konstitusi, demokrasi, dan kebijakan publik dalam ekosistem pengetahuan Edulaw. Seluruh tulisan merupakan opini pribadi penulis, proses editorial dilakukan untuk menjaga akurasi, relevansi, etika, dan kualitas argumentasi.';

    if ($authorAffiliation && $authorAffiliation !== 'Edulaw Project') {
        $authorBio .= ' Saat ini terafiliasi dengan ' . $authorAffiliation . '.';
    }
@endphp

<main class="bg-slate-50">
    <section class="border-b border-slate-200 bg-white">
        <div class="container mx-auto px-6 py-10">
            <a href="{{ route('insights.index') }}" class="inline-flex text-sm font-bold text-[#0F2868] transition hover:text-[#071A3D]">
                Kembali ke Edulaw Insight
            </a>
        </div>
    </section>

    <section class="bg-white">
        <div class="container mx-auto grid gap-8 px-6 pb-12 lg:grid-cols-[1fr_360px] lg:items-stretch">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm md:p-8">
                <div class="flex flex-col gap-6 md:flex-row md:items-start">
                    <div class="flex h-28 w-28 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#0F2868]/10 text-4xl font-extrabold text-[#0F2868] ring-1 ring-[#0F2868]/10">
                        @if($authorPhoto)
                            <img src="{{ asset('storage/' . $authorPhoto) }}" alt="{{ $authorName }}" class="h-full w-full object-cover">
                        @else
                            {{ strtoupper(substr($authorName, 0, 1)) }}
                        @endif
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-[#0F2868]">
                            Author Profile
                        </p>
                        <h1 class="mt-3 text-4xl font-extrabold leading-tight text-slate-950 md:text-5xl">
                            {{ $authorName }}
                        </h1>
                        <p class="mt-3 text-sm font-bold text-slate-500">
                            Author Edulaw Project
                            @if($authorAffiliation)
                                <span class="text-slate-300">/</span> {{ $authorAffiliation }}
                            @endif
                        </p>
                        <p class="mt-5 max-w-3xl text-base leading-8 text-slate-600">
                            {{ $authorBio }}
                        </p>

                        <div class="mt-6 flex flex-wrap gap-2">
                            <span class="rounded-md bg-[#0F2868] px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-white">Author Edulaw</span>
                            <span class="rounded-md bg-teal-50 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-teal-700">Insight Contributor</span>
                            @foreach($displayTags as $tag)
                                <span class="rounded-md bg-slate-100 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-slate-600">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <aside class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-[#0F2868]">Author Credibility</p>

                <div class="mt-5 space-y-5">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-400">Bidang Minat</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($displayTags as $tag)
                                <span class="rounded-md border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-bold text-slate-600">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-5">
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-400">Status Kontributor</p>
                        <div class="mt-3 space-y-2 text-sm font-semibold text-slate-700">
                            <p>Author Edulaw</p>
                            <p>Opini Pribadi Terkurasi Editorial</p>
                            <p>Bergabung sejak {{ $firstYear }}</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-5">
                        <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-400">Terakhir Terbit</p>
                        <p class="mt-2 text-lg font-extrabold text-slate-950">{{ $latestDate }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-white">
        <div class="container mx-auto grid gap-4 px-6 py-8 md:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-3xl font-extrabold text-slate-950">{{ number_format($publicationCount, 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Tulisan Tayang</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-3xl font-extrabold text-slate-950">{{ number_format($totalViews, 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Total Dibaca</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-3xl font-extrabold text-slate-950">{{ number_format(max(1, $categoryTags->count()), 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Kategori Kontribusi</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($displayTags->take(3) as $tag)
                        <span class="rounded-md bg-[#0F2868]/8 px-3 py-1 text-xs font-bold text-[#0F2868]">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-6 py-12">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="max-w-3xl">
                <span class="edulaw-eyebrow">Kontribusi Terbaru</span>
                <h2 class="mt-3 text-3xl font-extrabold leading-tight text-slate-950 md:text-4xl">Tulisan Terbaru</h2>
                <p class="mt-3 text-base leading-7 text-slate-600">
                    Kumpulan artikel dan opini yang ditulis oleh {{ $authorName }} di Edulaw Project.
                </p>
            </div>
            <a href="{{ route('insights.index', ['author' => $authorName]) }}" class="inline-flex rounded-md border border-[#0F2868]/25 px-5 py-3 text-sm font-bold text-[#0F2868] transition hover:bg-[#0F2868] hover:text-white">
                Lihat Semua Tulisan
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-[1fr_320px]">
            <div>
                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($authorInsights as $insight)
                        @php
                            $image = $insight->thumbnail ?: $insight->image;
                            $date = $insight->published_at ?? $insight->created_at;
                            $categoryRelation = $insight->relationLoaded('category') ? $insight->getRelation('category') : null;
                            $categoryName = $categoryRelation?->name ?: 'Insight';
                            $readingMinutes = max(1, (int) ceil(str_word_count(strip_tags($insight->content ?? '')) / 200));
                            $excerpt = \Illuminate\Support\Str::limit(strip_tags($insight->excerpt ?: ($insight->summary ?: $insight->content)), 132);
                        @endphp
                        <article class="group flex h-full flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-[#0F2868]/25 hover:shadow-xl">
                            <a href="{{ route('insight.show', $insight->slug) }}" class="block aspect-[16/10] overflow-hidden bg-slate-100">
                                @if($image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $insight->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                @else
                                    <div class="flex h-full items-center justify-center bg-[#0F2868] text-xs font-bold uppercase tracking-[0.18em] text-white/70">Edulaw Insight</div>
                                @endif
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <div class="mb-3 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs font-semibold text-slate-500">
                                    <span class="font-bold uppercase tracking-[0.12em] text-[#0F2868]">{{ $categoryName }}</span>
                                    <span class="text-slate-300">/</span>
                                    <span>{{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}</span>
                                </div>
                                <h3 class="line-clamp-2 text-lg font-extrabold leading-snug text-slate-950">
                                    <a href="{{ route('insight.show', $insight->slug) }}" class="transition hover:text-[#0F2868]">{{ $insight->title }}</a>
                                </h3>
                                @if($excerpt)
                                    <p class="mt-3 line-clamp-3 text-sm leading-7 text-slate-600">{{ $excerpt }}</p>
                                @endif
                                <div class="mt-auto flex items-center justify-between gap-4 border-t border-slate-100 pt-4 text-sm">
                                    <span class="font-semibold text-slate-500">± {{ $readingMinutes }} menit baca</span>
                                    <a href="{{ route('insight.show', $insight->slug) }}" class="inline-flex rounded-md bg-[#0F2868] px-3 py-2 text-xs font-bold text-white transition hover:bg-[#071A3D]">Baca Insight</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($authorInsights->hasPages())
                    <div class="mt-8 rounded-lg border border-slate-200 bg-white px-5 py-4">
                        {{ $authorInsights->links() }}
                    </div>
                @endif
            </div>

            <aside class="space-y-5">
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#0F2868]">Tentang Penulis</p>
                    <p class="mt-3 text-sm leading-7 text-slate-600">{{ $authorBio }}</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#0F2868]">Fokus Tulisan</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($displayTags as $tag)
                            <span class="rounded-md bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#0F2868]">Karya Populer</p>
                    <div class="mt-3 divide-y divide-slate-100">
                        @forelse($popularInsights as $popularInsight)
                            <a href="{{ route('insight.show', $popularInsight->slug) }}" class="block py-3 text-sm font-bold leading-6 text-slate-950 transition hover:text-[#0F2868]">
                                {{ $popularInsight->title }}
                            </a>
                        @empty
                            <p class="py-3 text-sm text-slate-500">Belum ada karya populer.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="border-t border-slate-200 bg-white">
        <div class="container mx-auto px-6 py-10">
            <div class="rounded-lg border border-[#0F2868]/15 bg-[#0F2868]/5 p-6">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#0F2868]">Catatan Editorial</p>
                <p class="mt-3 w-full text-sm leading-7 text-slate-600">
                    Seluruh tulisan merupakan opini pribadi penulis, proses editorial dilakukan untuk menjaga akurasi, relevansi, etika, dan kualitas argumentasi.
                </p>
            </div>
        </div>
    </section>
</main>
@endsection
