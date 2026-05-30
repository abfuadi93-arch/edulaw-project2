@extends('layouts.app')

@section('title', 'Beranda - Edulaw Project')

@section('content')
@php
    $fallbackHeroSlides = collect([
        [
            'title' => 'Ruang kerja riset hukum',
            'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1000&q=85',
        ],
        [
            'title' => 'Diskusi hukum dan kebijakan',
            'image' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1000&q=85',
        ],
        [
            'title' => 'Kajian publik dan pendidikan hukum',
            'image' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1000&q=85',
        ],
    ]);
    $heroSlides = $heroSlides->isNotEmpty() ? $heroSlides : $fallbackHeroSlides;
@endphp

<style>
    @keyframes heroKenBurns {
        0% { transform: scale(1); }
        100% { transform: scale(1.06); }
    }

    [data-hero-slide].opacity-100 {
        animation: heroKenBurns 7s ease-out forwards;
    }
</style>

<section class="relative min-h-[calc(100svh-88px)] overflow-hidden bg-edulaw-dark text-white">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(20,184,166,.20),transparent_34%),linear-gradient(135deg,rgba(7,26,61,1),rgba(15,40,104,.92))]"></div>
    <div class="container relative z-10 mx-auto flex min-h-[calc(100svh-88px)] flex-col justify-center px-6 py-10 md:py-12 lg:py-10">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1fr_0.9fr] lg:items-center">
            <div class="max-w-3xl">
                <span class="mb-3 inline-flex rounded-full border border-teal-300/20 bg-teal-300/10 px-3.5 py-1.5 text-[11px] font-bold uppercase tracking-widest text-teal-100">
                    Legal Knowledge Ecosystem
                </span>
                <h1 class="max-w-3xl text-3xl font-black leading-[1.08] md:text-4xl xl:text-5xl">
                    Ruang Literasi Hukum, Konstitusi, dan Kebijakan Publik
                </h1>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300 md:text-[15px]">
                    Platform edukasi hukum yang menghubungkan literasi konstitusi, riset berbasis data, telaah akademik, dan advokasi kebijakan publik. Edulaw menghadirkan insight, publikasi, dan program pembelajaran untuk membantu mahasiswa, profesional, komunitas, dan pembuat kebijakan memahami hukum secara kritis, terukur, dan kontekstual.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('programs.index') }}" class="rounded-md border border-white/25 px-4 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:border-white/45 hover:bg-white/10">Lihat Program</a>
                    <a href="{{ route('insights.index') }}" class="rounded-md border border-white/25 px-4 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:border-white/45 hover:bg-white/10">Baca Insight</a>
                    <a href="{{ route('research.index') }}" class="rounded-md border border-white/25 px-4 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:border-white/45 hover:bg-white/10">Jelajahi Research Hub</a>
                </div>
            </div>

            <div class="relative">
                <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-white/10 p-2 shadow-2xl shadow-black/25" data-hero-slider>
                    @foreach($heroSlides->take(5) as $slide)
                        @php
                            $slideImage = is_array($slide)
                                ? $slide['image']
                                : asset('storage/' . $slide->image);
                            $slideTitle = is_array($slide)
                                ? $slide['title']
                                : $slide->title;
                        @endphp
                        <img
                            src="{{ $slideImage }}"
                            alt="{{ $slideTitle }}"
                            class="{{ $loop->first ? 'opacity-100' : 'opacity-0' }} absolute inset-2 h-[280px] w-[calc(100%-1rem)] rounded-2xl object-cover transition-opacity duration-1000 md:h-[360px] xl:h-[420px]"
                            data-hero-slide
                        >
                    @endforeach

                    <div class="pointer-events-none absolute inset-2 rounded-2xl bg-gradient-to-t from-[#071A3D]/70 via-[#071A3D]/10 to-white/5"></div>
                    <div class="h-[280px] md:h-[360px] xl:h-[420px]"></div>
                    <div class="absolute right-5 top-5 flex gap-2">
                        @foreach($heroSlides->take(5) as $slide)
                            <button
                                type="button"
                                class="{{ $loop->first ? 'w-6 bg-white' : 'w-2 bg-white/45' }} h-2 rounded-full transition-all"
                                data-hero-dot
                                aria-label="Slide {{ $loop->iteration }}"
                            ></button>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-8">
            <div class="mb-3">
                <span class="text-xs font-bold uppercase tracking-widest text-white/85">Siapa yang Kami Layani</span>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div class="flex items-start gap-3 rounded-lg border border-white/15 bg-white/[.075] p-3 shadow-lg shadow-black/5 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-teal-200/35 hover:bg-white/[.105]">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-teal-200/20 bg-teal-300/10 text-teal-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14 3 9l9-5 9 5-9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 11v5c2 2 12 2 14 0v-5"/></svg>
                    </div>
                    <div>
                        <h3 class="mb-1 text-sm font-bold text-white">Mahasiswa Hukum</h3>
                        <p class="text-xs leading-5 text-slate-300">Materi pendamping kuliah dan persiapan karier.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-lg border border-white/15 bg-white/[.075] p-3 shadow-lg shadow-black/5 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-amber-200/35 hover:bg-white/[.105]">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-amber-200/20 bg-amber-300/10 text-amber-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v18M6 6h12M7 6l-4 7h8L7 6zm10 0-4 7h8l-4-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="mb-1 text-sm font-bold text-white">Profesional</h3>
                        <p class="text-xs leading-5 text-slate-300">Update regulasi dan pelatihan sertifikasi.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-lg border border-white/15 bg-white/[.075] p-3 shadow-lg shadow-black/5 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-sky-200/35 hover:bg-white/[.105]">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-sky-200/20 bg-sky-300/10 text-sky-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11a4 4 0 1 0-8 0m8 0a4 4 0 1 1-8 0m8 0h1a4 4 0 0 1 4 4v2M8 11H7a4 4 0 0 0-4 4v2m5 0h8"/></svg>
                    </div>
                    <div>
                        <h3 class="mb-1 text-sm font-bold text-white">Masyarakat</h3>
                        <p class="text-xs leading-5 text-slate-300">Pengetahuan hukum praktis sehari-hari.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-lg border border-white/15 bg-white/[.075] p-3 shadow-lg shadow-black/5 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-rose-200/35 hover:bg-white/[.105]">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-rose-200/20 bg-rose-300/10 text-rose-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V9m14 12V9M4 9l8-5 8 5M8 12v5m4-5v5m4-5v5"/></svg>
                    </div>
                    <div>
                        <h3 class="mb-1 text-sm font-bold text-white">Pembuat Kebijakan</h3>
                        <p class="text-xs leading-5 text-slate-300">Riset data untuk perumusan kebijakan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const heroSlider = document.querySelector('[data-hero-slider]');

    if (heroSlider) {
        const slides = [...heroSlider.querySelectorAll('[data-hero-slide]')];
        const dots = [...heroSlider.querySelectorAll('[data-hero-dot]')];
        let activeSlide = 0;

        const showSlide = (index) => {
            activeSlide = index;

            slides.forEach((slide, slideIndex) => {
                slide.classList.toggle('opacity-100', slideIndex === index);
                slide.classList.toggle('opacity-0', slideIndex !== index);
            });

            dots.forEach((dot, dotIndex) => {
                dot.classList.toggle('w-6', dotIndex === index);
                dot.classList.toggle('w-2', dotIndex !== index);
                dot.classList.toggle('bg-white', dotIndex === index);
                dot.classList.toggle('bg-white/45', dotIndex !== index);
            });
        };

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });

        if (slides.length > 1) {
            setInterval(() => showSlide((activeSlide + 1) % slides.length), 4500);
        }
    }
