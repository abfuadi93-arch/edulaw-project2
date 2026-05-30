@extends('layouts.app')
@section('title', 'Edulaw Insight - Esai, Opini, dan Analisis Hukum')

@section('content')
@php
    $activeFilters = collect([
        request('search'),
        request('category'),
        request('topic'),
        request('year'),
        request('author'),
        request('reading_time'),
        request('sort'),
    ])->filter()->count();

    $insightCardData = function ($insight) {
        $image = $insight->thumbnail ?: $insight->image;
        $authorName = $insight->author_name ?: ($insight->author?->name ?: ($insight->author ?: 'Edulaw Project'));
        $authorAffiliation = $insight->author_affiliation ?: 'Edulaw Project';
        $date = $insight->published_at ?? $insight->created_at;
        $wordCount = str_word_count(strip_tags($insight->content ?? ''));
        $readingMinutes = max(1, (int) ceil($wordCount / 200));
        $excerpt = \Illuminate\Support\Str::limit(strip_tags($insight->excerpt ?: ($insight->summary ?: $insight->content)), 132);
        $categoryName = $insight->relationLoaded('category') && $insight->getRelation('category')
            ? $insight->getRelation('category')->name
            : 'Insight';
        $topicName = $insight->topic_label ?: 'Umum';

        return compact('image', 'authorName', 'authorAffiliation', 'date', 'wordCount', 'readingMinutes', 'excerpt', 'categoryName', 'topicName');
    };

    $featured = $featuredInsight ? $insightCardData($featuredInsight) : null;
@endphp

<div class="bg-slate-50">
    <x-insights.hero
        :featured-insight="$featuredInsight"
        :featured="$featured"
        :total-insights="$insights->total() + ($featuredInsight ? 1 : 0)"
        :topics-count="$topics->count()"
    />

    <x-insights.quick-filter-search
        :categories="$categories"
        :years="$years"
        :authors="$authors"
        :active-filters="$activeFilters"
    />

    <section class="container mx-auto px-6 py-8 lg:py-10">
        <div class="grid gap-7 lg:grid-cols-[260px_1fr]">
            <x-insights.sidebar-filter
                :categories="$categories"
                :topics="$topics"
                :years="$years"
                :authors="$authors"
                :active-filters="$activeFilters"
            />

            <div>
                <div id="artikel-terbaru" class="mb-6 flex scroll-mt-32 items-center justify-between gap-3">
                    <span class="edulaw-eyebrow">Artikel Terbaru</span>
                    <p class="text-sm font-semibold text-slate-500">
                        {{ $insights->total() }} tulisan ditemukan
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                    @forelse($insights as $insight)
                        <x-insights.article-card
                            :insight="$insight"
                            :card="$insightCardData($insight)"
                        />
                    @empty
                        <div class="rounded-lg border border-slate-200 bg-white p-8 text-center md:col-span-2 xl:col-span-3">
                            <h3 class="text-2xl font-bold text-slate-950">Belum ada insight yang cocok</h3>
                            <p class="mt-2 text-sm text-slate-500">Coba ubah kata kunci atau filter pencarian.</p>
                        </div>
                    @endforelse
                </div>

                @if($insights->hasPages())
                    <div class="mt-10">
                        {{ $insights->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <x-insights.bottom-sections
        :popular-insights="$popularInsights"
        :topics="$topics"
        :trending-issues="$trendingIssues"
        :card-data="$insightCardData"
    />
</div>
@endsection
