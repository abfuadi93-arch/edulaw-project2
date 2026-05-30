@extends('layouts.app')

@section('title', ($insight->seo_title ?: $insight->title) . ' - Edulaw Insight')
@section('meta_description', $insight->meta_description ?: Str::limit(strip_tags($insight->content), 155))
@section('canonical_url', route('insight.show', $insight->slug))
@section('og_title', $insight->seo_title ?: $insight->title)
@section('og_description', $insight->meta_description ?: Str::limit(strip_tags($insight->content), 155))
@section('og_type', 'article')
@if($insight->thumbnail ?: $insight->image)
    @section('og_image', asset('storage/' . ($insight->thumbnail ?: $insight->image)))
@endif

@section('content')
@php
    $insightImage = $insight->thumbnail ?: $insight->image;
    $authorUser = $insight->author()->first();
    $authorName = $insight->author_name ?: ($authorUser?->name ?: ($insight->getAttribute('author') ?: 'Edulaw Project'));
    $authorAffiliation = $insight->author_affiliation ?: ($authorUser?->author_affiliation ?: 'Edulaw Project');
    $authorPhoto = $insight->author_photo ?: $authorUser?->author_photo;
    $authorExpertise = $authorUser?->author_expertise;
    $coAuthors = collect($insight->co_authors ?? [])->filter(fn ($author) => filled($author['name'] ?? null))->values();
    $categoryName = $insight->relationLoaded('category') && $insight->getRelation('category')
        ? $insight->getRelation('category')->name
        : 'Insight';
    $topicName = $insight->topic_label ?: null;
    $authorBio = $authorUser?->author_bio ?: ($authorName . ' menulis analisis hukum, kebijakan publik, dan isu konstitusional untuk pembaca Edulaw.');
    if ($authorAffiliation && $authorAffiliation !== 'Edulaw Project') {
        $authorBio .= ' Saat ini terafiliasi dengan ' . $authorAffiliation . '.';
    }
    $readingMinutes = max(1, (int) ceil(str_word_count(strip_tags($insight->content ?? '')) / 200));
    $publishedAt = $insight->published_at ?? $insight->created_at;
    $publishedDate = $publishedAt
        ? \Carbon\Carbon::parse($publishedAt)->translatedFormat('d F Y')
        : 'Belum dipublikasikan';
    $rawTitle = trim((string) $insight->title);
    $displayTitle = $rawTitle === mb_strtoupper($rawTitle, 'UTF-8')
        ? \Illuminate\Support\Str::title(mb_strtolower($rawTitle, 'UTF-8'))
        : $rawTitle;
    $articleDeck = trim(strip_tags($insight->excerpt ?: ($insight->summary ?: ($insight->meta_description ?: ''))));
    $articleDeck = $articleDeck ?: \Illuminate\Support\Str::limit(strip_tags($insight->content ?? ''), 220);
    $articleSummary = $insight->summary
        ?: $insight->excerpt
        ?: $insight->meta_description
        ?: \Illuminate\Support\Str::limit(strip_tags($insight->content ?? ''), 260);
    $normalizeArticleText = fn (?string $value): string => trim(preg_replace('/\s+/', ' ', \Illuminate\Support\Str::lower(strip_tags((string) $value))));
    $articleDeckNormalized = $normalizeArticleText($articleDeck);
    $articleSummaryNormalized = $normalizeArticleText($articleSummary);
    $articleSummary = (
        $articleSummaryNormalized === ''
        || $articleSummaryNormalized === $articleDeckNormalized
        || \Illuminate\Support\Str::startsWith($articleSummaryNormalized, \Illuminate\Support\Str::limit($articleDeckNormalized, 120, ''))
    ) ? null : $articleSummary;
    $captionTopic = $topicName ?: $categoryName;
    $imageCaption = 'Ilustrasi: ' . $captionTopic . ' menjadi bagian dari pembacaan hukum, kebijakan, dan tanggung jawab institusional yang dibahas dalam artikel ini.';
    $contentKeywords = \Illuminate\Support\Str::lower($insight->title . ' ' . strip_tags($insight->content ?? '') . ' ' . $topicName . ' ' . $categoryName);
    $legalReferences = collect();

    if (\Illuminate\Support\Str::contains($contentKeywords, ['kekerasan seksual', 'seksual'])) {
        $legalReferences = $legalReferences->merge([
            'UU Nomor 12 Tahun 2022 tentang Tindak Pidana Kekerasan Seksual',
            'Permendikbudristek Nomor 30 Tahun 2021 tentang Pencegahan dan Penanganan Kekerasan Seksual di Lingkungan Perguruan Tinggi',
            'Prinsip perlindungan hak atas rasa aman dan martabat manusia',
            'Kewajiban institusi pendidikan dalam pencegahan dan penanganan kekerasan seksual',
        ]);
    }

    if (\Illuminate\Support\Str::contains($contentKeywords, ['konstitusi', 'mahkamah konstitusi', 'putusan mk'])) {
        $legalReferences = $legalReferences->merge([
            'Undang-Undang Dasar Negara Republik Indonesia Tahun 1945',
            'Prinsip negara hukum dan perlindungan hak konstitusional warga negara',
        ]);
    }

    if (\Illuminate\Support\Str::contains($contentKeywords, ['pemilu', 'pilkada', 'demokrasi'])) {
        $legalReferences = $legalReferences->merge([
            'Prinsip kedaulatan rakyat dalam sistem demokrasi konstitusional',
            'Kerangka hukum penyelenggaraan pemilihan umum dan pemilihan kepala daerah',
        ]);
    }

    $legalReferences = $legalReferences->unique()->values();
    $topicTags = collect($insight->topic_tags)->filter()->values();
    if ($topicTags->isEmpty()) {
        $topicTags = collect([$categoryName])->filter()->values();
    }
    $sidebarRelatedInsights = ($relatedInsights ?? collect())->take(3);
    $popularInsights = \App\Models\Insight::with('category')
        ->where('status', 'published')
        ->whereKeyNot($insight->id)
        ->orderByDesc('views_count')
        ->orderByDesc('published_at')
        ->limit(5)
        ->get();