</script>

 <section class="py-8 bg-gradient-to-b from-slate-50 to-white">
        <div class="container mx-auto px-6">
            @php
                $programFormats = ['Semua', 'Online', 'Offline', 'Hybrid'];
            @endphp
            
            <div class="flex flex-col gap-3 md:flex-row md:justify-between md:items-end mb-4">
                <div class="max-w-3xl">
                    <span class="text-edulaw-blue font-bold uppercase text-xs tracking-widest">Program</span>
                    <h2 class="mt-1 text-2xl font-bold text-slate-900 leading-tight">Program Edulaw</h2>
                    <p class="text-slate-600 text-sm mt-1.5 leading-relaxed">Pilih ruang belajar yang sesuai dengan kebutuhanmu.</p>
                </div>
                <div class="flex flex-wrap gap-2 text-[11px] font-semibold text-slate-500">
                    @foreach($programFormats as $format)
                        <button type="button" data-program-filter="{{ $format }}" class="program-filter rounded-full border px-3 py-1 transition {{ $loop->first ? 'border-[#0F2868] bg-[#0F2868] text-white' : 'border-slate-200 bg-white text-slate-500 hover:border-[#0F2868]/40 hover:text-[#0F2868]' }}">{{ $format }}</button>
                    @endforeach
                </div>
            </div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                
                @foreach($programs as $program)
                @php
                    $displayTitle = $program->short_title ?: $program->title;
                    $programTone = match(($loop->iteration - 1) % 4) {
                        0 => [
                            'card' => 'from-teal-50/90 to-white border-teal-100 hover:border-teal-300',
                            'box' => 'from-teal-100 to-white border-teal-200 text-teal-700',
                            'badge' => 'bg-teal-100 text-teal-800',
                            'dot' => 'bg-teal-500',
                            'outline' => 'border-teal-500/40 text-teal-700 hover:bg-teal-50',
                        ],
                        1 => [
                            'card' => 'from-amber-50/90 to-white border-amber-100 hover:border-amber-300',
                            'box' => 'from-amber-100 to-white border-amber-200 text-amber-700',
                            'badge' => 'bg-amber-100 text-amber-800',
                            'dot' => 'bg-amber-500',
                            'outline' => 'border-amber-500/40 text-amber-700 hover:bg-amber-50',
                        ],
                        2 => [
                            'card' => 'from-sky-50/90 to-white border-sky-100 hover:border-sky-300',
                            'box' => 'from-sky-100 to-white border-sky-200 text-sky-700',
                            'badge' => 'bg-sky-100 text-sky-800',
                            'dot' => 'bg-sky-500',
                            'outline' => 'border-sky-500/40 text-sky-700 hover:bg-sky-50',
                        ],
                        default => [
                            'card' => 'from-rose-50/90 to-white border-rose-100 hover:border-rose-300',
                            'box' => 'from-rose-100 to-white border-rose-200 text-rose-700',
                            'badge' => 'bg-rose-100 text-rose-800',
                            'dot' => 'bg-rose-500',
                            'outline' => 'border-rose-500/40 text-rose-700 hover:bg-rose-50',
                        ],
                    };
                @endphp
                <div data-program-card="{{ $program->format ?? 'Online' }}" class="program-card p-4 bg-gradient-to-br {{ $programTone['card'] }} border rounded-xl hover:shadow-md transition duration-300 flex flex-col">
                    <div class="flex items-start gap-3 mb-2.5">
                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br {{ $programTone['box'] }} border flex items-center justify-center overflow-hidden shrink-0">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-sm font-bold">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-lg font-bold text-slate-900 leading-tight">{{ $displayTitle }}</h3>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $programTone['badge'] }}">{{ $program->program_type ?: ($program->format ?? 'Online') }}</span>
                                @if($program->program_family)
                                    <span class="inline-flex items-center rounded-full bg-white px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500 ring-1 ring-slate-200">{{ $program->program_family }}</span>
                                @endif
                            </div>
                            @if($program->subtitle)
                                <p class="mt-1 text-xs font-semibold leading-4 text-slate-500">{{ $program->subtitle }}</p>
                            @endif
                        </div>
                    </div>

                    <p class="text-sm text-slate-600 leading-relaxed mb-3">
                        {{ $program->description }}
                    </p>

                    <ul class="space-y-1.5 text-sm text-slate-600 mb-3">
                        @foreach(array_slice($program->highlights ?? [], 0, 3) as $point)
                            <li class="flex gap-2.5 leading-snug"><span class="mt-1.5 h-1.5 w-1.5 rounded-full {{ $programTone['dot'] }} shrink-0"></span><span>{{ $point }}</span></li>
                        @endforeach
                    </ul>

                    <div class="mt-auto">
                        <div class="flex flex-wrap gap-x-3 gap-y-1 mb-3 border-t border-slate-100 pt-2.5 text-[11px] font-medium text-slate-500">
                            <span>Durasi • {{ $program->duration ?? '4 Pertemuan' }}</span>
                            <span>Format • {{ $program->format ?? 'Online' }}</span>
                            <span>Level • {{ $program->level ?? 'Intermediate' }}</span>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('programs.show', $program) }}" class="inline-flex items-center rounded-md bg-[#0F2868] px-3 py-2 text-[11px] font-bold uppercase tracking-wide text-white hover:bg-[#0B1F4D] transition">
                                Lihat Detail
                            </a>
                            <a href="#" class="inline-flex items-center rounded-md border px-3 py-2 text-[11px] font-bold uppercase tracking-wide transition {{ $programTone['outline'] }}">
                                Diskusikan Kebutuhan
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <div class="mt-5 flex items-center gap-4">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-[#0F2868]/35 to-[#0F2868]/60"></div>
                <a href="{{ route('programs.index') }}" class="inline-flex items-center whitespace-nowrap rounded-full border border-[#0F2868]/20 bg-white px-4 py-2 text-sm font-bold text-edulaw-blue hover:bg-[#0F2868]/5">
                    Lihat Program
                </a>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent via-[#0F2868]/35 to-[#0F2868]/60"></div>
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('[data-program-filter]').forEach((button) => {
            button.addEventListener('click', () => {
                const selected = button.dataset.programFilter;

                document.querySelectorAll('[data-program-filter]').forEach((item) => {
                    const active = item === button;
                    item.classList.toggle('border-[#0F2868]', active);
                    item.classList.toggle('bg-[#0F2868]', active);
                    item.classList.toggle('text-white', active);
                    item.classList.toggle('border-slate-200', !active);
                    item.classList.toggle('bg-white', !active);
                    item.classList.toggle('text-slate-500', !active);
                });

                document.querySelectorAll('[data-program-card]').forEach((card) => {
                    card.classList.toggle('hidden', selected !== 'Semua' && card.dataset.programCard !== selected);
                });
            });
        });
    </script>

<section class="py-10 bg-[#FFFDF8] border-y border-amber-100">
        <div class="container mx-auto px-6">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-6">
                <div class="max-w-2xl">
                    <span class="text-edulaw-blue font-bold uppercase text-xs tracking-widest">Editorial</span>
                    <h2 class="mt-1 text-2xl font-bold text-slate-900">Edulaw Insight</h2>
                    <p class="text-slate-500 text-sm mt-2 leading-relaxed">Esai, opini, dan catatan analitis tentang hukum, konstitusi, demokrasi, serta kebijakan publik.</p>
                </div>
                <a href="{{ route('insights.index') }}" class="hidden md:inline-block border border-slate-300 text-slate-700 px-4 py-2 rounded-md text-xs font-bold hover:border-slate-900 hover:text-slate-900 transition mt-2 md:mt-0">
                    Baca Insight
                </a>
            </div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                
                {{-- Mulai Looping --}}
                @foreach($insights as $insight)
                @php
                    $insightImage = $insight->thumbnail ?: $insight->image;
                    $insightAuthor = $insight->author_name ?: ($insight->author?->name ?: ($insight->author ?: 'Edulaw Project'));
                    $insightDate = $insight->published_at ?? $insight->created_at;
                    $readingMinutes = max(1, (int) ceil(str_word_count(strip_tags($insight->content ?? '')) / 200));
                @endphp
                <article class="group flex h-full flex-col overflow-hidden rounded-xl border border-amber-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1.5 hover:border-amber-300 hover:shadow-xl hover:shadow-amber-100/70">
                    <div class="relative h-36 w-full overflow-hidden bg-slate-100">
                        @if($insightImage)
                            <img src="{{ asset('storage/' . $insightImage) }}" 
                                 alt="{{ $insight->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-[#0F2868]/10 to-teal-100 text-xs font-bold uppercase tracking-widest text-[#0F2868]">
                                Edulaw Insight
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-1 flex-col p-4">
                        <div class="mb-2 flex flex-wrap items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <span class="text-edulaw-blue">{{ $insight->category?->name ?: 'Insight' }}</span>
                            @if($insight->topic_label)
                                <span>•</span>
                                <span>{{ $insight->topic_label }}</span>
                            @endif
                            <span>•</span>
                            <span>{{ \Carbon\Carbon::parse($insightDate)->translatedFormat('d M Y') }}</span>
                        </div>
                        <h3 class="text-base font-bold leading-snug text-slate-950">
                            <a href="{{ route('insight.show', $insight->slug) }}" class="hover:text-edulaw-blue transition">{{ $insight->title }}</a>
                        </h3>

                        <div class="mt-auto pt-4">
                            <div class="mb-3 text-[11px] font-semibold text-slate-400">{{ $insightAuthor }} • ± {{ $readingMinutes }} menit baca</div>
                            <a href="{{ route('insight.show', $insight->slug) }}" class="inline-flex rounded-md bg-[#0F2868] px-3 py-2 text-[10px] font-bold uppercase tracking-wide text-white transition hover:-translate-y-0.5 hover:bg-[#0B1F4D] hover:shadow-lg hover:shadow-[#0F2868]/15">
                                Baca Insight
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach

            </div>

            <div class="mt-8 md:hidden">
                <a href="{{ route('insights.index') }}" class="inline-flex rounded-md border border-slate-300 px-4 py-2 text-xs font-bold text-slate-700">Baca Insight</a>
            </div>
        </div>
    </section>

<section id="research" class="py-12 bg-gradient-to-b from-slate-50 to-sky-50/50">
        <div class="container mx-auto px-6">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-6">
                <div class="max-w-2xl">
                    <span class="text-edulaw-blue font-bold uppercase text-xs tracking-widest">Perpustakaan Digital</span>
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Riset & Publikasi</h2>
                    <p class="text-slate-500">
                        Unduh kajian terbaru, policy brief, dan laporan riset kami secara gratis.
                    </p>
                </div>
                <a href="{{ route('research.index') }}" class="hidden md:inline-block font-bold text-[#0F2868] border-b-2 border-[#0F2868] pb-1 hover:text-[#0B1F4D] hover:border-[#0B1F4D] transition mt-4 md:mt-0">
                    Pelajari Riset
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="rounded-xl border border-teal-100 bg-teal-50/70 p-4 shadow-sm shadow-slate-200/60">
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <div class="text-xs font-bold uppercase tracking-widest text-slate-500">Total Unduhan</div>
                        <div class="h-9 w-9 rounded-lg border border-teal-200 bg-white flex items-center justify-center text-teal-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v12m0 0 4-4m-4 4-4-4M4 17v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1"/></svg>
                        </div>
                    </div>
                    <div class="text-4xl font-bold text-slate-950">{{ number_format($totalResearchDownloads ?? 0, 0, ',', '.') }}</div>
                    <p class="mt-2 text-sm text-slate-500">Akumulasi unduhan publikasi.</p>
                </div>

                <div class="rounded-xl border border-amber-100 bg-amber-50/70 p-4 shadow-sm shadow-slate-200/60">
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <div class="text-xs font-bold uppercase tracking-widest text-slate-500">Dokumen Tersedia</div>
                        <div class="h-9 w-9 rounded-lg border border-amber-200 bg-white flex items-center justify-center text-amber-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v5h5"/></svg>
                        </div>
                    </div>
                    <div class="text-4xl font-bold text-slate-950">{{ $totalResearchDocuments ?? $researches->count() }}</div>
                    <p class="mt-2 text-sm text-slate-500">Policy brief, riset, dan toolkit.</p>
                </div>

                <div class="rounded-xl border border-sky-100 bg-sky-50/70 p-4 shadow-sm shadow-slate-200/60 md:col-span-2">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="h-9 w-9 shrink-0 rounded-lg border border-sky-200 bg-white flex items-center justify-center text-sky-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.8 1-6.1-4.4-4.3 6.1-.9L12 3z"/></svg>
                                </div>
                                <div class="text-xs font-bold uppercase tracking-widest text-slate-500">Terpopuler (30 hari)</div>
                            </div>
                            <div class="text-base font-bold leading-snug text-slate-950 line-clamp-2">
                                "{{ $popularResearchThisMonth?->title ?? 'Perlindungan Hak Konstitusional Masyarakat Pesisir: Urgensi Harmonisasi Regulasi Pengelolaan Pesisir Terpadu' }}"
                            </div>
                            <p class="mt-1.5 text-sm text-slate-500">Publikasi dengan unduhan tertinggi.</p>
                        </div>
                        <a href="{{ route('research.index') }}" class="hidden shrink-0 rounded-full bg-white px-4 py-2 text-xs font-bold text-[#0F2868] ring-1 ring-sky-200 transition hover:bg-[#0F2868] hover:text-white md:inline-flex">
                            Lihat Publikasi
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                {{-- Mulai Looping Riset --}}
                @foreach($researches as $item)
                <div class="group bg-white p-4 rounded-lg border border-slate-200 transition duration-300 hover:-translate-y-1 hover:border-[#0F2868]/30 hover:shadow-xl hover:shadow-slate-200/70 flex gap-4 items-center">
                    
                    <div class="w-16 h-20 flex-shrink-0 bg-slate-100 rounded-lg overflow-hidden flex items-center justify-center border border-slate-100">
                        @if($item->file)
                            <iframe
                                src="{{ asset('storage/' . $item->file) }}#page=1&toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                                title="Cover PDF {{ $item->title }}"
                                class="h-full w-full border-0 bg-slate-100 pointer-events-none"
                                loading="lazy"
                            ></iframe>
                        @else
                            <svg class="w-8 h-8 text-[#0F2868]" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" /><path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" /></svg>
                        @endif
                    </div>

                    <div class="flex-grow">
                        <div class="text-xs font-bold text-slate-400 mb-1">{{ $item->year }}</div>
                        <h3 class="font-bold text-slate-900 mb-2 leading-snug group-hover:text-edulaw-blue transition">
                            {{ $item->title }}
                        </h3>
                        
                        <a href="{{ route('research.download', $item) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-slate-900 transition hover:translate-x-0.5 hover:text-edulaw-blue">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Publikasi
                        </a>
                    </div>
                </div>
                @endforeach
                {{-- Akhir Looping --}}

            </div>

        </div>
    </section>

@if($testimonials->isNotEmpty())
<section class="py-8 bg-gradient-to-b from-white to-teal-50/40 border-t border-slate-200">
        <div class="container mx-auto px-6">
            
            <div class="text-center mb-5">
                <h2 class="text-2xl font-bold text-slate-900">Kata Komunitas Kami</h2>
                <p class="text-slate-500 text-sm mt-1">Pengalaman rekan-rekan yang telah bergabung.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($testimonials as $testimonial)
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100 relative flex flex-col justify-between">
                        <div class="text-edulaw-blue text-4xl absolute top-3 left-4 opacity-20">"</div>
                        <p class="text-slate-600 italic mb-6 relative z-10 pt-2 text-sm leading-relaxed">
                            "{{ $testimonial->content }}"
                        </p>
                        <div class="flex items-center pt-4 border-t border-slate-50">
                            @if($testimonial->avatar)
                                <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="w-10 h-10 rounded-full mr-3 object-cover border border-slate-100">
                            @else
                                <div class="w-10 h-10 rounded-full mr-3 bg-edulaw-blue/10 text-edulaw-blue border border-slate-100 flex items-center justify-center text-sm font-bold">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $testimonial->name }}</h4>
                                @if($testimonial->role)
                                    <p class="text-xs text-slate-500">{{ $testimonial->role }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endif

<section class="py-8 bg-white">
        <div class="container mx-auto px-6">
            
            <div class="rounded-xl border border-[#0F2868]/20 bg-edulaw-dark p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="md:w-2/3">
                    <span class="inline-block bg-white/10 text-slate-200 text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4 border border-white/10">
                        Open Collaboration
                    </span>
                    
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-3 leading-tight">
                        Gabung sebagai Penulis / Kolaborator
                    </h2>
                    
                    <p class="text-slate-300 text-sm leading-relaxed max-w-2xl">
                        Edulaw membuka ruang opini eksternal yang plural. Seluruh tulisan merupakan opini pribadi penulis, proses editorial dilakukan untuk menjaga akurasi, relevansi, etika, dan kualitas argumentasi.
                    </p>
                </div>

                <div class="md:w-1/3 flex flex-col gap-3 w-full">
                    <a href="{{ route('community.index') }}" class="block w-full bg-white text-[#0F2868] text-center font-bold py-3.5 rounded-lg hover:bg-slate-100 transition">
                        Kirim Opini
                    </a>
                    
                    <a href="{{ url('/admin/register') }}" class="block w-full border border-white/20 text-white text-center font-bold py-3.5 rounded-lg hover:bg-white/10 transition">
                        Daftar Contributor
                    </a>
                </div>

            </div>
        </div>
    </section>
@endsection
