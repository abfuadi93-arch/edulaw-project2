@extends('layouts.app')

@section('title', 'Komunitas Edulaw - Ruang Kontribusi dan Diskusi Hukum Publik')
@section('meta_description', 'Ruang kontribusi dan diskusi hukum publik Edulaw untuk opini pribadi, penulis, editor, akademisi, praktisi, dan komunitas pembelajar yang melalui kurasi editorial.')

@section('content')
<main class="bg-white">
    <section class="relative overflow-hidden bg-edulaw-dark text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(20,184,166,.22),transparent_34%),linear-gradient(135deg,rgba(7,26,61,1),rgba(15,40,104,.94))]"></div>
        <div class="container relative z-10 mx-auto grid gap-12 px-6 py-20 lg:grid-cols-[1.08fr_0.92fr] lg:items-center lg:py-24">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-teal-300">
                    Community Layer
                </p>

                <h1 class="mt-5 max-w-4xl text-4xl font-extrabold leading-tight md:text-6xl">
                    Ruang Kontribusi dan Diskusi Hukum Publik
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 md:text-lg">
                    Edulaw membuka ruang kolaboratif bagi penulis, editor, peneliti, mahasiswa hukum, dan masyarakat pembelajar untuk mengembangkan literasi hukum yang kritis, etis, dan mudah diakses publik.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ url('/admin/register') }}" class="rounded-md bg-teal-400 px-6 py-3 text-sm font-bold text-[#071A3D] shadow-lg shadow-teal-950/20 transition hover:-translate-y-0.5 hover:bg-teal-300">
                        Daftar sebagai Contributor
                    </a>
                    <a href="{{ route('insights.index') }}" class="rounded-md border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-white/10">
                        Baca Karya Komunitas
                    </a>
                </div>
            </div>

            <aside class="rounded-lg border border-white/15 bg-white/[0.12] p-7 shadow-2xl shadow-black/20 backdrop-blur">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-teal-300">
                    Editorial Standard
                </p>
                <h2 class="mt-4 text-2xl font-extrabold leading-snug">
                    Seluruh tulisan merupakan opini pribadi penulis, proses editorial dilakukan untuk menjaga akurasi, relevansi, etika, dan kualitas argumentasi.
                </h2>
                <p class="mt-4 leading-7 text-slate-200">
                    Seluruh tulisan merupakan opini pribadi penulis, proses editorial dilakukan untuk menjaga akurasi, relevansi, etika, dan kualitas argumentasi.
                </p>

                <div class="mt-8 grid grid-cols-3 gap-4 border-t border-white/15 pt-6">
                    <div>
                        <p class="text-2xl font-extrabold text-white">{{ number_format($contributorCount ?? 0, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs font-bold uppercase tracking-[0.12em] text-slate-300">Contributor</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-white">{{ number_format($submittedCount ?? 0, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs font-bold uppercase tracking-[0.12em] text-slate-300">Review</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-white">{{ number_format($publishedContributorInsights ?? 0, 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs font-bold uppercase tracking-[0.12em] text-slate-300">Published</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="bg-white">
        <div class="container mx-auto px-6 py-20">
            <div class="max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#102a5e]">
                    Contributor System
                </p>

                <h2 class="mt-4 text-3xl font-extrabold leading-tight text-slate-950 md:text-4xl">
                    Sistem Kontributor Edulaw
                </h2>

                <p class="mt-4 text-base leading-8 text-slate-600">
                    Penulis eksternal dapat mengirimkan naskah, melihat status tulisan, menerima catatan editorial, dan melakukan revisi tanpa mengakses kontrol editorial utama.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-5 md:grid-cols-3">
                @foreach ([
                    ['01', 'Daftar & Login', 'Penulis membuat akun contributor dan masuk ke dashboard terbatas.'],
                    ['02', 'Kelola Tulisan Saya', 'Contributor hanya dapat melihat dan mengelola tulisan yang dikirim sendiri.'],
                    ['03', 'Submit Insight', 'Tulisan dikirim ke meja redaksi dan tidak dapat terbit tanpa proses review.'],
                ] as [$number, $title, $desc])
                    <article class="rounded-lg border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:border-[#102a5e]/30 hover:shadow-lg">
                        <p class="text-sm font-extrabold text-[#102a5e]">
                            {{ $number }}
                        </p>
                        <h3 class="mt-8 text-xl font-extrabold text-slate-950">
                            {{ $title }}
                        </h3>
                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            {{ $desc }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-slate-50">
        <div class="container mx-auto px-6 py-20">
            <div class="mb-10 flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#102a5e]">
                        Editorial Workflow
                    </p>
                    <h2 class="mt-4 text-3xl font-extrabold leading-tight text-slate-950 md:text-4xl">
                        Submit, review, revision, moderation, publish.
                    </h2>
                </div>

                <a href="{{ url('/admin') }}" class="inline-flex items-center justify-center rounded-md border border-[#102a5e]/25 px-5 py-3 text-sm font-bold text-[#102a5e] transition hover:bg-[#102a5e] hover:text-white">
                    Masuk Dashboard
                </a>
            </div>

            <div class="grid gap-4 lg:grid-cols-5">
                @foreach ([
                    ['01', 'Draft', 'Contributor menulis dan menyimpan naskah.'],
                    ['02', 'Submitted', 'Tulisan dikirim ke meja redaksi.'],
                    ['03', 'Under Review', 'Editor memeriksa substansi, struktur, dan kepatuhan editorial.'],
                    ['04', 'Revision / Moderation', 'Penulis memperbaiki naskah atau editor menolak bila tidak sesuai.'],
                    ['05', 'Published', 'Admin/editor menerbitkan tulisan di website.'],
                ] as [$number, $status, $copy])
                    <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#102a5e]">
                            {{ $number }}
                        </p>
                        <h3 class="mt-4 text-lg font-extrabold text-slate-950">
                            {{ $status }}
                        </h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">
                            {{ $copy }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container mx-auto grid gap-10 px-6 py-20 lg:grid-cols-[0.88fr_1.12fr] lg:items-start">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#102a5e]">
                    Public Discussion
                </p>
                <h2 class="mt-4 text-3xl font-extrabold leading-tight text-slate-950 md:text-4xl">
                    Diskusi publik yang bertahap, terbatas, dan dimoderasi.
                </h2>
                <p class="mt-4 text-base leading-8 text-slate-600">
                    Forum, komentar, dan diskusi konstitusional dibangun secara bertahap agar ruang dialog tetap menjaga kualitas argumentasi, etika diskusi, dan relevansi isu hukum.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                @foreach ([
                    ['Forum Terbatas', 'Diskusi kecil untuk contributor, editor, dan mitra akademik.'],
                    ['Commentary', 'Tanggapan pendek atas isu hukum aktual.'],
                    ['Constitutional Discussion', 'Diskusi tematik atas putusan, kebijakan, dan hak konstitusional.'],
                ] as [$title, $copy])
                    <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-[#102a5e]/30 hover:shadow-lg">
                        <h3 class="text-lg font-extrabold text-slate-950">
                            {{ $title }}
                        </h3>
                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            {{ $copy }}
                        </p>
                        <span class="mt-5 inline-flex rounded-md bg-slate-100 px-3 py-1 text-xs font-bold uppercase tracking-[0.12em] text-slate-500">
                            Moderated
                        </span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-edulaw-dark text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(20,184,166,.20),transparent_32%),linear-gradient(135deg,rgba(7,26,61,1),rgba(15,40,104,.92))]"></div>
        <div class="container relative z-10 mx-auto flex flex-col gap-8 px-6 py-14 md:flex-row md:items-center md:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-teal-300">
                    Join Edulaw
                </p>
                <h2 class="mt-4 text-3xl font-extrabold leading-tight md:text-4xl">
                    Gabung sebagai penulis atau kolaborator.
                </h2>
                <p class="mt-4 text-base leading-8 text-slate-200">
                    Kirim gagasan hukum, opini, catatan kasus, atau analisis kebijakan publik. Seluruh tulisan merupakan opini pribadi penulis, proses editorial dilakukan untuk menjaga akurasi, relevansi, etika, dan kualitas argumentasi.
                </p>
            </div>

            <div class="flex flex-wrap gap-3 md:justify-end">
                <a href="{{ url('/admin/insights/create') }}" class="rounded-md border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-white/10">
                    Kirim Opini
                </a>
                <a href="{{ url('/admin/register') }}" class="rounded-md bg-teal-400 px-6 py-3 text-sm font-bold text-[#071A3D] shadow-lg shadow-teal-950/20 transition hover:-translate-y-0.5 hover:bg-teal-300">
                    Daftar Contributor
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
