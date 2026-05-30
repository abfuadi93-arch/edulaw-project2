@extends('layouts.app')

@section('title', $program->title . ' - Edulaw Project')

@section('content')
@php
    $tones = [
        [
            'soft' => 'bg-teal-50 text-teal-700',
            'badge' => 'bg-teal-100 text-teal-800',
            'border' => 'border-teal-200',
            'button' => 'bg-teal-600 hover:bg-teal-700',
            'outline' => 'border-teal-500/40 text-teal-700 hover:bg-teal-50',
            'dot' => 'bg-teal-600',
            'ring' => 'ring-teal-100',
            'hero' => 'from-[#071A3D] via-[#0F766E] to-[#14B8A6]',
            'glow' => 'bg-teal-300/25',
        ],
        [
            'soft' => 'bg-amber-50 text-amber-700',
            'badge' => 'bg-amber-100 text-amber-800',
            'border' => 'border-amber-200',
            'button' => 'bg-amber-600 hover:bg-amber-700',
            'outline' => 'border-amber-500/40 text-amber-700 hover:bg-amber-50',
            'dot' => 'bg-amber-600',
            'ring' => 'ring-amber-100',
            'hero' => 'from-[#071A3D] via-[#92400E] to-[#F59E0B]',
            'glow' => 'bg-amber-300/25',
        ],
        [
            'soft' => 'bg-sky-50 text-sky-700',
            'badge' => 'bg-sky-100 text-sky-800',
            'border' => 'border-sky-200',
            'button' => 'bg-sky-700 hover:bg-sky-800',
            'outline' => 'border-sky-500/40 text-sky-700 hover:bg-sky-50',
            'dot' => 'bg-sky-700',
            'ring' => 'ring-sky-100',
            'hero' => 'from-[#071A3D] via-[#0369A1] to-[#38BDF8]',
            'glow' => 'bg-sky-300/25',
        ],
        [
            'soft' => 'bg-rose-50 text-rose-700',
            'badge' => 'bg-rose-100 text-rose-800',
            'border' => 'border-rose-200',
            'button' => 'bg-rose-700 hover:bg-rose-800',
            'outline' => 'border-rose-500/40 text-rose-700 hover:bg-rose-50',
            'dot' => 'bg-rose-700',
            'ring' => 'ring-rose-100',
            'hero' => 'from-[#071A3D] via-[#9F1239] to-[#FB7185]',
            'glow' => 'bg-rose-300/25',
        ],
    ];

    $tone = $tones[((int) ($program->id ?? 1) - 1) % count($tones)];
    $format = $program->format ?: 'Online';
    $level = $program->level ?: 'Intermediate';
    $duration = $program->duration ?: '4 Pertemuan';
    $displayTitle = $program->short_title ?: $program->title;
    $heroImage = $program->hero_image ?: $program->image;
    $detailDescription = $program->detailed_description ?: $program->description;
    $highlights = collect($program->highlights ?? [])->filter()->values();
    $programNumber = str_pad($program->sort_order ?: $program->id ?: 1, 2, '0', STR_PAD_LEFT);
    $today = now()->toDateString();

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

    $periodLabel = 'Periode terdokumentasi';
    if ($program->start_date && $program->end_date) {
        $start = $monthNames[(int) $program->start_date->format('n')] . ' ' . $program->start_date->format('Y');
        $end = $monthNames[(int) $program->end_date->format('n')] . ' ' . $program->end_date->format('Y');
        $periodLabel = $start === $end ? $start : "{$start} — {$end}";
    }

    $status = match ($program->event_status) {
        'upcoming' => 'Akan Datang',
        'completed' => 'Selesai',
        'portfolio' => 'Portfolio',
        default => 'Portofolio',
    };

    if (! $program->event_status) {
        if ($program->start_date && $program->end_date && $program->start_date->toDateString() <= $today && $program->end_date->toDateString() >= $today) {
            $status = 'Berjalan';
        } elseif ($program->start_date && $program->start_date->toDateString() > $today) {
            $status = 'Terjadwal';
        }
    }

    $fallbackHighlights = collect([
        'Materi dikurasi berdasarkan kebutuhan pembelajaran hukum, konstitusi, dan kebijakan publik.',
        'Pembahasan diarahkan pada studi kasus, regulasi, putusan, dan isu aktual yang relevan.',
        'Peserta memperoleh ringkasan pembelajaran yang dapat digunakan untuk pengembangan kapasitas lanjutan.',
    ]);

    $learningPoints = $highlights->isNotEmpty() ? $highlights : $fallbackHighlights;
    $speakers = collect($program->speakers ?? [])
        ->filter(fn ($speaker) => filled($speaker['name'] ?? null))
        ->values();

    if ($speakers->isEmpty() && $program->speaker_name) {
        $speakers = collect([
            [
                'name' => $program->speaker_name,
                'title' => $program->speaker_title,
            ],
        ]);
    }

    $primaryButtonText = $program->primary_button_text ?: ($program->registration_url ? 'Daftar Kegiatan' : 'Diskusikan Kolaborasi');
    $primaryButtonUrl = $program->primary_button_url ?: ($program->registration_url ?: 'https://wa.me/6281529927677?text=' . rawurlencode('Halo Edulaw Project, saya ingin mendiskusikan kebutuhan program ' . $program->title . '.'));
    $secondaryButtonText = $program->secondary_button_text ?: 'Lihat Program Lain';
    $secondaryButtonUrl = $program->secondary_button_url ?: route('programs.index');
