@php($currentLocale = session('locale', 'id'))
<!DOCTYPE html>
<html lang="{{ $currentLocale }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')">
    @endif
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', $__env->hasSection('title') ? trim($__env->yieldContent('title')) : 'Edulaw Project')">
    <meta property="og:description" content="@yield('og_description', $__env->hasSection('meta_description') ? trim($__env->yieldContent('meta_description')) : 'Media hukum, literasi konstitusi, riset kebijakan, dan pendidikan kewargaan dalam satu ekosistem pengetahuan.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <title>@yield('title', 'Edulaw Project')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        html,
        body,
        button,
        input,
        select,
        textarea {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        body { font-feature-settings: "cv02", "cv03", "cv04", "cv11"; }
        :root {
            --edulaw-navy: #071A3D;
            --edulaw-blue: #0F2868;
            --edulaw-ink: #0f172a;
            --edulaw-muted: #64748b;
            --edulaw-paper: #fffdf8;
            --edulaw-radius: 14px;
            --edulaw-shadow: 0 18px 42px rgba(15, 23, 42, .08);
        }

        .site-nav {
            box-shadow: 0 10px 32px rgba(15, 23, 42, .06);
        }

        .site-nav-link {
            position: relative;
        }

        .site-nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -8px;
            height: 2px;
            border-radius: 999px;
            background: #0F2868;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform .2s ease;
        }

        .site-nav-link:hover::after,
        .site-nav-link.is-active::after {
            transform: scaleX(1);
        }

        .mobile-nav-panel,
        .mobile-search-panel {
            display: none;
        }

        .mobile-nav-panel.is-open,
        .mobile-search-panel.is-open {
            display: block;
        }

        .edulaw-eyebrow {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--edulaw-blue);
        }

        .edulaw-card {
            border-radius: var(--edulaw-radius);
            border: 1px solid rgba(148, 163, 184, .22);
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .edulaw-card:hover {
            transform: translateY(-4px);
            border-color: rgba(15, 40, 104, .24);
            box-shadow: var(--edulaw-shadow);
        }

        .edulaw-icon {
            display: inline-flex;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(15, 40, 104, .08);
            color: var(--edulaw-blue);
            font-weight: 800;
        }

        .edulaw-slogan {
            font-weight: 800;
            letter-spacing: .02em;
            color: var(--edulaw-blue);
        }

        /* Warna Kustom berdasarkan Gambar 2 */
        .bg-edulaw-dark { background-color: #071A3D; }
        .bg-edulaw-blue { background-color: #0F2868; }
        .text-edulaw-blue { color: #0F2868; }
        .border-edulaw-blue { border-color: #0F2868; }
        .hover\:bg-edulaw-blue-dark:hover { background-color: #0B1F4D; }
        .bg-edulaw-teal { background-color: #14B8A6; } /* Teal/Tosca Aksen */
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<nav class="site-nav sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="flex h-[88px] items-center justify-between gap-3 md:gap-6">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-2.5 md:gap-3">
                <img
                    src="{{ asset('images/edulaw-logo.webp') }}"
                    alt="Edulaw Project"
                    class="h-10 w-auto shrink-0 md:h-12"
                >

                <span class="truncate text-sm font-bold tracking-[0.08em] text-[#0F2868] sm:text-base">
                    EDULAW PROJECT
                </span>
            </a>

            <ul class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
                <li><a href="{{ route('home') }}" class="site-nav-link rounded-full px-3 py-2 transition {{ request()->routeIs('home') ? 'is-active bg-[#0F2868]/10 text-edulaw-blue' : 'hover:bg-slate-50 hover:text-edulaw-blue' }}">Beranda</a></li>
                <li><a href="{{ route('programs.index') }}" class="site-nav-link rounded-full px-3 py-2 transition {{ request()->routeIs('programs.*') ? 'is-active bg-[#0F2868]/10 text-edulaw-blue' : 'hover:bg-slate-50 hover:text-edulaw-blue' }}">Program</a></li>
                <li><a href="{{ route('insights.index') }}" class="site-nav-link rounded-full px-3 py-2 transition {{ request()->routeIs('insights.*') || request()->routeIs('insight.*') ? 'is-active bg-[#0F2868]/10 text-edulaw-blue' : 'hover:bg-slate-50 hover:text-edulaw-blue' }}">Insight</a></li>
                <li><a href="{{ route('research.index') }}" class="site-nav-link rounded-full px-3 py-2 transition {{ request()->routeIs('research.*') ? 'is-active bg-[#0F2868]/10 text-edulaw-blue' : 'hover:bg-slate-50 hover:text-edulaw-blue' }}">Riset & Publikasi</a></li>
                <li><a href="{{ route('tentang') }}" class="site-nav-link rounded-full px-3 py-2 transition {{ request()->routeIs('tentang') ? 'is-active bg-[#0F2868]/10 text-edulaw-blue' : 'hover:bg-slate-50 hover:text-edulaw-blue' }}">Tentang</a></li>
            </ul>

            <form action="{{ route('search.index') }}" method="GET" class="hidden items-center rounded-full border border-slate-200 bg-slate-50 px-4 py-2 lg:flex">
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari topik..."
                    class="w-44 bg-transparent text-sm text-slate-600 outline-none placeholder:text-slate-400 xl:w-56"
                >
                <button type="submit" class="text-[#0F2868]" aria-label="Cari">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                </button>
            </form>

            @auth
                <a href="{{ url('/admin') }}" class="hidden rounded-md border border-[#0F2868] px-4 py-2 text-sm font-bold text-[#0F2868] transition hover:-translate-y-0.5 hover:bg-[#0F2868] hover:text-white hover:shadow-lg hover:shadow-[#0F2868]/15 md:inline-flex">Dashboard</a>
            @elseif (Route::has('login'))
                <a href="{{ route('login') }}" class="hidden rounded-md border border-[#0F2868] px-4 py-2 text-sm font-bold text-[#0F2868] transition hover:-translate-y-0.5 hover:bg-[#0F2868] hover:text-white hover:shadow-lg hover:shadow-[#0F2868]/15 md:inline-flex">Masuk</a>
            @else
                <a href="{{ url('/admin/login') }}" class="hidden rounded-md border border-[#0F2868] px-4 py-2 text-sm font-bold text-[#0F2868] transition hover:-translate-y-0.5 hover:bg-[#0F2868] hover:text-white hover:shadow-lg hover:shadow-[#0F2868]/15 md:inline-flex">Masuk</a>
            @endif

            <div class="flex items-center gap-2 md:hidden">
                <button
                    type="button"
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-slate-200 text-[#0F2868] transition hover:bg-slate-50 sm:h-10 sm:w-10"
                    data-mobile-search-toggle
                    aria-controls="mobile-search-panel"
                    aria-expanded="false"
                    aria-label="Buka pencarian"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                </button>

                <button
                    type="button"
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-slate-200 text-[#0F2868] transition hover:bg-slate-50 sm:h-10 sm:w-10"
                    data-mobile-menu-toggle
                    aria-controls="mobile-nav-panel"
                    aria-expanded="false"
                    aria-label="Buka menu navigasi"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>

        <div id="mobile-search-panel" class="mobile-search-panel border-t border-slate-200 py-3 md:hidden">
            <form action="{{ route('search.index') }}" method="GET" class="flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2">
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari topik..."
                    class="min-w-0 flex-1 bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                    data-mobile-search-input
                >
                <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#0F2868] text-white" aria-label="Cari">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.3-4.3M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/></svg>
                </button>
            </form>
        </div>

        <div id="mobile-nav-panel" class="mobile-nav-panel border-t border-slate-200 pb-4 pt-3 md:hidden">
            <ul class="space-y-1 text-sm font-bold text-slate-700">
                <li><a href="{{ route('home') }}" class="block rounded-lg px-3 py-3 transition {{ request()->routeIs('home') ? 'bg-[#0F2868]/10 text-[#0F2868]' : 'hover:bg-slate-50 hover:text-[#0F2868]' }}">Beranda</a></li>
                <li><a href="{{ route('programs.index') }}" class="block rounded-lg px-3 py-3 transition {{ request()->routeIs('programs.*') ? 'bg-[#0F2868]/10 text-[#0F2868]' : 'hover:bg-slate-50 hover:text-[#0F2868]' }}">Program</a></li>
                <li><a href="{{ route('insights.index') }}" class="block rounded-lg px-3 py-3 transition {{ request()->routeIs('insights.*') || request()->routeIs('insight.*') ? 'bg-[#0F2868]/10 text-[#0F2868]' : 'hover:bg-slate-50 hover:text-[#0F2868]' }}">Insight</a></li>
                <li><a href="{{ route('research.index') }}" class="block rounded-lg px-3 py-3 transition {{ request()->routeIs('research.*') ? 'bg-[#0F2868]/10 text-[#0F2868]' : 'hover:bg-slate-50 hover:text-[#0F2868]' }}">Riset & Publikasi</a></li>
                <li><a href="{{ route('tentang') }}" class="block rounded-lg px-3 py-3 transition {{ request()->routeIs('tentang') ? 'bg-[#0F2868]/10 text-[#0F2868]' : 'hover:bg-slate-50 hover:text-[#0F2868]' }}">Tentang</a></li>
            </ul>

            @auth
                <a href="{{ url('/admin') }}" class="mt-3 flex items-center justify-center rounded-md border border-[#0F2868] px-4 py-2.5 text-sm font-bold text-[#0F2868] transition hover:bg-[#0F2868] hover:text-white">Dashboard</a>
            @elseif (Route::has('login'))
                <a href="{{ route('login') }}" class="mt-3 flex items-center justify-center rounded-md border border-[#0F2868] px-4 py-2.5 text-sm font-bold text-[#0F2868] transition hover:bg-[#0F2868] hover:text-white">Masuk</a>
            @else
                <a href="{{ url('/admin/login') }}" class="mt-3 flex items-center justify-center rounded-md border border-[#0F2868] px-4 py-2.5 text-sm font-bold text-[#0F2868] transition hover:bg-[#0F2868] hover:text-white">Masuk</a>
            @endif
        </div>
    </div>
</nav>

    <main>
        @yield('content')
    </main>

<footer class="border-t border-slate-200 bg-white">
    <div class="container mx-auto px-6 py-9">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-[1.45fr_0.85fr_0.9fr_1.1fr] lg:items-start">
            <div>
                <div class="mb-3 flex items-center gap-2.5">
                    @if(file_exists(public_path('images/edulaw-logo.webp')))
                        <img src="{{ asset('images/edulaw-logo.webp') }}" alt="" class="h-9 w-auto" aria-hidden="true">
                    @else
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-edulaw-blue text-xs font-bold text-white">EL</span>
                    @endif
                    <span class="text-sm font-bold tracking-[0.08em] text-[#0F2868]">EDULAW PROJECT</span>
                </div>
                <p class="max-w-sm text-sm leading-6 text-slate-500">
                    Equal, Educative, Embrace.
                </p>
            </div>

            <div>
                <h4 class="mb-3 text-[11px] font-bold uppercase tracking-widest text-slate-400">Navigasi</h4>
                <ul class="space-y-2 text-sm font-semibold leading-6 text-slate-600">
                    <li><a href="{{ route('home') }}" class="hover:text-slate-950 transition">Beranda</a></li>
                    <li><a href="{{ route('programs.index') }}" class="hover:text-slate-950 transition">Program</a></li>
                    <li><a href="{{ route('insights.index') }}" class="hover:text-slate-950 transition">Edulaw Insight</a></li>
                    <li><a href="{{ route('research.index') }}" class="hover:text-slate-950 transition">Riset & Publikasi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="mb-3 text-[11px] font-bold uppercase tracking-widest text-slate-400">Ruang Kerja</h4>
                <ul class="space-y-2 text-sm font-semibold leading-6 text-slate-600">
                    <li><a href="{{ url('/admin/insights') }}" class="hover:text-slate-950 transition">Insight Saya</a></li>
                    <li><a href="{{ url('/admin/insights/create') }}" class="hover:text-slate-950 transition">Tulis Insight</a></li>
                    <li><a href="{{ route('community.index') }}" class="hover:text-slate-950 transition">Komunitas</a></li>
                </ul>
            </div>

            <div>
                <h4 class="mb-3 text-[11px] font-bold uppercase tracking-widest text-slate-400">Kontak</h4>
                <ul class="space-y-2 text-sm leading-6 text-slate-600">
                    <li class="grid grid-cols-[74px_1fr] gap-3">
                        <span class="text-xs font-bold text-slate-400">Email</span>
                        <a href="mailto:hello@edulawproject.id" class="font-semibold hover:text-slate-950 transition">hello@edulawproject.id</a>
                    </li>
                    <li class="grid grid-cols-[74px_1fr] gap-3">
                        <span class="text-xs font-bold text-slate-400">WhatsApp</span>
                        <a href="https://wa.me/6281529927677" target="_blank" rel="noopener" class="font-semibold hover:text-slate-950 transition">0815-2992-7677</a>
                    </li>
                    <li class="grid grid-cols-[74px_1fr] gap-3">
                        <span class="text-xs font-bold text-slate-400">Lokasi</span>
                        <span>Jakarta, Indonesia</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 border-t border-slate-200 pt-5 text-xs text-slate-400 md:flex-row md:items-center md:justify-between">
            <p>&copy; 2026 PT Edu Kreasi Nusantara. Hak cipta dilindungi.</p>
            <p class="edulaw-slogan">#Teman Belajar Hukum Terbaikmu.</p>
        </div>
    </div>
</footer>

<script>
    (() => {
        const menuButton = document.querySelector('[data-mobile-menu-toggle]');
        const searchButton = document.querySelector('[data-mobile-search-toggle]');
        const menuPanel = document.getElementById('mobile-nav-panel');
        const searchPanel = document.getElementById('mobile-search-panel');
        const searchInput = document.querySelector('[data-mobile-search-input]');

        const setOpen = (button, panel, isOpen) => {
            button?.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            panel?.classList.toggle('is-open', isOpen);
        };

        menuButton?.addEventListener('click', () => {
            const isOpen = !menuPanel?.classList.contains('is-open');
            setOpen(menuButton, menuPanel, isOpen);
            setOpen(searchButton, searchPanel, false);
        });

        searchButton?.addEventListener('click', () => {
            const isOpen = !searchPanel?.classList.contains('is-open');
            setOpen(searchButton, searchPanel, isOpen);
            setOpen(menuButton, menuPanel, false);

            if (isOpen) {
                window.setTimeout(() => searchInput?.focus(), 80);
            }
        });
    })();
</script>

</body>
</html>
