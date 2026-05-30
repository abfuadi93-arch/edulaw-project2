@extends('layouts.app')

@section('title', 'Tentang Edulaw Project')

@section('content')
<style>
    .about-page { background: #fff; color: #071A3D; }
    .about-page p { line-height: 1.75; }
    .about-wrap { max-width: 1180px; margin: 0 auto; padding-left: 24px; padding-right: 24px; }
    .about-eyebrow { color: #0F2868; display: inline-flex; font-size: 11px; font-weight: 900; letter-spacing: .15em; text-transform: uppercase; }
    .about-heading { color: #071A3D; font-weight: 900; letter-spacing: 0; }
    .about-hero { position: relative; overflow: hidden; border-bottom: 1px solid #dbe3ef; background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%); padding: 28px 0 22px; }
    .about-hero::before { content: ""; position: absolute; left: 0; bottom: 0; width: 230px; height: 230px; background-image: radial-gradient(rgba(15,40,104,.16) 1.2px, transparent 1.2px); background-size: 14px 14px; opacity: .35; }
    .hero-grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(420px, 1.1fr); gap: 42px; align-items: center; position: relative; z-index: 1; }
    .hero-title { max-width: 500px; margin-top: 7px; font-size: clamp(36px, 4.7vw, 56px); line-height: .98; }
    .hero-copy { margin-top: 18px; max-width: 540px; color: #14213d; font-size: 14px; }
    .value-list { display: grid; gap: 12px; margin-top: 28px; }
    .value-item { display: grid; grid-template-columns: 38px 1fr; gap: 12px; align-items: center; color: #14213d; font-size: 13px; }
    .value-icon, .focus-icon, .fact-icon { display: inline-flex; align-items: center; justify-content: center; color: #0F2868; background: #eef4ff; border: 1px solid #dbe8ff; box-shadow: inset 0 0 0 6px rgba(255,255,255,.55); }
    .value-icon { width: 38px; height: 38px; border-radius: 999px; }
    .hero-card { border: 1px solid #e1e8f3; border-radius: 18px; background: rgba(255,255,255,.92); box-shadow: 0 22px 60px rgba(15, 40, 104, .08); padding: 18px 20px 20px; }
    .hero-card-title { text-align: center; color: #0F2868; font-size: 14px; font-weight: 900; }
    .stats-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px; margin-top: 14px; }
    .stat-cell { min-height: 68px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; border: 1px solid rgba(229, 234, 243, .95); border-radius: 14px; background: #f8fbff; padding: 6px; }
    .stat-cell small { color: #071A3D; font-size: 10px; font-weight: 800; line-height: 1.2; }
    .stat-cell small span { display: block; white-space: nowrap; }
    .stat-cell strong { margin-top: 5px; color: #0F2868; font-size: 23px; line-height: 1; font-weight: 900; letter-spacing: 0; }
    .stats-row { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 8px; margin-top: 8px; }
    .stats-row .stat-cell { min-height: 66px; }
    .founder-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 10px; margin-top: 10px; }
    .founder-card { display: block; min-width: 0; text-align: center; }
    .founder-photo { aspect-ratio: 1 / 1.02; overflow: hidden; border-radius: 14px; background: #eef3fb; }
    .founder-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .founder-card h3 { margin-top: 6px; color: #071A3D; font-size: 12px; line-height: 1.15; font-weight: 900; }
    .founder-card p { margin-top: 3px; color: #0F2868; font-size: 10px; line-height: 1.1; font-weight: 800; letter-spacing: 0; }
    .why-section { border-bottom: 1px solid #dbe3ef; background: #fff; padding: 36px 0; }
    .why-grid { display: grid; grid-template-columns: 270px 1fr; gap: 52px; align-items: start; }
    .why-title { font-size: 34px; line-height: 1.05; }
    .why-copy { border-left: 1px solid #dbe3ef; padding-left: 48px; color: #14213d; font-size: 16px; }
    .temple-mark { margin-top: 22px; color: #e8eef8; }
    .focus-section { border-bottom: 1px solid #dbe3ef; background: #f8fbff; padding: 30px 0 28px; }
    .focus-title { margin-top: 10px; font-size: 31px; line-height: 1.15; }
    .focus-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-top: 18px; }
    .focus-card { display: grid; grid-template-columns: 58px 1fr; gap: 12px; align-items: center; min-height: 112px; border: 1px solid #dbe3ef; border-radius: 12px; background: #fff; padding: 14px 16px; box-shadow: 0 1px 2px rgba(15,23,42,.03); }
    .focus-icon { width: 54px; height: 54px; border-radius: 16px; }
    .focus-card h3 { color: #071A3D; font-size: 16px; font-weight: 900; }
    .focus-card p { display: -webkit-box; overflow: hidden; -webkit-line-clamp: 3; -webkit-box-orient: vertical; margin-top: 6px; color: #334155; font-size: 13px; line-height: 1.45; }
    .journey-section { background: #fff; padding: 34px 0 46px; }
    .journey-head { display: block; }
    .journey-title { margin-top: 12px; max-width: none; font-size: 34px; line-height: 1.05; white-space: nowrap; }
    .journey-grid { display: grid; grid-template-columns: minmax(0, 680px) 340px; gap: 64px; align-items: center; margin-top: 28px; }
    .timeline { position: relative; display: grid; gap: 12px; padding-left: 116px; }
    .timeline::before { content: ""; position: absolute; left: 8px; top: 8px; bottom: 8px; width: 2px; background: #1557e6; }
    .timeline-item { position: relative; display: grid; grid-template-columns: 60px 1fr; gap: 18px; align-items: center; }
    .timeline-item::before { content: ""; position: absolute; left: -114px; top: 50%; width: 12px; height: 12px; margin-top: -6px; border-radius: 999px; background: #1557e6; box-shadow: 0 0 0 5px #fff; }
    .timeline-year { margin-left: -94px; color: #1557e6; font-size: 14px; font-weight: 900; }
    .timeline-card { border: 1px solid #dbe3ef; border-radius: 9px; background: #fff; padding: 14px 20px; box-shadow: 0 1px 2px rgba(15,23,42,.03); }
    .timeline-card h3 { color: #071A3D; font-size: 16px; font-weight: 900; }
    .timeline-card p { margin-top: 5px; color: #334155; font-size: 13px; line-height: 1.55; }
    .fact-card { border: 1px solid #bfd0ee; border-radius: 14px; background: #f8fbff; padding: 22px 28px; }
    .fact-row { display: grid; grid-template-columns: 50px 1fr; gap: 14px; align-items: center; padding: 18px 0; border-bottom: 1px dashed #bfd0ee; }
    .fact-row:first-child { padding-top: 0; }
    .fact-row:last-child { border-bottom: 0; padding-bottom: 0; }
    .fact-icon { width: 44px; height: 44px; border-radius: 12px; background: transparent; border-color: transparent; box-shadow: none; }
    .fact-row span { color: #64748b; font-size: 13px; font-weight: 800; }
    .fact-row strong { display: block; margin-top: 4px; color: #071A3D; font-size: 15px; line-height: 1.35; font-weight: 900; }
    .about-cta { position: relative; overflow: hidden; background: #071A3D; color: #fff; padding: 38px 0; }
    .about-cta::before, .about-cta::after { content: ""; position: absolute; width: 260px; height: 260px; border: 1px solid rgba(255,255,255,.12); border-radius: 999px; }
    .about-cta::before { left: -86px; top: -118px; box-shadow: 0 0 0 22px rgba(255,255,255,.03), 0 0 0 46px rgba(255,255,255,.02); }
    .about-cta::after { right: -92px; bottom: -128px; box-shadow: 0 0 0 22px rgba(255,255,255,.03), 0 0 0 46px rgba(255,255,255,.02); }
    .cta-badge { display: inline-flex; align-items: center; border: 1px solid rgba(45, 212, 191, .35); border-radius: 999px; background: rgba(20, 184, 166, .12); padding: 6px 10px; color: #99f6e4; font-size: 11px; font-weight: 900; letter-spacing: .14em; text-transform: uppercase; }
    .cta-grid { position: relative; z-index: 1; display: grid; grid-template-columns: 1fr auto; gap: 40px; align-items: center; }
    .cta-grid h2 { margin-top: 12px; color: #fff; font-size: 34px; line-height: 1.15; }
    .cta-grid p { margin-top: 14px; max-width: 690px; color: #dbe4ef; font-size: 15px; }
    .cta-button { display: inline-flex; align-items: center; gap: 14px; border-radius: 7px; background: #fff; padding: 18px 28px; color: #0F2868; font-size: 16px; font-weight: 900; box-shadow: 0 14px 34px rgba(0,0,0,.16); }
    @media (max-width: 1100px) { .hero-grid, .journey-grid { grid-template-columns: 1fr; } .focus-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .hero-grid { gap: 28px; } }
    @media (max-width: 820px) { .about-wrap { padding-left: 20px; padding-right: 20px; } .hero-card { padding: 22px; } .stats-grid, .stats-row, .founder-grid, .focus-grid, .why-grid, .cta-grid { grid-template-columns: 1fr; } .why-copy { border-left: 0; padding-left: 0; } .journey-title { white-space: normal; } .journey-grid { gap: 34px; } .timeline { padding-left: 54px; } .timeline-year { margin-left: -42px; } .timeline-item { grid-template-columns: 1fr; gap: 8px; } .timeline-item::before { left: -60px; } .hero-title { font-size: 42px; } }
</style>

<main class="about-page">
    <section class="about-hero">
        <div class="about-wrap hero-grid">
            <div>
                <span class="about-eyebrow">Tentang Kami</span>
                <h1 class="about-heading hero-title">Edulaw Project</h1>
                <div class="hero-copy space-y-4">
                    <p>Edulaw Project adalah platform edukasi hukum yang berfokus pada penguatan literasi konstitusi, advokasi kebijakan publik, dan pengembangan riset hukum yang aplikatif.</p>
                    <p>Melalui pendekatan kolaboratif dan berbasis data, kami membangun ekosistem pengetahuan hukum yang inklusif, kritis, dan berdampak.</p>
                </div>
                <div class="value-list">
                    <div class="value-item"><span class="value-icon"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/></svg></span><span>Nilai inti: <em>Equal, Educative, Embrace.</em></span></div>
                    <div class="value-item"><span class="value-icon"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 3h7l5 5v13H7V3Z"/></svg></span><span>Berbasis bukti: rujukan, data, dan integritas.</span></div>
                    <div class="value-item"><span class="value-icon"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0-9-9h3m6-4v4l3 3m5-3h-3m-5-9v3"/></svg></span><span>Orientasi solusi: rekomendasi yang dapat dieksekusi.</span></div>
                </div>
            </div>

            <div class="hero-card">
                <h2 class="hero-card-title">Ekosistem Edulaw dalam Angka</h2>
                <div class="stats-grid">
                    @foreach([
                        ['Board', '21 + 17'], ['Member', '111'], ['Participants', '3800+'],
                    ] as $stat)
                        <div class="stat-cell"><small>{{ $stat[0] }}</small><strong>{{ $stat[1] }}</strong></div>
                    @endforeach
                </div>
                <div class="stats-row">
                    @foreach([
                        ['External Speakers', '23'],
                        ['Member Discussion', '10'],
                        ['1 Day 1 Article', '300+'],
                        ['<span>Dissemination of</span><span>Research Results</span>', '4'],
                        ['Inspiring<br>Lecture', '1'],
                    ] as $stat)
                        <div class="stat-cell"><small>{!! $stat[0] !!}</small><strong>{{ $stat[1] }}</strong></div>
                    @endforeach
                </div>
                <div class="founder-grid">
                    @foreach($founders as $founder)
                        <a href="{{ route('founders.show', $founder) }}" class="founder-card">
                            <div class="founder-photo">
                                @if($founder->photo_url)
                                    <img src="{{ $founder->photo_url }}" alt="{{ $founder->name }}">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-3xl font-black text-[#0F2868]">{{ strtoupper(substr($founder->name, 0, 1)) }}</div>
                                @endif
                            </div>
                            <h3>{{ $founder->name }}</h3>
                            <p>{{ \Illuminate\Support\Str::title($founder->role) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="why-section">
        <div class="about-wrap why-grid">
            <div>
                <span class="about-eyebrow">Mengapa</span>
                <h2 class="about-heading why-title">Mengapa Edulaw Hadir?</h2>
                <div class="temple-mark"><svg class="h-20 w-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3 2 8v2h20V8L12 3Zm-7 9v7H3v2h18v-2h-2v-7h-2v7h-3v-7h-2v7H9v-7H7v7H5v-7Z"/></svg></div>
            </div>
            <div class="why-copy space-y-5">
                <p>Hukum sering hadir dalam bahasa yang teknis, tertutup, dan sulit dijangkau publik. Padahal, kualitas demokrasi dan kewargaan sangat bergantung pada kemampuan masyarakat memahami hak, kewajiban, serta arah kebijakan negara.</p>
                <p>Edulaw Project hadir untuk menjembatani pengetahuan hukum, riset kebijakan, dan kebutuhan masyarakat atas informasi yang jernih, reflektif, serta dapat digunakan dalam pembelajaran, diskusi publik, dan advokasi berbasis pengetahuan.</p>
            </div>
        </div>
    </section>

    <section class="focus-section">
        <div class="about-wrap">
            <span class="about-eyebrow">Fokus Kerja</span>
            <h2 class="about-heading focus-title">Dari Literasi Hukum Menuju Pengetahuan Publik</h2>
            <div class="focus-grid">
                @foreach([
                    ['book', 'Literasi Hukum', 'Materi belajar yang ringkas, kontekstual, dan mudah digunakan.'],
                    ['chart', 'Riset Kebijakan', 'Kajian berbasis regulasi, putusan, data, dan kebutuhan publik.'],
                    ['pen', 'Insight Editorial', 'Esai dan analisis hukum dengan gaya akademik yang tetap terbaca.'],
                    ['users', 'Kolaborasi Publik', 'Ruang kerja bersama untuk diskusi, advokasi, dan penguatan komunitas.'],
                ] as $focus)
                    <article class="focus-card">
                        <span class="focus-icon">
                            @if($focus[0] === 'book')<svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15Z"/></svg>@endif
                            @if($focus[0] === 'chart')<svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19V5m0 14h16M8 16v-5m4 5V8m4 8v-3"/></svg>@endif
                            @if($focus[0] === 'pen')<svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.5 3.5 4 4L8 20H4v-4L16.5 3.5Z"/></svg>@endif
                            @if($focus[0] === 'users')<svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m14-10a4 4 0 1 0 0-8m6 18v-2a4 4 0 0 0-3-3.87M9 11a4 4 0 1 0 0-8"/></svg>@endif
                        </span>
                        <div><h3>{{ $focus[1] }}</h3><p>{{ $focus[2] }}</p></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="journey-section">
        <div class="about-wrap">
            <div class="journey-head">
                <div><span class="about-eyebrow">Perjalanan Edulaw</span><h2 class="about-heading journey-title">Dari forum kecil menuju ekosistem literasi hukum.</h2></div>
            </div>
            <div class="journey-grid">
                <div class="timeline">
                    @foreach([
                        ['2021', 'Gagasan Awal', 'Forum virtual 1 Hari 1 Tulisan mulai dijalankan sebagai ruang membaca, berdiskusi, dan mengembangkan budaya intelektual hukum.'],
                        ['2022', 'Pengembangan Komunitas', 'Penguatan forum dan pengembangan pembelajaran hukum kolaboratif mulai dilakukan secara lebih terstruktur.'],
                        ['2023', 'Edulaw Project Didirikan', 'Pada 23 Juni 2023, Edulaw Project resmi hadir sebagai platform edukasi hukum independen.'],
                        ['2024', 'Ekspansi Program', 'Diskusi Literasi Konstitusi, editorial insight, dan kolaborasi publik mulai berkembang.'],
                        ['2025', 'Transformasi Digital', 'Pengembangan website dan ekosistem publikasi digital dilakukan untuk memperluas akses pengetahuan hukum.'],
                    ] as $item)
                        <div class="timeline-item"><span class="timeline-year">{{ $item[0] }}</span><div class="timeline-card"><h3>{{ $item[1] }}</h3><p>{{ $item[2] }}</p></div></div>
                    @endforeach
                </div>
                <aside class="fact-card">
                    <div class="fact-row"><span class="fact-icon"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 2v4m8-4v4M3 10h18M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/></svg></span><div><span>Didirikan</span><strong>23 Juni 2023</strong></div></div>
                    <div class="fact-row"><span class="fact-icon"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2m18 0v-2a4 4 0 0 0-3-3.87M10 11a4 4 0 1 0 0-8m8 8a4 4 0 1 0 0-8"/></svg></span><div><span>Karakter</span><strong>Independen, edukatif, dan kolaboratif</strong></div></div>
                    <div class="fact-row"><span class="fact-icon"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0-9-9h3m6-4v4l3 3m5-3h-3m-5-9v3"/></svg></span><div><span>Fokus</span><strong>Literasi hukum dan kebijakan publik</strong></div></div>
                </aside>
            </div>
        </div>
    </section>

    <section class="about-cta">
        <div class="about-wrap cta-grid">
            <div><span class="cta-badge">Kolaborasi</span><h2 class="about-heading">Mari membangun literasi hukum bersama.</h2><p>Edulaw terbuka untuk kolaborasi program, riset tematik, publikasi, diskusi publik, dan kerja sama edukasi hukum berbasis kebutuhan komunitas.</p></div>
            <a href="{{ route('community.index') }}" class="cta-button">Diskusikan Kerja Sama <span>-&gt;</span></a>
        </div>
    </section>
</main>
@endsection