@endphp

<section class="relative overflow-hidden text-white">
    <div class="absolute inset-0 bg-gradient-to-br {{ $tone['hero'] }}"></div>
    <div class="absolute -right-24 top-8 h-72 w-72 rounded-full blur-3xl {{ $tone['glow'] }}"></div>
    <div class="absolute left-1/3 top-24 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
    <div class="container relative mx-auto px-6 py-8 md:py-10">
        <a href="{{ route('programs.index') }}" class="mb-5 inline-flex items-center text-sm font-bold text-white/80 transition hover:text-white">
            <span class="mr-2">←</span> Kembali ke Program
        </a>

        <div class="grid gap-5 lg:grid-cols-[1fr_440px_220px] lg:items-center">
            <div class="max-w-3xl">
                <div class="mb-4 flex flex-wrap items-center gap-2">
                    <span class="rounded-full px-3 py-1 text-xs font-black uppercase tracking-wide {{ $tone['badge'] }}">{{ $program->program_type ?: $format }}</span>
                    @if($program->program_family)
                        <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-black uppercase tracking-wide text-white ring-1 ring-white/20">{{ $program->program_family }}</span>
                    @endif
                    <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-black uppercase tracking-wide text-white ring-1 ring-white/20">{{ $status }}</span>
                    <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-black uppercase tracking-wide text-white ring-1 ring-white/20">{{ $programNumber }}</span>
                </div>

                <h1 class="text-4xl font-black leading-none md:text-6xl">{{ $displayTitle }}</h1>

                @if($program->subtitle)
                    <p class="mt-3 text-xl font-bold leading-8 text-white/90">{{ $program->subtitle }}</p>
                @endif

                <p class="mt-5 max-w-3xl text-base leading-7 text-white/85">
                    {{ $program->description }}
                </p>
            </div>

            <div>
                <div class="overflow-hidden rounded-3xl border border-white/20 bg-white/15 p-3 shadow-2xl shadow-black/20 backdrop-blur">
                    <div class="aspect-[4/3] overflow-hidden rounded-2xl {{ $tone['soft'] }}">
                        @if($heroImage)
                            <img src="{{ asset('storage/' . $heroImage) }}" alt="{{ $program->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full flex-col items-center justify-center gap-3 text-center font-black uppercase tracking-[0.18em]">
                                <span class="text-5xl tracking-normal">{{ $programNumber }}</span>
                                <span>Edulaw</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/20 bg-white/15 p-3 shadow-xl shadow-black/10 backdrop-blur">
                <dl class="grid gap-2.5">
                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-3">
                    <dt class="text-xs font-black uppercase tracking-[0.16em] text-white/60">Periode</dt>
                    <dd class="mt-1 text-sm font-bold text-white">{{ $periodLabel }}</dd>
                </div>
                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-3">
                    <dt class="text-xs font-black uppercase tracking-[0.16em] text-white/60">Durasi</dt>
                    <dd class="mt-1 text-sm font-bold text-white">{{ $duration }}</dd>
                </div>
                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-3">
                    <dt class="text-xs font-black uppercase tracking-[0.16em] text-white/60">Format</dt>
                    <dd class="mt-1 text-sm font-bold text-white">{{ $format }}</dd>
                </div>
                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-3">
                    <dt class="text-xs font-black uppercase tracking-[0.16em] text-white/60">Level</dt>
                    <dd class="mt-1 text-sm font-bold text-white">{{ $level }}</dd>
                </div>
                </dl>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-50 py-9 md:py-11">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[1fr_360px]">
            <div class="rounded-2xl border bg-white p-6 shadow-sm {{ $tone['border'] }}">
                @if($detailDescription)
                    <div class="mb-6 border-b border-slate-100 pb-5">
                        <span class="text-xs font-black uppercase tracking-[0.2em] text-[#0F2868]">Tentang Kegiatan</span>
                        <div class="mt-3 space-y-3 text-sm leading-7 text-slate-600">
                            @foreach(preg_split('/\R{2,}/', trim($detailDescription)) as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-5 flex flex-col gap-3 border-b border-slate-100 pb-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <span class="text-xs font-black uppercase tracking-[0.2em] text-[#0F2868]">Kurikulum</span>
                        <h2 class="mt-2 text-2xl font-black text-slate-950">Apa yang Dipelajari</h2>
                    </div>
                    <span class="w-fit rounded-full px-3 py-1 text-xs font-black {{ $tone['badge'] }}">{{ $format }}</span>
                </div>

                <ul class="grid gap-3 text-slate-600 md:grid-cols-2">
                    @foreach($learningPoints as $point)
                        <li class="flex gap-3 rounded-xl border border-slate-100 bg-slate-50/70 p-4 text-sm leading-6">
                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full {{ $tone['dot'] }}"></span>
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6 grid gap-4 border-t border-slate-100 pt-5 md:grid-cols-3">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Orientasi</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $program->orientation ?: 'Literasi hukum, konstitusi, dan kebijakan publik.' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Metode</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $program->method ?: 'Diskusi terarah, studi kasus, dan bahan bacaan terkurasi.' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Output</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $program->output ?: 'Catatan pembelajaran dan rekomendasi tindak lanjut.' }}</p>
                    </div>
                </div>
            </div>

            <aside class="h-fit rounded-2xl border bg-white p-6 shadow-sm {{ $tone['border'] }}">
                <h2 class="text-xl font-black text-slate-950">{{ $speakers->isNotEmpty() ? 'Narasumber' : 'Diskusikan Kebutuhan' }}</h2>

                @if($speakers->isNotEmpty())
                    <div class="mt-4 space-y-3">
                        @foreach($speakers as $speaker)
                            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                                <p class="text-sm font-bold leading-6 text-slate-800">{{ $speaker['name'] }}</p>
                                @if(filled($speaker['title'] ?? null))
                                    <p class="mt-1 text-sm leading-6 text-slate-500">{{ $speaker['title'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-3 text-sm leading-7 text-slate-500">
                        Cocok untuk peserta, komunitas, institusi, atau tim yang ingin menyesuaikan format belajar dengan kebutuhan spesifik.
                    </p>
                @endif

                @if($program->moderator_name)
                    <div class="mt-5 rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Moderator</p>
                        <p class="mt-2 text-sm font-bold leading-6 text-slate-700">{{ $program->moderator_name }}</p>
                        @if($program->moderator_affiliation)
                            <p class="mt-1 text-sm leading-6 text-slate-500">{{ $program->moderator_affiliation }}</p>
                        @endif
                    </div>
                @endif

                @if($program->youtube_url || $program->material_url)
                    <div class="mt-5 space-y-2 text-sm font-bold">
                        @if($program->youtube_url)
                            <a href="{{ $program->youtube_url }}" target="_blank" rel="noopener" class="block rounded-md border border-slate-200 px-3 py-2 text-slate-700 transition hover:border-[#0F2868]/40 hover:text-[#0F2868]">Dokumentasi YouTube</a>
                        @endif
                        @if($program->material_url)
                            <a href="{{ $program->material_url }}" target="_blank" rel="noopener" class="block rounded-md border border-slate-200 px-3 py-2 text-slate-700 transition hover:border-[#0F2868]/40 hover:text-[#0F2868]">Materi Kegiatan</a>
                        @endif
                    </div>
                @endif

                <div class="mt-6 space-y-3">
                    <a href="{{ $primaryButtonUrl }}" target="_blank" rel="noopener" class="flex justify-center rounded-md border px-4 py-2.5 text-center text-xs font-black uppercase tracking-wide transition {{ $tone['outline'] }}">
                        {{ $primaryButtonText }}
                    </a>
                    <a href="{{ $secondaryButtonUrl }}" class="flex justify-center rounded-md px-4 py-2.5 text-center text-xs font-black uppercase tracking-wide text-white transition {{ $tone['button'] }}">
                        {{ $secondaryButtonText }}
                    </a>
                </div>

                @if($program->notes)
                    <div class="mt-6 rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-slate-400">Catatan</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $program->notes }}</p>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</section>
@endsection
