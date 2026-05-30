@extends('layouts.app')

@section('title', $publication->title . ' - Research Hub Edulaw')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($publication->abstract ?: $publication->preview_note ?: $publication->title), 155))

@section('content')
@php
    $collectionLabel = $documentTypes[$publication->category] ?? $documentTypes[$publication->document_type] ?? 'Research Publication';
    $languageLabel = $languages[$publication->language] ?? strtoupper($publication->language ?? 'ID');
    $abstract = $publication->abstract
        ?: $publication->preview_note
        ?: 'Publikasi ini disusun sebagai bahan literasi, advokasi, dan pengambilan kebijakan berbasis pengetahuan.';
    $findings = collect($publication->key_findings ?? [])->filter();
    $keywords = collect($publication->keywords ?? [])->filter();
    $citation = $publication->citation
        ?: sprintf(
            'Edulaw Project. (%s). %s. Edulaw Project.%s',
            $publication->year ?: optional($publication->published_at)->format('Y') ?: now()->year,
            $publication->title,
            $publication->doi ? ' https://doi.org/' . $publication->doi : ''
        );
    $smartActions = match ($publication->category ?: $publication->document_type) {
        'constitutional_brief' => ['Pelajari Putusan Terkait', 'Lihat Tafsir Konstitusi'],
        'policy_paper', 'policy_brief' => ['Lihat Rekomendasi Kebijakan', 'Pahami Dampak Regulasi'],
        'toolkit' => ['Gunakan Panduan', 'Mulai Advokasi'],
        'regulatory_review' => ['Bandingkan Regulasi', 'Lihat Potensi Disharmoni'],
        'working_paper' => ['Baca Gagasan Awal', 'Ikuti Pengembangan Riset'],
        default => ['Lihat Konteks Kebijakan', 'Eksplor Isu Hukum'],
    };
@endphp

