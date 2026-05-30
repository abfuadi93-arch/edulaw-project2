@extends('layouts.app')

@section('title', 'Pencarian - Edulaw Project')

@section('content')
<section class="bg-gradient-to-b from-slate-50 via-white to-slate-50 py-12">
    <div class="container mx-auto px-6">
        <div class="mb-7 max-w-3xl">
            <span class="edulaw-eyebrow">Knowledge Search</span>
            <h1 class="mt-3 text-4xl font-black leading-tight text-slate-950 md:text-5xl">Telusuri ekosistem pengetahuan hukum Edulaw.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                Cari insight, putusan, topik hukum, publikasi riset, dan program belajar dalam satu pintu pencarian.
            </p>
        </div>

        <form action="{{ route('search.index') }}" method="GET" class="mb-8 rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">
            <div class="grid gap-3 md:grid-cols-[1fr_auto]">
            <input
                type="search"
                name="q"
                value="{{ $query }}"
                placeholder="Cari isu, putusan, publikasi, atau program..."
                class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-[#0F2868] focus:bg-white"
            >
            <button class="rounded-xl bg-[#0F2868] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#071A3D]">
                Cari
            </button>
            </div>
        </form>

        @if($query === '')
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-bold text-slate-950">Mulai dengan kata kunci</h2>
                <p class="mt-2 text-sm text-slate-500">Contoh: konstitusi, pemilu, policy brief, hukum digital.</p>
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach($issueSuggestions as $issue)
                        <a href="{{ route('search.index', ['q' => $issue]) }}" class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:border-[#0F2868] hover:text-[#0F2868]">{{ $issue }}</a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm font-semibold text-slate-500">Hasil untuk <span class="text-slate-950">“{{ $query }}”</span></p>
                <a href="{{ route('search.index') }}" class="text-sm font-bold text-[#0F2868] hover:text-[#071A3D]">Reset pencarian</a>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h2 class="text-xl font-bold text-slate-950">Insight</h2>
                        <span class="rounded-full bg-teal-50 px-2.5 py-1 text-xs font-bold text-teal-700">{{ $insights->count() }}</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($insights as $insight)
                            <a href="{{ route('insight.show', $insight->slug) }}" class="block rounded-xl border border-slate-100 p-4 transition hover:-translate-y-0.5 hover:border-[#0F2868]/30 hover:shadow-md">
                                <p class="text-sm font-bold leading-snug text-slate-950">{{ $insight->title }}</p>
                                <p class="mt-2 text-xs font-semibold leading-5 text-slate-500">
                                    {{ $insight->category?->name ?: 'Insight' }}@if($insight->topic_label) · {{ $insight->topic_label }}@endif
                                </p>
                            </a>
                        @empty
                            <p class="text-sm text-slate-500">Tidak ada insight yang cocok.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h2 class="text-xl font-bold text-slate-950">Riset & Publikasi</h2>
                        <span class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-bold text-sky-700">{{ $publications->count() }}</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($publications as $publication)
                            <a href="{{ route('research.show', $publication) }}" class="block rounded-xl border border-slate-100 p-4 transition hover:-translate-y-0.5 hover:border-[#0F2868]/30 hover:shadow-md">
                                <p class="text-sm font-bold leading-snug text-slate-950">{{ $publication->title }}</p>
                                <p class="mt-2 line-clamp-2 text-xs leading-5 text-slate-500">{{ Str::limit($publication->abstract ?: $publication->preview_note ?: $publication->year . ' • ' . number_format($publication->download_count ?? 0, 0, ',', '.') . ' unduhan', 120) }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-slate-500">Tidak ada publikasi yang cocok.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h2 class="text-xl font-bold text-slate-950">Program</h2>
                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">{{ $programs->count() }}</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($programs as $program)
                            <a href="{{ route('programs.show', $program) }}" class="block rounded-xl border border-slate-100 p-4 transition hover:-translate-y-0.5 hover:border-[#0F2868]/30 hover:shadow-md">
                                <p class="text-sm font-bold leading-snug text-slate-950">{{ $program->title }}</p>
                                <p class="mt-2 line-clamp-2 text-xs leading-5 text-slate-500">{{ Str::limit($program->description, 120) }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-slate-500">Tidak ada program yang cocok.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        @endif
    </div>
</section>
@endsection
