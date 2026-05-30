@extends('layouts.app')

@section('title', $founder->name . ' - ' . $founder->role . ' Edulaw Project')
@section('meta_description', 'Profil ' . $founder->name . ' sebagai ' . $founder->role . ' Edulaw Project.')

@section('content')
@php
    $expertise = collect($founder->expertise ?? [])
        ->map(fn ($value, $key) => is_int($key) ? $value : $key)
        ->filter()
        ->values();
@endphp

<main class="bg-slate-50">
    <section class="relative overflow-hidden bg-edulaw-dark text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(20,184,166,.20),transparent_34%),linear-gradient(135deg,rgba(7,26,61,1),rgba(15,40,104,.94))]"></div>
        <div class="container relative z-10 mx-auto px-6 py-16 md:py-20">
            <a href="{{ route('tentang') }}" class="inline-flex text-sm font-bold text-teal-200 transition hover:text-white">
                Kembali ke Tentang Edulaw
            </a>

            <div class="mt-8 grid gap-10 lg:grid-cols-[360px_1fr] lg:items-center">
                <div class="overflow-hidden rounded-lg border border-white/15 bg-white/10 p-3 shadow-2xl shadow-black/20">
                    <div class="aspect-square overflow-hidden rounded-md bg-white/10">
                        @if($founder->photo_url)
                            <img src="{{ $founder->photo_url }}" alt="{{ $founder->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-7xl font-extrabold text-teal-100">
                                {{ strtoupper(substr($founder->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-teal-300">
                        {{ $founder->role }} Profile
                    </p>
                    <h1 class="mt-4 text-4xl font-extrabold leading-tight md:text-6xl">
                        {{ $founder->name }}
                    </h1>
                    <p class="mt-4 text-base font-bold text-slate-200">
                        {{ $founder->title ?: $founder->role . ' Edulaw Project' }}
                        @if($founder->affiliation)
                            <span class="text-slate-400">/</span> {{ $founder->affiliation }}
                        @endif
                    </p>
                    @if($founder->bio)
                        <p class="mt-6 max-w-3xl text-base leading-8 text-slate-200 md:text-lg">
                            {{ $founder->bio }}
                        </p>
                    @endif

                    @if($expertise->isNotEmpty())
                        <div class="mt-7 flex flex-wrap gap-2">
                            @foreach($expertise as $tag)
                                <span class="rounded-md bg-white/10 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.12em] text-teal-100">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container mx-auto grid gap-8 px-6 py-12 lg:grid-cols-[1fr_360px]">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm md:p-8">
                <p class="edulaw-eyebrow">Peran di Edulaw</p>
                <h2 class="mt-3 text-3xl font-extrabold leading-tight text-slate-950">
                    Membangun ekosistem literasi hukum yang terbuka dan terkurasi.
                </h2>
                <p class="mt-5 text-base leading-8 text-slate-600">
                    {{ $founder->bio ?: $founder->name . ' merupakan bagian dari tim pendiri Edulaw Project yang mengembangkan ruang edukasi hukum, riset kebijakan, publikasi, dan kolaborasi publik.' }}
                </p>

                @if($founder->quote)
                    <blockquote class="mt-8 border-l-4 border-[#0F2868] bg-slate-50 p-5 text-lg font-semibold leading-8 text-slate-800">
                        "{{ $founder->quote }}"
                    </blockquote>
                @endif
            </div>

            <aside class="space-y-5">
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#0F2868]">Profil Singkat</p>
                    <dl class="mt-4 space-y-4 text-sm">
                        <div>
                            <dt class="font-bold text-slate-400">Peran</dt>
                            <dd class="mt-1 font-semibold text-slate-900">{{ $founder->role }}</dd>
                        </div>
                        <div>
                            <dt class="font-bold text-slate-400">Afiliasi</dt>
                            <dd class="mt-1 font-semibold text-slate-900">{{ $founder->affiliation ?: 'Edulaw Project' }}</dd>
                        </div>
                        @if($founder->email)
                            <div>
                                <dt class="font-bold text-slate-400">Email</dt>
                                <dd class="mt-1 font-semibold text-slate-900">
                                    <a href="mailto:{{ $founder->email }}" class="transition hover:text-[#0F2868]">{{ $founder->email }}</a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                @if($otherFounders->isNotEmpty())
                    <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#0F2868]">Founder Lainnya</p>
                        <div class="mt-4 space-y-3">
                            @foreach($otherFounders as $otherFounder)
                                <a href="{{ route('founders.show', $otherFounder) }}" class="flex items-center gap-3 rounded-md border border-slate-100 p-3 transition hover:border-[#0F2868]/25 hover:bg-slate-50">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#0F2868]/10 text-sm font-extrabold text-[#0F2868]">
                                        @if($otherFounder->photo_url)
                                            <img src="{{ $otherFounder->photo_url }}" alt="{{ $otherFounder->name }}" class="h-full w-full object-cover">
                                        @else
                                            {{ strtoupper(substr($otherFounder->name, 0, 1)) }}
                                        @endif
                                    </span>
                                    <span>
                                        <span class="block text-sm font-bold text-slate-950">{{ $otherFounder->name }}</span>
                                        <span class="text-xs font-semibold text-slate-500">{{ $otherFounder->role }}</span>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </section>
</main>
@endsection
