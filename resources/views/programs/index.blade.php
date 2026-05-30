@extends('layouts.app')
@section('title', 'Program Edulaw - Edulaw Project')

@section('content')
@php
    $activeItems = collect($activePrograms ?? []);
    $portfolioItems = collect($portfolioPrograms ?? []);
    $allItems = $activeItems->concat($portfolioItems);
    $families = $allItems->pluck('program_family')->filter()->unique()->values();
    $formats = $allItems->pluck('format')->filter()->unique()->values();
    $levels = $allItems->pluck('level')->filter()->unique()->values();
    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $periodLabel = function ($program) use ($monthNames) {
        if (! $program->start_date || ! $program->end_date) {
            return 'Periode terdokumentasi';
        }

        $start = $monthNames[(int) $program->start_date->format('n')] . ' ' . $program->start_date->format('Y');
        $end = $monthNames[(int) $program->end_date->format('n')] . ' ' . $program->end_date->format('Y');

        return $start === $end ? $start : "{$start} — {$end}";
    };

    $programStatus = function ($program) {
        $today = now()->toDateString();

        if ($program->start_date && $program->end_date && $program->start_date->toDateString() <= $today && $program->end_date->toDateString() >= $today) {
            return 'Berjalan';
        }

        if ($program->start_date && $program->start_date->toDateString() > $today) {
            return 'Terjadwal';
        }

        return 'Portofolio';
    };

    $tones = [
        [
            'card' => 'border-teal-200 bg-gradient-to-r from-teal-50/90 to-white hover:border-teal-300',
            'media' => 'bg-teal-50 text-teal-700',
            'eyebrow' => 'text-teal-700',
            'badge' => 'bg-teal-100 text-teal-800',
            'button' => 'bg-teal-600 hover:bg-teal-700',
            'outline' => 'border-teal-500/35 text-teal-700 hover:bg-teal-50',
        ],
        [
            'card' => 'border-amber-200 bg-gradient-to-r from-amber-50/90 to-white hover:border-amber-300',
            'media' => 'bg-amber-50 text-amber-700',
            'eyebrow' => 'text-amber-700',
            'badge' => 'bg-amber-100 text-amber-800',
            'button' => 'bg-amber-600 hover:bg-amber-700',
            'outline' => 'border-amber-500/35 text-amber-700 hover:bg-amber-50',
        ],
        [
            'card' => 'border-sky-200 bg-gradient-to-r from-sky-50/90 to-white hover:border-sky-300',
            'media' => 'bg-sky-50 text-sky-700',
            'eyebrow' => 'text-sky-700',
            'badge' => 'bg-sky-100 text-sky-800',
            'button' => 'bg-sky-700 hover:bg-sky-800',
            'outline' => 'border-sky-500/35 text-sky-700 hover:bg-sky-50',
        ],
        [
            'card' => 'border-rose-200 bg-gradient-to-r from-rose-50/90 to-white hover:border-rose-300',
            'media' => 'bg-rose-50 text-rose-700',
            'eyebrow' => 'text-rose-700',
            'badge' => 'bg-rose-100 text-rose-800',
            'button' => 'bg-rose-700 hover:bg-rose-800',
            'outline' => 'border-rose-500/35 text-rose-700 hover:bg-rose-50',
        ],
    ];
@endphp

