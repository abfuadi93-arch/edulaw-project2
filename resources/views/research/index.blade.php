@extends('layouts.app')

@section('title', 'Riset & Publikasi - Edulaw Project')

@section('content')
<style>
    .publication-page {
        background: #f8fafc;
        color: #0f172a;
    }

    .publication-hero {
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
        color: #0f172a;
        padding: 48px 0;
    }

    .publication-hero .container,
    .publication-section .container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        color: #64748b;
        font-size: 13px;
        font-weight: 800;
    }

    .breadcrumb a {
        color: #0F2868;
        text-decoration: none;
    }

    .publication-hero-inner {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 32px;
    }

    .publication-hero h1 {
        margin-top: 22px;
        font-size: 48px;
        font-weight: 900;
        line-height: 1.05;
    }

    .publication-hero p {
        max-width: 720px;
        margin-top: 18px;
        color: #475569;
        font-size: 17px;
        line-height: 1.65;
    }

    .publication-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 28px;
        flex-shrink: 0;
        border-left: 1px solid #e2e8f0;
        padding-left: 28px;
    }

    .publication-stats strong {
        display: block;
        color: #0f172a;
        font-size: 28px;
        line-height: 1;
    }

    .publication-stats span {
        display: block;
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .publication-section {
        padding: 34px 0 72px;
    }

    .publication-layout {
        display: grid;
        grid-template-columns: 300px minmax(0, 1fr);
        gap: 28px;
        align-items: start;
    }

    .publication-filter {
        position: sticky;
        top: 96px;
    }

    .filter-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #ffffff;
        padding: 20px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
    }

    .filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .filter-header h3 {
        font-size: 17px;
        font-weight: 900;
        color: #0f172a;
    }

    .filter-header a {
        color: #64748b;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
    }

    .form-group {
        display: grid;
        gap: 8px;
        margin-bottom: 16px;
    }

    .form-group label {
        color: #64748b;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .form-group input,
    .form-group select {
        min-height: 43px;
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background: #ffffff;
        padding: 0 13px;
        color: #334155;
        font-size: 13px;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #0F2868;
    }

    .date-row {
        display: grid;
        gap: 8px;
    }

    .date-row span {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 800;
        text-align: center;
    }

    .btn-filter {
        min-height: 44px;
        width: 100%;
        border: 0;
        border-radius: 6px;
        background: #0F2868;
        color: #ffffff;
        font-size: 14px;
        font-weight: 900;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-filter:hover {
        background: #071A3D;
        transform: translateY(-1px);
    }

    .publication-list {
        display: grid;
        gap: 14px;
    }

    .publication-list-header {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #ffffff;
        padding: 20px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
    }

    .publication-list-header span {
        color: #1d3b8b;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .publication-list-header h2 {
        margin-top: 8px;
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
    }

    .publication-list-header p {
        margin-top: 8px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.55;
    }

    .publication-item {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 190px;
        gap: 20px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #ffffff;
        padding: 18px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
        transition: .25s ease;
    }

    .publication-item:hover {
        transform: translateY(-3px);
        border-color: rgba(15, 40, 104, .28);
        box-shadow: 0 18px 42px rgba(15, 23, 42, .08);
    }

    .publication-category {
        display: inline-flex;
        width: fit-content;
        border-radius: 6px;
        background: #f1f5f9;
        color: #1d3b8b;
        padding: 5px 8px;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .publication-content h2 {
        margin-top: 10px;
        font-size: 18px;
        line-height: 1.32;
        font-weight: 900;
    }

    .publication-content h2 a {
        color: #0f172a;
        text-decoration: none;
    }

    .publication-content h2 a:hover {
        color: #0F2868;
    }

    .publication-meta {
        margin-top: 8px;
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
    }

    .publication-content p {
        margin-top: 10px;
        color: #475569;
        font-size: 13px;
        line-height: 1.6;
    }

    .publication-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 13px;
    }

    .read-more,
    .citation-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        padding: 9px 13px;
        font-size: 12px;
        font-weight: 900;
        text-decoration: none;
    }

    .read-more {
        background: #0F2868;
        color: #ffffff;
    }

    .citation-link {
        border: 1px solid rgba(15, 40, 104, .2);
        color: #0F2868;
        background: #ffffff;
    }

    .publication-thumb {
        min-height: 128px;
        overflow: hidden;
        border-radius: 8px;
        background: #e2e8f0;
    }

    .publication-thumb iframe {
        display: block;
        width: 100%;
        height: 100%;
        min-height: 128px;
        border: 0;
        background: #f8fafc;
        pointer-events: none;
    }

    .thumb-placeholder {
        display: flex;
        height: 100%;
        min-height: 128px;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #dbeafe, #f8fafc);
        color: #1d3b8b;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .empty-state {
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        background: #ffffff;
        padding: 34px;
        text-align: center;
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 900;
        color: #0f172a;
    }

    .empty-state p {
        margin-top: 8px;
        color: #64748b;
    }

    .publication-pagination {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        border-top: 1px solid #e2e8f0;
        padding-top: 18px;
        color: #64748b;
        font-size: 13px;
        font-weight: 800;
    }

    @media (max-width: 900px) {
        .publication-hero-inner {
            display: block;
        }

        .publication-stats {
            margin-top: 24px;
            border-top: 1px solid #e2e8f0;
            border-left: 0;
            padding-top: 18px;
            padding-left: 0;
        }

        .publication-layout,
        .publication-item {
            grid-template-columns: 1fr;
        }

        .publication-filter {
            position: static;
        }

        .publication-thumb {
            order: -1;
            min-height: 190px;
        }
    }
</style>

@php
    $publications = $researches;
    $publicationItems = $publications instanceof \Illuminate\Pagination\AbstractPaginator
        ? $publications->getCollection()
        : collect($publications);
@endphp

<main class="publication-page">
    <section class="publication-hero">
        <div class="container">
            <div class="publication-hero-inner">
                <div>
                    <div class="breadcrumb">
                        <span>Research Hub</span>
                    </div>

                    <h1>Riset & Publikasi</h1>
                </div>

                <div class="publication-stats">
                    <div>
                        <strong>{{ number_format($totalDocuments ?? 0, 0, ',', '.') }}</strong>
                        <span>Dokumen</span>
                    </div>
                    <div>
                        <strong>{{ number_format($totalDownloads ?? 0, 0, ',', '.') }}</strong>
                        <span>Unduhan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="publication-section">
        <div class="container publication-layout">
            <aside class="publication-filter">
                <div class="filter-card">
                    <div class="filter-header">
                        <h3>Filter</h3>
                        <a href="{{ route('research.index') }}">Hapus</a>
                    </div>

                    <form method="GET" action="{{ route('research.index') }}">
                        <div class="form-group">
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari publikasi..."
                            >
                        </div>

                        <div class="form-group">
                            <label>Pilih Berdasarkan Kategori</label>
                            <select name="type">
                                <option value="">Semua Kategori</option>
                                @foreach($publicationCategories as $value => $label)
                                    <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pilih Berdasarkan Isu</label>
                            <select name="issue">
                                <option value="">Semua Isu</option>
                                @foreach($issueCategories as $issue)
                                    <option value="{{ $issue }}" @selected(request('issue') === $issue)>{{ $issue }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Bahasa</label>
                            <select name="language">
                                <option value="">Semua Bahasa</option>
                                @foreach($languages as $value => $label)
                                    <option value="{{ $value }}" @selected(request('language') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Publikasi</label>
                            <div class="date-row">
                                <input type="date" name="date_from" value="{{ request('date_from') }}">
                                <span>to</span>
                                <input type="date" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn-filter">Terapkan Filter</button>
                    </form>
                </div>
            </aside>

            <main class="publication-list">
                @forelse ($publicationItems as $publication)
                    @php
                        $categoryLabel = $publicationCategories[$publication->document_type]
                            ?? $documentTypes[$publication->category]
                            ?? $documentTypes[$publication->document_type]
                            ?? 'Publikasi';
                        $summary = $publication->abstract
                            ?: $publication->preview_note
                            ?: 'Publikasi Edulaw Project untuk mendukung literasi hukum dan advokasi kebijakan publik.';
                    @endphp

                    <article class="publication-item">
                        <div class="publication-content">
                            <span class="publication-category">
                                {{ $categoryLabel }}
                            </span>

                            <h2>
                                <a href="{{ route('research.show', $publication) }}">
                                    {{ $publication->title }}
                                </a>
                            </h2>

                            <div class="publication-meta">
                                {{ $publication->authors ?: 'Edulaw Research Team' }}
                                ·
                                {{ optional($publication->published_at)->translatedFormat('d F Y') ?: ($publication->year ?: 'Tanpa tanggal') }}
                            </div>

                            <p>
                                {{ \Illuminate\Support\Str::limit($summary, 220) }}
                            </p>

                            <div class="publication-actions">
                                <a href="{{ route('research.show', $publication) }}" class="read-more">
                                    Lihat Selengkapnya →
                                </a>
                                <a href="{{ route('research.citation', $publication) }}" class="citation-link">
                                    Sitasi Dokumen
                                </a>
                            </div>
                        </div>

                        <div class="publication-thumb">
                            @if ($publication->file)
                                <iframe
                                    src="{{ asset('storage/' . $publication->file) }}#page=1&toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                                    title="Cover PDF {{ $publication->title }}"
                                    loading="lazy"
                                ></iframe>
                            @else
                                <div class="thumb-placeholder">
                                    Edulaw
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <h3>Publikasi belum ditemukan</h3>
                        <p>Coba gunakan kata kunci atau kategori lain.</p>
                    </div>
                @endforelse

                @if($publications instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div class="publication-pagination">
                        <p>
                            Menampilkan {{ $publications->firstItem() ?? 0 }}–{{ $publications->lastItem() ?? 0 }}
                            dari {{ $publications->total() }} publikasi
                        </p>

                        {{ $publications->links() }}
                    </div>
                @endif
            </main>
        </div>
    </section>
</main>

@endsection