<main class="bg-gradient-to-b from-slate-50 to-white">
    <section class="border-b border-slate-200 bg-[#071A3D] text-white">
        <div class="container mx-auto grid gap-8 px-6 py-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div class="overflow-hidden rounded-3xl border border-white/15 bg-white/10 p-2 shadow-2xl shadow-black/25">
                @if($publication->file)
                    <iframe
                        src="{{ asset('storage/' . $publication->file) }}#page=1&toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                        title="Cover PDF {{ $publication->title }}"
                        class="aspect-[4/3] w-full rounded-2xl border-0 bg-slate-100"
                    ></iframe>
                @else
                    <div class="flex aspect-[4/3] w-full items-center justify-center rounded-2xl bg-white/10 text-sm font-bold uppercase tracking-[0.2em] text-white/60">
                        Edulaw Research
                    </div>
                @endif
            </div>

            <div>
                <a href="{{ route('research.index') }}" class="mb-5 inline-flex text-sm font-bold text-teal-200 transition hover:text-white">← Kembali ke Research Hub</a>
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-teal-300">Featured Preview</p>
                <h1 class="mt-3 text-4xl font-black leading-tight md:text-5xl">{{ $publication->title }}</h1>
                <p class="mt-5 max-w-3xl text-base leading-8 text-slate-300">{{ $abstract }}</p>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="#preview-pdf" class="rounded-full border border-white/20 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/10">Baca Ringkasan Eksekutif</a>
                    <a href="{{ route('research.download', $publication) }}" target="_blank" class="rounded-full bg-teal-400 px-5 py-3 text-sm font-bold text-slate-950 transition hover:bg-teal-300">Unduh Publikasi</a>
                    <a href="#policy-context" class="rounded-full border border-teal-300/40 px-5 py-3 text-sm font-bold text-teal-100 transition hover:bg-teal-300/10">{{ $smartActions[0] }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto grid gap-8 px-6 py-10 lg:grid-cols-[1fr_360px]">
        <div class="space-y-8">
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="edulaw-eyebrow">Abstract</span>
                <p class="mt-4 text-base leading-8 text-slate-600">{{ $abstract }}</p>
            </section>

            @if($findings->isNotEmpty())
                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="edulaw-eyebrow">Highlight Temuan</span>
                    <div class="mt-5 grid gap-3">
                        @foreach($findings as $finding)
                            <div class="flex gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-teal-500"></span>
                                <p class="text-sm leading-7 text-slate-600">{{ $finding }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section id="preview-pdf" class="scroll-mt-24 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <div>
                        <span class="edulaw-eyebrow">Preview PDF</span>
                        <h2 class="mt-2 text-2xl font-black text-slate-950">Baca ringkasan sebelum mengunduh.</h2>
                    </div>
                    <a href="{{ route('research.download', $publication) }}" target="_blank" class="inline-flex rounded-full bg-[#0F2868] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#071A3D]">Unduh Publikasi</a>
                </div>

                @if($publication->file)
                    <iframe src="{{ asset('storage/' . $publication->file) }}#toolbar=0" class="h-[640px] w-full rounded-2xl border border-slate-200 bg-slate-100"></iframe>
                @else
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-sm font-semibold text-slate-500">
                        File PDF belum tersedia.
                    </div>
                @endif
            </section>

            <section id="policy-context" class="scroll-mt-24 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="edulaw-eyebrow">Konteks Kebijakan</span>
                <h2 class="mt-2 text-2xl font-black text-slate-950">Gunakan dokumen ini sebagai bahan baca, diskusi, dan advokasi.</h2>
                <div class="mt-5 grid gap-3 md:grid-cols-2">
                    @foreach($smartActions as $action)
                        <div class="rounded-2xl border border-teal-100 bg-teal-50/60 p-4 text-sm font-bold text-teal-800">{{ $action }}</div>
                    @endforeach
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-bold text-slate-700">Baca Insight Terkait</div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm font-bold text-slate-700">Dapatkan Update Riset</div>
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-[#071A3D] p-6 text-white shadow-sm">
                <span class="text-xs font-black uppercase tracking-[0.2em] text-teal-300">Gunakan dalam Diskusi dan Advokasi</span>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300">
                    Publikasi Edulaw dapat menjadi bahan awal untuk forum akademik, diskusi publik, dan penyusunan kajian kebijakan.
                </p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('community.index') }}" class="rounded-full bg-teal-400 px-5 py-2.5 text-sm font-bold text-slate-950 transition hover:bg-teal-300">Kolaborasi Riset</a>
                    <a href="{{ route('community.index') }}" class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">Ajukan Topik Kajian</a>
                </div>
            </section>
        </div>

        <aside class="space-y-5">
            <section id="metadata" class="scroll-mt-24 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="edulaw-eyebrow">Metadata</span>
                <dl class="mt-5 grid gap-4 text-sm">
                    <div>
                        <dt class="font-bold text-slate-400">Penulis</dt>
                        <dd class="mt-1 font-semibold text-slate-900">{{ $publication->authors ?: 'Edulaw Research Team' }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Tahun</dt>
                        <dd class="mt-1 font-semibold text-slate-900">{{ $publication->year }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Kategori</dt>
                        <dd class="mt-1 font-semibold text-slate-900">{{ $collectionLabel }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Bahasa</dt>
                        <dd class="mt-1 font-semibold text-slate-900">{{ $languageLabel }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-slate-400">Unduhan</dt>
                        <dd class="mt-1 font-semibold text-slate-900">{{ number_format($publication->download_count ?? 0, 0, ',', '.') }}</dd>
                    </div>
                    @if($publication->doi)
                        <div>
                            <dt class="font-bold text-slate-400">DOI</dt>
                            <dd class="mt-1 break-words font-semibold text-slate-900">{{ $publication->doi }}</dd>
                        </div>
                    @endif
                </dl>
            </section>

            @if($keywords->isNotEmpty())
                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="edulaw-eyebrow">Kata Kunci</span>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($keywords as $keyword)
                            <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-700">#{{ str_replace(' ', '', $keyword) }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="edulaw-eyebrow">Research Actions</span>
                <div class="mt-4 grid gap-2">
                    <a href="#metadata" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-[#0F2868]/30 hover:text-[#0F2868]">Lihat Metadata Lengkap</a>
                    <a href="{{ route('research.citation', $publication) }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-[#0F2868]/30 hover:text-[#0F2868]">Unduh Citation</a>
                    <a href="mailto:?subject={{ rawurlencode($publication->title) }}&body={{ rawurlencode(route('research.show', $publication)) }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-[#0F2868]/30 hover:text-[#0F2868]">Bagikan Publikasi</a>
                    <a href="#policy-context" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-[#0F2868]/30 hover:text-[#0F2868]">Gunakan untuk Diskusi</a>
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="edulaw-eyebrow">Research Impact</span>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-700">Editorially Curated</span>
                    <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-700">Research Snapshot</span>
                    <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-700">Topik Strategis</span>
                    @if(($publication->download_count ?? 0) > 0)
                        <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-700">Most Referenced</span>
                    @endif
                </div>
            </section>

            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="edulaw-eyebrow">Sitasi</span>
                <p class="mt-4 rounded-2xl bg-slate-50 p-4 text-sm leading-7 text-slate-600">{{ $citation }}</p>
                <a href="{{ route('research.citation', $publication) }}" class="mt-4 inline-flex rounded-full border border-[#0F2868]/20 px-4 py-2 text-sm font-bold text-[#0F2868] transition hover:bg-[#0F2868] hover:text-white">Unduh Citation</a>
            </section>
        </aside>
    </section>

    @if($relatedPublications->isNotEmpty())
        <section class="container mx-auto px-6 pb-12">
            <div class="mb-5">
                <span class="edulaw-eyebrow">Research Collection</span>
                <h2 class="mt-2 text-2xl font-black text-slate-950">Kajian Terkait</h2>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach($relatedPublications as $related)
                    <a href="{{ route('research.show', $related) }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#0F2868]/25 hover:shadow-lg">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#0F2868]">{{ $documentTypes[$related->category] ?? $documentTypes[$related->document_type] ?? 'Research' }}</p>
                        <h3 class="mt-3 line-clamp-3 font-bold leading-snug text-slate-950">{{ $related->title }}</h3>
                        <p class="mt-3 text-xs font-semibold text-slate-500">{{ $related->year }} • {{ number_format($related->download_count ?? 0, 0, ',', '.') }} unduhan</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</main>
@endsection