<section class="border-b border-slate-200 bg-white">
    <div class="container mx-auto flex flex-col gap-6 px-6 py-9 md:py-11 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <span class="edulaw-eyebrow">Program</span>
            <h1 class="mt-2 max-w-3xl text-4xl font-black leading-tight text-slate-950 md:text-5xl">
                Program Edulaw
            </h1>
            <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">
                Program Edulaw Project dirancang sebagai ruang belajar, diskusi, riset, dan kolaborasi untuk memperkuat literasi hukum publik. Berangkat dari nilai Equal, Educative, dan Embrace, setiap kegiatan diarahkan untuk membuka akses pengetahuan hukum yang setara, menghadirkan pembelajaran yang bermakna, serta merangkul berbagai pihak dalam ekosistem hukum yang kritis dan humanis.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-7 border-t border-slate-200 pt-5 lg:min-w-[320px] lg:border-l lg:border-t-0 lg:pl-8 lg:pt-0">
            <div>
                <p class="text-3xl font-black leading-none text-slate-950">{{ number_format($activeItems->count(), 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-black uppercase tracking-[0.16em] text-slate-500">Program Aktif</p>
            </div>
            <div>
                <p class="text-3xl font-black leading-none text-slate-950">{{ number_format($portfolioItems->count(), 0, ',', '.') }}</p>
                <p class="mt-2 text-xs font-black uppercase tracking-[0.16em] text-slate-500">Portofolio</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-50 py-7 md:py-9">
    <div class="container mx-auto grid gap-6 px-6 lg:grid-cols-[230px_1fr]">
        <aside class="lg:sticky lg:top-24 lg:self-start">
            <div class="border-t border-slate-200 pt-4">
                <div class="mb-5 flex items-center justify-between gap-4">
                    <p class="edulaw-eyebrow">Filter Program</p>
                    <button type="button" data-program-reset class="text-xs font-bold text-slate-500 transition hover:text-[#0F2868]">Reset</button>
                </div>

                <div class="space-y-6">
                    <div>
                        <h2 class="mb-3 text-sm font-black text-slate-950">Rumpun</h2>
                        <div class="space-y-2 text-sm font-semibold text-slate-600">
                            @forelse($families as $family)
                                <label class="flex cursor-pointer items-center gap-3">
                                    <input type="checkbox" value="{{ $family }}" data-program-family-filter class="h-4 w-4 rounded border-slate-300 text-[#0F2868] focus:ring-[#0F2868]">
                                    <span>{{ $family }}</span>
                                </label>
                            @empty
                                <p class="text-xs text-slate-400">Semua rumpun tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h2 class="mb-3 text-sm font-black text-slate-950">Kategori</h2>
                        <div class="space-y-2 text-sm font-semibold text-slate-600">
                            <label class="flex cursor-pointer items-center gap-3">
                                <input type="checkbox" value="active" data-program-lifecycle-filter class="h-4 w-4 rounded border-slate-300 text-[#0F2868] focus:ring-[#0F2868]">
                                <span>Program Aktif</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-3">
                                <input type="checkbox" value="portfolio" data-program-lifecycle-filter class="h-4 w-4 rounded border-slate-300 text-[#0F2868] focus:ring-[#0F2868]">
                                <span>Portofolio</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <h2 class="mb-3 text-sm font-black text-slate-950">Format</h2>
                        <div class="space-y-2 text-sm font-semibold text-slate-600">
                            @forelse($formats as $format)
                                <label class="flex cursor-pointer items-center gap-3">
                                    <input type="checkbox" value="{{ $format }}" data-program-format-filter class="h-4 w-4 rounded border-slate-300 text-[#0F2868] focus:ring-[#0F2868]">
                                    <span>{{ $format }}</span>
                                </label>
                            @empty
                                <p class="text-xs text-slate-400">Semua format tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h2 class="mb-3 text-sm font-black text-slate-950">Level</h2>
                        <div class="space-y-2 text-sm font-semibold text-slate-600">
                            @forelse($levels as $level)
                                <label class="flex cursor-pointer items-center gap-3">
                                    <input type="checkbox" value="{{ $level }}" data-program-level-filter class="h-4 w-4 rounded border-slate-300 text-[#0F2868] focus:ring-[#0F2868]">
                                    <span>{{ $level }}</span>
                                </label>
                            @empty
                                <p class="text-xs text-slate-400">Semua level tersedia.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <main>
            <div class="mb-5">
                <div>
                    <span class="edulaw-eyebrow">Program Aktif</span>
                    <p class="mt-2 w-full text-sm leading-6 text-slate-500">
                        Inisiatif pembelajaran, riset, publikasi, dan kolaborasi pelatihan yang sedang berjalan atau telah terjadwal.
                    </p>
                </div>
            </div>

            <div class="space-y-4" data-program-list>
                @forelse($activeItems as $program)
                    @php
                        $tone = $tones[($loop->iteration - 1) % count($tones)];
                        $format = $program->format ?: 'Program';
                        $level = $program->level ?: 'Terbuka';
                        $duration = $program->duration ?: 'Fleksibel';
                        $displayTitle = $program->short_title ?: $program->title;
                        $highlights = collect($program->highlights ?? [])->filter()->take(3);
                    @endphp

                    <article
                        class="program-card grid gap-4 border p-3.5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg md:grid-cols-[190px_1fr_174px] {{ $tone['card'] }}"
                        data-program-card
                        data-program-lifecycle="active"
                        data-program-family="{{ $program->program_family }}"
                        data-program-format="{{ $format }}"
                        data-program-level="{{ $level }}"
                    >
                        <a href="{{ route('programs.show', $program) }}" class="block aspect-[4/3] overflow-hidden {{ $tone['media'] }}">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="h-full w-full object-cover transition duration-700 hover:scale-105">
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center gap-2 text-xs font-black uppercase tracking-[0.2em]">
                                    <span class="text-2xl tracking-normal">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span>Edulaw</span>
                                </div>
                            @endif
                        </a>

                        <div class="min-w-0">
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <h3 class="text-xl font-black leading-snug text-slate-950">
                                    <a href="{{ route('programs.show', $program) }}" class="transition hover:text-[#0F2868]">
                                        {{ $displayTitle }}
                                    </a>
                                </h3>
                                <span class="rounded-full px-2 py-0.5 {{ $tone['badge'] }}">{{ $program->program_type ?: $format }}</span>
                                @if($program->program_family)
                                    <span class="rounded-full bg-white px-2 py-0.5 text-[11px] font-black text-slate-500 ring-1 ring-slate-200">{{ $program->program_family }}</span>
                                @endif
                            </div>

                            @if($program->subtitle)
                                <p class="mb-2 text-sm font-bold leading-5 text-slate-700">{{ $program->subtitle }}</p>
                            @endif

                            <p class="text-sm leading-5 text-slate-600">
                                {{ $program->description }}
                            </p>

                            @if($highlights->isNotEmpty())
                                <ul class="mt-3 space-y-1.5 text-sm leading-5 text-slate-600">
                                    @foreach($highlights as $point)
                                        <li class="flex gap-2">
                                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full {{ $tone['button'] }}"></span>
                                            <span>{{ $point }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="flex flex-col gap-3 md:items-stretch">
                            <div class="space-y-1.5 text-sm font-semibold text-slate-700">
                                <p><span class="font-black text-slate-500">Durasi</span> <span class="text-slate-400">•</span> {{ $duration }}</p>
                                <p><span class="font-black text-slate-500">Format</span> <span class="text-slate-400">•</span> {{ $format }}</p>
                                <p><span class="font-black text-slate-500">Level</span> <span class="text-slate-400">•</span> {{ $level }}</p>
                            </div>

                            <a href="{{ route('programs.show', $program) }}" class="inline-flex justify-center rounded-md px-4 py-2.5 text-xs font-black uppercase tracking-wide text-white transition {{ $tone['button'] }}">
                                Lihat Detail
                            </a>
                            <a href="https://wa.me/6281529927677?text={{ rawurlencode('Halo Edulaw Project, saya ingin mendiskusikan kebutuhan program ' . $program->title . '.') }}" target="_blank" rel="noopener" class="inline-flex justify-center whitespace-nowrap rounded-md border px-3 py-2.5 text-center text-xs font-black uppercase tracking-normal transition {{ $tone['outline'] }}">
                                Diskusikan Kebutuhan
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="border border-dashed border-slate-300 bg-white p-8">
                        <h3 class="text-xl font-black text-slate-950">Belum ada program aktif</h3>
                        <p class="mt-2 text-sm text-slate-500">Program dengan periode berjalan atau terjadwal akan tampil di sini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 border-t border-slate-200 pt-6">
                <div class="mb-4">
                    <span class="edulaw-eyebrow">Portofolio Edulaw</span>
                    <p class="mt-2 w-full text-sm leading-6 text-slate-500">
                        Dokumentasi program, kolaborasi, dan pengembangan komunitas yang telah dijalankan Edulaw Project.
                    </p>
                </div>

                <div class="space-y-4">
                    @forelse($portfolioItems as $program)
                        @php
                            $tone = $tones[($loop->iteration + $activeItems->count() - 1) % count($tones)];
                            $format = $program->format ?: 'Archive';
                            $level = $program->level ?: 'Terbuka';
                            $duration = $program->duration ?: 'Fleksibel';
                            $displayTitle = $program->short_title ?: $program->title;
                            $highlights = collect($program->highlights ?? [])->filter()->take(3);
                        @endphp

                        <article
                            class="program-card grid gap-4 border p-3.5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md md:grid-cols-[170px_1fr_150px] {{ $tone['card'] }}"
                            data-program-card
                            data-program-lifecycle="portfolio"
                            data-program-family="{{ $program->program_family }}"
                            data-program-format="{{ $format }}"
                            data-program-level="{{ $level }}"
                        >
                            <a href="{{ route('programs.show', $program) }}" class="block aspect-[4/3] overflow-hidden {{ $tone['media'] }}">
                                @if($program->image)
                                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="h-full w-full object-cover transition duration-700 hover:scale-105">
                                @else
                                    <div class="flex h-full w-full flex-col items-center justify-center gap-2 text-xs font-black uppercase tracking-[0.2em]">
                                        <span class="text-2xl tracking-normal">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span>Edulaw</span>
                                    </div>
                                @endif
                            </a>

                            <div class="min-w-0">
                                <div class="mb-2 flex flex-wrap items-center gap-2">
                                    <h3 class="text-lg font-black leading-snug text-slate-950 md:text-xl">
                                        <a href="{{ route('programs.show', $program) }}" class="transition hover:text-[#0F2868]">
                                                {{ $displayTitle }}
                                            </a>
                                        </h3>
                                    <span class="rounded-full px-2 py-0.5 {{ $tone['badge'] }}">{{ $program->program_type ?: $format }}</span>
                                    @if($program->program_family)
                                        <span class="rounded-full bg-white px-2 py-0.5 text-[11px] font-black text-slate-500 ring-1 ring-slate-200">{{ $program->program_family }}</span>
                                    @endif
                                </div>

                                @if($program->subtitle)
                                    <p class="mb-2 text-sm font-bold leading-5 text-slate-700">{{ $program->subtitle }}</p>
                                @endif

                                <p class="text-sm leading-5 text-slate-600">
                                    {{ $program->description }}
                                </p>

                                @if($highlights->isNotEmpty())
                                    <ul class="mt-3 space-y-1.5 text-sm leading-5 text-slate-600">
                                        @foreach($highlights as $point)
                                            <li class="flex gap-2">
                                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full {{ $tone['button'] }}"></span>
                                                <span>{{ $point }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div class="flex flex-col gap-3 md:items-stretch">
                                <div class="space-y-1.5 text-sm font-semibold text-slate-700">
                                    <p><span class="font-black text-slate-500">Durasi</span> <span class="text-slate-400">•</span> {{ $duration }}</p>
                                    <p><span class="font-black text-slate-500">Format</span> <span class="text-slate-400">•</span> {{ $format }}</p>
                                    <p><span class="font-black text-slate-500">Level</span> <span class="text-slate-400">•</span> {{ $level }}</p>
                                </div>

                                <a href="{{ route('programs.show', $program) }}" class="inline-flex justify-center rounded-md px-4 py-2.5 text-xs font-black uppercase tracking-wide text-white transition {{ $tone['button'] }}">
                                    Lihat Arsip
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="border border-dashed border-slate-300 bg-white p-8">
                            <h3 class="text-xl font-black text-slate-950">Portofolio belum tersedia</h3>
                            <p class="mt-2 text-sm text-slate-500">Program yang telah selesai akan tampil di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div data-program-empty class="mt-6 hidden border border-dashed border-slate-300 bg-white p-8 text-center">
                <h3 class="text-xl font-black text-slate-950">Program belum ditemukan</h3>
                <p class="mt-2 text-sm text-slate-500">Coba ubah pilihan format atau level.</p>
            </div>
        </main>
    </div>
</section>

<script>
    const programCards = [...document.querySelectorAll('[data-program-card]')];
    const lifecycleFilters = [...document.querySelectorAll('[data-program-lifecycle-filter]')];
    const familyFilters = [...document.querySelectorAll('[data-program-family-filter]')];
    const formatFilters = [...document.querySelectorAll('[data-program-format-filter]')];
    const levelFilters = [...document.querySelectorAll('[data-program-level-filter]')];
    const programEmpty = document.querySelector('[data-program-empty]');
    const resetButton = document.querySelector('[data-program-reset]');

    const selectedValues = (inputs) => inputs.filter((input) => input.checked).map((input) => input.value);

    const applyProgramFilters = () => {
        const selectedLifecycles = selectedValues(lifecycleFilters);
        const selectedFamilies = selectedValues(familyFilters);
        const selectedFormats = selectedValues(formatFilters);
        const selectedLevels = selectedValues(levelFilters);
        let visibleCount = 0;

        programCards.forEach((card) => {
            const lifecycleMatch = selectedLifecycles.length === 0 || selectedLifecycles.includes(card.dataset.programLifecycle);
            const familyMatch = selectedFamilies.length === 0 || selectedFamilies.includes(card.dataset.programFamily);
            const formatMatch = selectedFormats.length === 0 || selectedFormats.includes(card.dataset.programFormat);
            const levelMatch = selectedLevels.length === 0 || selectedLevels.includes(card.dataset.programLevel);
            const isVisible = lifecycleMatch && familyMatch && formatMatch && levelMatch;

            card.classList.toggle('hidden', !isVisible);
            if (isVisible) visibleCount += 1;
        });

        if (programEmpty) programEmpty.classList.toggle('hidden', visibleCount !== 0);
    };

    [...lifecycleFilters, ...familyFilters, ...formatFilters, ...levelFilters].forEach((input) => {
        input.addEventListener('change', applyProgramFilters);
    });

    resetButton?.addEventListener('click', () => {
        [...lifecycleFilters, ...familyFilters, ...formatFilters, ...levelFilters].forEach((input) => {
            input.checked = false;
        });

        applyProgramFilters();
    });
</script>
@endsection