@endphp

		<style>
    .insight-detail { background: #fff; border-bottom: 1px solid #e2e8f0; }
    .insight-container { max-width: 1180px; margin: 0 auto; padding: 32px 24px 58px; }
    .article-shell { display: grid; grid-template-columns: minmax(0, 740px) 300px; gap: 56px; align-items: start; }
    .article-main { min-width: 0; }
    .article-sidebar { display: grid; gap: 30px; min-width: 0; padding-top: 32px; }
    .article-breadcrumb { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-bottom: 22px; color: #64748b; font-size: 12px; font-weight: 700; }
    .article-breadcrumb a { color: #0F2868; transition: color .2s ease; }
    .article-breadcrumb a:hover { color: #071A3D; }
    .article-breadcrumb span + span::before,
    .article-breadcrumb a + span::before { content: "›"; color: #cbd5e1; margin-right: 8px; }
    .reading-progress { position: fixed; left: 0; top: 80px; z-index: 60; width: 100%; height: 3px; background: transparent; }
    .reading-progress-bar { width: 0%; height: 100%; background: #0F2868; transition: width .1s linear; }
    .article-meta { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-bottom: 12px; color: #64748b; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .05em; }
    .article-meta span:not(:first-child)::before { content: "•"; color: #cbd5e1; margin-right: 8px; }
    .article-hero h1 { max-width: 760px; font-size: clamp(34px, 4vw, 48px); line-height: 1.13; font-weight: 800; color: #071A3D; margin-bottom: 22px; text-wrap: balance; }
    .article-byline-row { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 30px; }
    .article-editor-note { margin-top: 3px; color: #64748b; font-size: 11px; font-weight: 700; }
    .author-box { display: inline-flex; align-items: center; gap: 12px; background: transparent; }
    .author-avatar { width: 44px; height: 44px; border-radius: 999px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #eef3fb; color: #0F2868; font-size: 14px; font-weight: 800; flex-shrink: 0; }
    .author-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .author-box strong { display: block; color: #0f172a; font-size: 14px; }
    .author-box span { display: block; color: #64748b; font-size: 12px; margin-top: 2px; }
    .article-share { display: inline-flex; align-items: center; gap: 8px; color: #071A3D; font-size: 12px; font-weight: 800; }
    .article-share-buttons { display: inline-flex; gap: 8px; }
    .share-icon-button { display: inline-flex; width: 36px; height: 36px; align-items: center; justify-content: center; border: 1px solid #dbe3ef; border-radius: 8px; background: #fff; color: #0F2868; font-size: 14px; font-weight: 800; transition: background .2s ease, border-color .2s ease, transform .2s ease; }
    .share-icon-button:hover { transform: translateY(-1px); border-color: rgba(15, 40, 104, .35); background: #f8fafc; }
    .co-author-strip { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
    .co-author-chip { display: inline-flex; align-items: center; gap: 8px; border: 1px solid #e2e8f0; border-radius: 999px; background: #fff; padding: 8px 12px; color: #334155; font-size: 12px; font-weight: 700; }
    .co-author-chip span { color: #64748b; font-weight: 600; }
    .featured-image-wrap { margin: 0 0 10px; }
    .featured-image { width: 100%; height: 310px; object-fit: cover; border-radius: 8px; border: 1px solid #dbe3ef; box-shadow: none; }
    .featured-caption { margin-top: 9px; color: #64748b; font-size: 11px; font-weight: 700; line-height: 1.55; }
    .article-toc { display: none; }
    .article-toc.is-visible { display: block; }
    .article-toc-list { margin-top: 14px; display: grid; gap: 11px; counter-reset: toc; }
    .article-toc-list a { display: grid; grid-template-columns: 22px 1fr; gap: 8px; color: #071A3D; font-size: 12px; font-weight: 700; line-height: 1.55; transition: color .2s ease; }
    .article-toc-list a::before { counter-increment: toc; content: counter(toc) "."; color: #64748b; font-size: 11px; font-weight: 800; }
    .article-toc-list a:hover { color: #0F2868; }
    .article-toc-list a[data-level="H3"] { padding-left: 18px; color: #334155; }
    .article-note-box { margin: 28px 0; border: 1px solid #dbe3ef; border-radius: 8px; background: #ffffff; padding: 22px; box-shadow: 0 1px 2px rgba(15, 23, 42, .04); }
    .article-note-box small { display: block; margin-bottom: 8px; color: #0F2868; font-size: 12px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .article-note-box p { color: #475569; font-size: 15px; line-height: 1.75; }
    .article-note-box ul { display: grid; gap: 7px; margin-top: 10px; padding-left: 1.15rem; list-style: disc; color: #334155; font-size: 14px; line-height: 1.65; }
    .legal-reference-list { display: grid; gap: 13px; margin-top: 14px; }
    .legal-reference-list li { display: flex; gap: 12px; color: #334155; font-size: 14px; line-height: 1.7; }
    .legal-reference-list li::before { content: ""; width: 6px; height: 6px; margin-top: 10px; border-radius: 999px; background: #0F2868; flex-shrink: 0; }
    .article-content { background: transparent; border: 0; border-radius: 0; padding: 20px 0 0; box-shadow: none; }
    .article-content h2 { font-size: 24px; line-height: 1.3; font-weight: 800; margin-top: 2.5rem; margin-bottom: 1rem; color: #071A3D; }
    .article-content h3 { font-size: 19px; line-height: 1.35; font-weight: 800; margin-top: 2rem; margin-bottom: .75rem; color: #071A3D; }
    .article-content p { margin-bottom: 1.3rem; color: #14213d; font-size: 17px; line-height: 1.85; text-align: justify; text-justify: inter-word; }
    .article-content > p:first-of-type { color: #14213d; font-size: 17px; line-height: 1.85; }
    .article-content > p:first-of-type::first-letter { float: left; margin: .08em .12em 0 0; color: #0F2868; font-size: 3.2rem; line-height: .9; font-weight: 700; }
    .article-content ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .article-content ol { list-style: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
    .article-content blockquote { border: 1px solid #dbe3ef; border-radius: 8px; background: #f8fbff; padding: 1.1rem 1.35rem; color: #0F2868; font-style: normal; font-weight: 700; margin: 2rem 0; }
    .article-content blockquote::before { content: "Kutipan Norma"; display: block; margin-bottom: .55rem; color: #64748b; font-size: 11px; font-weight: 900; letter-spacing: .08em; text-transform: uppercase; }
    .article-content sup { color: #0F2868; font-weight: 800; }
    .article-content sup a { border-bottom: 1px solid rgba(15, 40, 104, .35); }
    .article-content .footnotes, .article-content section.footnotes { margin-top: 2rem; border-top: 1px solid #e2e8f0; padding-top: 1rem; color: #475569; font-size: .92rem; }
    .article-content .footnotes ol, .article-content section.footnotes ol { list-style: decimal; padding-left: 1.25rem; }
    .article-content [id^="fn"], .article-content [role="doc-endnote"] { scroll-margin-top: 110px; }
    .inline-read-more { display: grid; grid-template-columns: 76px repeat(3, minmax(0, 1fr)); gap: 16px; align-items: center; margin: 34px 0 28px; border: 1px solid #dbe3ef; border-radius: 12px; background: #f8fbff; padding: 14px 16px; }
    .inline-read-more-label { color: #0F2868; font-size: 13px; font-weight: 900; }
    .inline-read-more-card { display: grid; grid-template-columns: 78px 1fr; gap: 12px; align-items: center; min-width: 0; }
    .inline-read-more-card img, .inline-read-more-thumb { width: 78px; height: 52px; object-fit: cover; border-radius: 6px; background: #eef3fb; }
    .inline-read-more-card strong { display: -webkit-box; overflow: hidden; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: #071A3D; font-size: 12px; line-height: 1.45; }
    .sidebar-panel { border: 1px solid #dbe3ef; border-radius: 8px; background: #fff; padding: 22px; }
    .article-toc.sidebar-panel { position: sticky; top: 88px; align-self: start; }
    .sidebar-title { color: #071A3D; font-size: 12px; font-weight: 900; letter-spacing: .06em; text-transform: uppercase; }
    .sidebar-list { margin-top: 14px; display: grid; gap: 14px; }
    .sidebar-link-card { display: grid; grid-template-columns: 74px 1fr; gap: 12px; align-items: start; padding-bottom: 14px; border-bottom: 1px solid #eef2f7; }
    .sidebar-link-card:last-child { padding-bottom: 0; border-bottom: 0; }
    .sidebar-link-card img, .sidebar-thumb { width: 74px; height: 52px; object-fit: cover; border-radius: 5px; background: #eef3fb; }
    .sidebar-link-card strong { display: -webkit-box; overflow: hidden; -webkit-line-clamp: 3; -webkit-box-orient: vertical; color: #071A3D; font-size: 13px; line-height: 1.35; }
    .sidebar-link-card span, .popular-meta { display: block; margin-top: 4px; color: #64748b; font-size: 11px; font-weight: 600; }
    .topic-tags { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 16px; }
    .topic-tag { display: inline-flex; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fbff; padding: 9px 11px; color: #0F2868; font-size: 12px; font-weight: 800; }
    .popular-list { margin-top: 16px; display: grid; gap: 16px; counter-reset: popular; }
    .popular-item { display: grid; grid-template-columns: 26px 1fr; gap: 10px; padding-bottom: 16px; border-bottom: 1px solid #eef2f7; }
    .popular-item:last-child { padding-bottom: 0; border-bottom: 0; }
    .popular-item::before { counter-increment: popular; content: counter(popular); color: #0F2868; font-size: 20px; font-weight: 900; line-height: 1; }
    .popular-item strong { color: #071A3D; font-size: 13px; line-height: 1.45; }
    .sidebar-more-link { margin-top: 18px; display: flex; align-items: center; justify-content: center; gap: 8px; border: 1px solid #dbe3ef; border-radius: 7px; padding: 10px 12px; color: #071A3D; font-size: 12px; font-weight: 900; }
    .submission-cta { margin-top: 30px; display: flex; align-items: center; justify-content: space-between; gap: 24px; border: 1px solid rgba(15, 40, 104, .18); border-radius: 8px; background: #0F2868; padding: 22px; color: #fff; }
    .submission-cta h2 { font-size: 16px; font-weight: 800; }
    .submission-cta p { margin-top: 6px; max-width: 620px; color: rgba(255,255,255,.78); font-size: 13px; line-height: 1.7; }
    .submission-cta-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 0; flex-shrink: 0; }
    .submission-cta a { display: inline-flex; border-radius: 8px; padding: 10px 14px; font-size: 13px; font-weight: 800; }
    .submission-cta a:first-child { background: #fff; color: #0F2868; }
    .submission-cta a:last-child { border: 1px solid rgba(255,255,255,.22); color: #fff; }
    .author-credibility { margin-top: 26px; display: grid; gap: 20px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; padding: 22px; box-shadow: none; }
    .author-credibility-header { display: flex; gap: 16px; align-items: flex-start; }
    .author-credibility-photo { width: 50px; height: 50px; border-radius: 999px; overflow: hidden; background: rgba(15, 40, 104, .1); color: #0F2868; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0; }
    .author-credibility-photo img { width: 100%; height: 100%; object-fit: cover; }
    .author-credibility h2 { color: #0f172a; font-size: 14px; font-weight: 800; margin-bottom: 4px; }
    .author-credibility p { color: #475569; font-size: 13px; line-height: 1.75; }
    .author-credibility .author-bio { max-width: 620px; display: -webkit-box; overflow: hidden; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .author-credibility small { display: block; color: #64748b; font-size: 10px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 6px; }
    .author-publications { margin-top: 16px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; padding: 18px 22px; box-shadow: none; }
    .author-publications small { display: block; color: #0F2868; font-size: 11px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 10px; }
    .author-publications a { display: block; padding: 9px 0; border-top: 1px solid #f1f5f9; color: #0f172a; font-size: 13px; font-weight: 700; transition: color .2s ease; }
    .author-publications a:hover { color: #0F2868; }
    .co-author-list { border-top: 1px solid #e2e8f0; padding-top: 18px; display: grid; gap: 14px; }
    .co-author-item { border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px; background: #f8fafc; }
    .co-author-item strong { display: block; color: #0f172a; }
    .co-author-item span { display: block; color: #64748b; font-size: 13px; margin-top: 2px; }
    .co-author-item p { margin-top: 8px; color: #475569; font-size: 14px; line-height: 1.65; }
    .reference-list { display: grid; gap: 12px; max-width: 1080px; }
    .reference-list a { display: grid; gap: 4px; border-bottom: 1px solid #e2e8f0; padding: 0 0 14px; }
    .reference-list small { color: #0F2868; font-size: 11px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
    .reference-list strong { color: #0f172a; font-size: 15px; line-height: 1.5; }
    .reference-list span { color: #64748b; font-size: 13px; }
    @media (max-width: 1024px) {
        .article-shell { grid-template-columns: 1fr; gap: 34px; }
        .article-sidebar { padding-top: 0; }
        .article-toc.sidebar-panel { position: static; }
    }
    @media (max-width: 760px) {
        .insight-container { padding: 32px 20px 42px; }
        .article-hero h1 { font-size: 32px; }
        .featured-image { height: auto; aspect-ratio: 16 / 9; }
        .article-content { padding-top: 4px; }
        .article-byline-row { align-items: flex-start; }
        .article-share { width: 100%; justify-content: space-between; }
        .inline-read-more { grid-template-columns: 1fr; }
        .inline-read-more-card { grid-template-columns: 84px 1fr; }
        .inline-read-more-card img, .inline-read-more-thumb { width: 84px; height: 56px; }
        .submission-cta { display: block; }
        .submission-cta-actions { margin-top: 18px; }
        .author-credibility-header { flex-direction: column; }
    }
	</style>

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $insight->title,
            'description' => $insight->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($insight->content), 155),
            'author' => collect([[
                '@type' => 'Person',
                'name' => $authorName,
                'affiliation' => $authorAffiliation,
            ]])->merge($coAuthors->map(fn ($author) => [
                '@type' => 'Person',
                'name' => $author['name'],
                'affiliation' => $author['affiliation'] ?? null,
            ]))->values()->all(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Edulaw Project',
                'url' => route('home'),
            ],
            'datePublished' => optional($publishedAt)->toIso8601String(),
            'dateModified' => optional($insight->updated_at)->toIso8601String(),
            'mainEntityOfPage' => route('insight.show', $insight->slug),
            'articleSection' => $topicName ?: $categoryName,
            'wordCount' => str_word_count(strip_tags($insight->content ?? '')),
            'image' => $insightImage ? asset('storage/' . $insightImage) : null,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <div class="reading-progress" aria-hidden="true">
        <div class="reading-progress-bar" data-reading-progress></div>
    </div>
	
    <section class="insight-detail" data-reading-surface>
    <div class="insight-container">
        <div class="article-shell">
            <main class="article-main">
                <nav class="article-breadcrumb" aria-label="Breadcrumb artikel">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('insights.index') }}">Insight</a>
                    @if($topicName)
                        <span>{{ $topicName }}</span>
                    @else
                        <span>{{ $categoryName }}</span>
                    @endif
                </nav>

                <div class="article-hero">
                    <div class="article-meta">
                        <span>{{ $categoryName }}</span>
                        @if($topicName)
                            <span>{{ $topicName }}</span>
                        @endif
                        <span>{{ $publishedDate }}</span>
                        <span>{{ $readingMinutes }} menit baca</span>
                    </div>

                    <h1>{{ $displayTitle }}</h1>

                    <div class="article-byline-row">
                        <div class="author-box">
                            <div class="author-avatar">
                                @if($authorPhoto)
                                    <img src="{{ asset('storage/' . $authorPhoto) }}" alt="{{ $authorName }}">
                                @else
                                    {{ strtoupper(substr($authorName, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                @if($insight->author_name)
                                    <a href="{{ route('authors.show', \Illuminate\Support\Str::slug($authorName)) }}" class="font-bold text-slate-950 transition hover:text-[#0F2868]">{{ $authorName }}</a>
                                @else
                                    <strong>{{ $authorName }}</strong>
                                @endif
                                <span>{{ $authorAffiliation }}</span>
                            </div>
                        </div>

                        <div class="article-share">
                            <span>Bagikan:</span>
                            <div class="article-share-buttons">
                                <a class="share-icon-button" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('insight.show', $insight->slug)) }}" target="_blank" rel="noopener" aria-label="Bagikan ke Facebook">f</a>
                                <a class="share-icon-button" href="https://twitter.com/intent/tweet?url={{ urlencode(route('insight.show', $insight->slug)) }}&text={{ urlencode($displayTitle) }}" target="_blank" rel="noopener" aria-label="Bagikan ke X">X</a>
                                <a class="share-icon-button" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('insight.show', $insight->slug)) }}" target="_blank" rel="noopener" aria-label="Bagikan ke LinkedIn">in</a>
                                <button type="button" class="share-icon-button" data-share-article aria-label="Salin tautan artikel">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 13a5 5 0 0 0 7.07 0l2.12-2.12a5 5 0 0 0-7.07-7.07L11 4.93M14 11a5 5 0 0 0-7.07 0L4.81 13.12a5 5 0 0 0 7.07 7.07L13 19.07"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    @if($coAuthors->isNotEmpty())
                        <div class="co-author-strip" aria-label="Penulis tambahan">
                            @foreach($coAuthors as $coAuthor)
                                <div class="co-author-chip">
                                    {{ $coAuthor['name'] }}
                                    @if(!empty($coAuthor['affiliation']))
                                        <span>{{ $coAuthor['affiliation'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

	            @if($insightImage)
                    <figure class="featured-image-wrap">
	                    <img src="{{ asset('storage/' . $insightImage) }}" class="featured-image" alt="{{ $insight->title }}">
                    <figcaption class="featured-caption">{{ $imageCaption }}</figcaption>
                    </figure>
	            @endif
	
	            <article class="article-content" data-article-content>
	                {!! $insight->content !!}
	            </article>

                @if($sidebarRelatedInsights->isNotEmpty())
                    <div class="inline-read-more" aria-label="Baca juga">
                        <div class="inline-read-more-label">Baca juga:</div>
                        @foreach($sidebarRelatedInsights as $related)
                            @php
                                $relatedImage = $related->thumbnail ?: $related->image;
                            @endphp
                            <a href="{{ route('insight.show', $related->slug) }}" class="inline-read-more-card">
                                @if($relatedImage)
                                    <img src="{{ asset('storage/' . $relatedImage) }}" alt="{{ $related->title }}">
                                @else
                                    <span class="inline-read-more-thumb"></span>
                                @endif
                                <strong>{{ $related->title }}</strong>
                            </a>
                        @endforeach
                    </div>
                @endif

                <section class="article-note-box" aria-label="Catatan reflektif">
                    <small>Catatan Reflektif</small>
                    @if($articleSummary)
                        <p>{{ $articleSummary }}</p>
                    @else
                        <ul>
                            <li>Apa dampak isu ini terhadap praktik hukum dan kebijakan publik?</li>
                            <li>Bagaimana prinsip keadilan, kepastian, dan kemanfaatan dapat diseimbangkan?</li>
                            <li>Ruang partisipasi apa yang masih bisa diperkuat oleh warga dan komunitas akademik?</li>
                        </ul>
                    @endif
                </section>

                @if($legalReferences->isNotEmpty())
                    <section class="article-note-box mt-6" aria-label="Dasar hukum terkait">
                        <small>Dasar Hukum Terkait</small>
                        <ul class="legal-reference-list">
                            @foreach($legalReferences as $reference)
                                <li>{{ $reference }}</li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                <section class="submission-cta">
                    <div class="submission-cta-copy">
                        <h2>Punya pandangan tentang isu hukum dan kebijakan publik?</h2>
                        <p>Kirim tulisan untuk dibaca dan didiskusikan bersama pembaca Edulaw Project.</p>
                    </div>
                    <div class="submission-cta-actions">
                        <a href="{{ url('/admin/register') }}">Kirim Tulisan</a>
                        <a href="{{ route('community.index') }}">Panduan Penulisan</a>
                    </div>
                </section>

                <section class="author-credibility">
                    <div class="author-credibility-header">
                        <div class="author-credibility-photo">
                            @if($authorPhoto)
                                <img src="{{ asset('storage/' . $authorPhoto) }}" alt="{{ $authorName }}">
                            @else
                                {{ strtoupper(substr($authorName, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <small>Tentang Penulis</small>
                            <h2>
                                @if($insight->author_name)
                                    <a href="{{ route('authors.show', \Illuminate\Support\Str::slug($authorName)) }}" class="transition hover:text-[#0F2868]">{{ $authorName }}</a>
                                @else
                                    {{ $authorName }}
                                @endif
                            </h2>
                            <p class="text-sm font-semibold text-slate-500">{{ $authorAffiliation }}</p>
                            @if($authorExpertise)
                                <p class="mt-1 text-sm font-semibold text-[#0F2868]">{{ $authorExpertise }}</p>
                            @endif
                            <p class="author-bio mt-3">{{ $authorBio }}</p>
                            @if($insight->author_name)
                                <a href="{{ route('authors.show', \Illuminate\Support\Str::slug($authorName)) }}" class="mt-4 inline-flex text-sm font-bold text-[#0F2868] transition hover:text-[#071A3D]">
                                    Lihat Profil Penulis →
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($coAuthors->isNotEmpty())
                        <div class="co-author-list">
                            <small>Penulis Tambahan</small>
                            @foreach($coAuthors as $coAuthor)
                                <div class="co-author-item">
                                    <strong>{{ $coAuthor['name'] }}</strong>
                                    @if(!empty($coAuthor['affiliation']))
                                        <span>{{ $coAuthor['affiliation'] }}</span>
                                    @endif
                                    @if(!empty($coAuthor['expertise']))
                                        <span>{{ $coAuthor['expertise'] }}</span>
                                    @endif
                                    @if(!empty($coAuthor['bio']))
                                        <p>{{ $coAuthor['bio'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                </section>

                @if(($authorInsights ?? collect())->isNotEmpty())
                    <section class="author-publications">
                        <small>Tulisan lain dari penulis</small>
                        @foreach($authorInsights as $authorInsight)
                            <a href="{{ route('insight.show', $authorInsight->slug) }}">
                                {{ $authorInsight->title }}
                            </a>
                        @endforeach
                    </section>
                @endif
            </main>

            <aside class="article-sidebar" aria-label="Sidebar artikel">
                <nav class="article-toc sidebar-panel" data-article-toc aria-label="Daftar isi artikel">
                    <div class="sidebar-title">Daftar Isi -></div>
                    <div class="article-toc-list" data-article-toc-list></div>
                </nav>

                @if($sidebarRelatedInsights->isNotEmpty())
                    <section class="sidebar-panel">
                        <div class="sidebar-title">Baca Juga -></div>
                        <div class="sidebar-list">
                            @foreach($sidebarRelatedInsights as $related)
                                @php
                                    $relatedImage = $related->thumbnail ?: $related->image;
                                @endphp
                                <a href="{{ route('insight.show', $related->slug) }}" class="sidebar-link-card">
                                    @if($relatedImage)
                                        <img src="{{ asset('storage/' . $relatedImage) }}" alt="{{ $related->title }}">
                                    @else
                                        <span class="sidebar-thumb"></span>
                                    @endif
                                    <strong>{{ $related->title }}</strong>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('insights.index') }}" class="sidebar-more-link">Lihat semua artikel →</a>
                    </section>
                @endif

                @if($topicTags->isNotEmpty())
                    <section class="sidebar-panel">
                        <div class="sidebar-title">Topik Terkait</div>
                        <div class="topic-tags">
                            @foreach($topicTags as $tag)
                                <span class="topic-tag">#{{ $tag }}</span>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($popularInsights->isNotEmpty())
                    <section class="sidebar-panel">
                        <div class="sidebar-title">Paling Banyak Dibaca</div>
                        <div class="popular-list">
                            @foreach($popularInsights as $popular)
                                @php
                                    $popularDate = $popular->published_at ?? $popular->created_at;
                                @endphp
                                <a href="{{ route('insight.show', $popular->slug) }}" class="popular-item">
                                    <div>
                                        <strong>{{ $popular->title }}</strong>
                                        <span class="popular-meta">{{ $popular->category?->name ?: 'Insight' }} / {{ \Carbon\Carbon::parse($popularDate)->translatedFormat('d M Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('insights.index') }}" class="sidebar-more-link">Lihat semua →</a>
                    </section>
                @endif
            </aside>
        </div>
    </div>
</section>

@if(($relatedReferences ?? collect())->isNotEmpty())
<section class="bg-slate-50 py-12 border-t border-slate-200">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="edulaw-eyebrow">Bacaan Lanjutan</span>
                <h2 class="mt-2 text-2xl font-bold text-slate-900">Publikasi terkait</h2>
                <p class="mt-1 text-sm text-slate-500">Dokumen dan publikasi yang dapat memperkaya pemahaman atas isu ini.</p>
            </div>
            <a href="{{ route('research.index') }}" class="text-sm font-bold text-[#0F2868] transition hover:text-[#071A3D]">Masuk ke Research Hub</a>
        </div>

        @if($relatedReferences->count() <= 2)
            <div class="reference-list">
                @foreach($relatedReferences as $reference)
                    <a href="{{ route('research.show', $reference) }}">
                        <small>{{ $reference->year }} / {{ number_format($reference->download_count ?? 0, 0, ',', '.') }} unduhan</small>
                        <strong>{{ $reference->title }}</strong>
                        <span>{{ \Illuminate\Support\Str::limit($reference->abstract ?: $reference->preview_note ?: 'Publikasi riset Edulaw Project.', 120) }}</span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="grid gap-4 md:grid-cols-3">
                @foreach($relatedReferences as $reference)
                    <a href="{{ route('research.show', $reference) }}" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#0F2868]/25 hover:shadow-lg">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#0F2868]">{{ $reference->year }} • {{ number_format($reference->download_count ?? 0, 0, ',', '.') }} unduhan</p>
                        <h3 class="mt-3 line-clamp-3 font-bold leading-snug text-slate-950">{{ $reference->title }}</h3>
                        <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-500">{{ \Illuminate\Support\Str::limit($reference->abstract ?: $reference->preview_note ?: 'Publikasi riset Edulaw Project.', 120) }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif

@if($relatedInsights->isNotEmpty())
<section class="bg-white py-14 border-t border-slate-200">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Insight Terkait</h2>
                <p class="text-sm text-slate-500 mt-1">Bacaan lanjutan dari redaksi Edulaw.</p>
            </div>
            <a href="{{ route('insights.index') }}" class="hidden md:inline-flex text-sm font-bold text-slate-900 hover:text-edulaw-blue transition">Lihat semua insight</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedInsights as $related)
                @php
                    $relatedImage = $related->thumbnail ?: $related->image;
                    $relatedAuthor = $related->author_name ?: ($related->author?->name ?: ($related->author ?: 'Edulaw Project'));
                    $relatedDate = $related->published_at ?? $related->created_at;
                    $relatedMinutes = max(1, (int) ceil(str_word_count(strip_tags($related->content ?? '')) / 200));
                @endphp
                <article class="flex h-full flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-[#0F2868]/25 hover:shadow-lg">
                    <div class="aspect-video bg-slate-100 overflow-hidden">
                        @if($relatedImage)
                            <img src="{{ asset('storage/' . $relatedImage) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-[#0F2868]/10 to-teal-100 text-xs font-bold uppercase tracking-widest text-[#0F2868]">Edulaw Insight</div>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-5">
                        <div class="mb-3 flex flex-wrap items-center gap-2 text-[10px] font-bold uppercase tracking-[0.12em]">
                            <span class="text-edulaw-blue">{{ $related->category?->name ?: 'Insight' }}</span>
                            <span class="text-slate-300">/</span>
                            <span class="text-slate-400">{{ \Carbon\Carbon::parse($relatedDate)->translatedFormat('d M Y') }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 leading-snug">
                            <a href="{{ route('insight.show', $related->slug) }}" class="hover:text-edulaw-blue transition">{{ $related->title }}</a>
                        </h3>
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                            <span class="text-[11px] font-semibold text-slate-500">{{ $relatedAuthor }} / ± {{ $relatedMinutes }} menit</span>
                            <a href="{{ route('insight.show', $related->slug) }}" class="text-xs font-bold text-[#0F2868] transition hover:text-[#071A3D]">Baca Insight →</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
	</section>
	@endif

    <script>
        (() => {
            const progressBar = document.querySelector('[data-reading-progress]');
            const article = document.querySelector('[data-article-content]');
            const toc = document.querySelector('[data-article-toc]');
            const tocList = document.querySelector('[data-article-toc-list]');
            const shareButton = document.querySelector('[data-share-article]');

            const updateProgress = () => {
                if (!progressBar || !article) return;

                const articleTop = article.offsetTop;
                const articleHeight = article.offsetHeight - window.innerHeight;
                const progress = Math.min(Math.max((window.scrollY - articleTop) / Math.max(articleHeight, 1), 0), 1);

                progressBar.style.width = `${progress * 100}%`;
            };

            if (article && toc && tocList) {
                const headings = [...article.querySelectorAll('h2, h3')];

                headings.forEach((heading, index) => {
                    if (!heading.id) {
                        heading.id = `section-${index + 1}-${heading.textContent.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-')}`;
                    }

                    const link = document.createElement('a');
                    link.href = `#${heading.id}`;
                    link.textContent = heading.textContent;
                    link.dataset.level = heading.tagName;
                    tocList.appendChild(link);
                });

                if (headings.length > 0) {
                    toc.classList.add('is-visible');
                }
            }

            updateProgress();
            window.addEventListener('scroll', updateProgress, { passive: true });
            window.addEventListener('resize', updateProgress);

            shareButton?.addEventListener('click', async () => {
                const shareData = {
                    title: document.title,
                    url: window.location.href,
                };

                if (navigator.share) {
                    await navigator.share(shareData);
                    return;
                }

                await navigator.clipboard?.writeText(window.location.href);
                const originalContent = shareButton.innerHTML;
                shareButton.textContent = 'OK';

                setTimeout(() => {
                    shareButton.innerHTML = originalContent;
                }, 1800);
            });
        })();
    </script>
	@endsection
