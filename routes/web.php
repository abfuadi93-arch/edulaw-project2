<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Models\Category;
use App\Models\Founder;
use App\Models\Hero;
use App\Models\Insight;
use App\Models\Program;
use App\Models\Research;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes (Jalur Website)
|--------------------------------------------------------------------------
*/
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
    ->name('auth.google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('auth.google.callback');

Route::get('/password-reset/{token}', function (string $token) {
    return redirect()->route('filament.admin.auth.password-reset.reset', [
        'token' => $token,
        'email' => request('email'),
    ]);
})->name('password.reset');

Route::get('/storage/{path}', function (string $path) {
    abort_if(str_contains($path, '..'), 404);
    abort_unless(Storage::disk('public')->exists($path), 404);

    return response()->file(Storage::disk('public')->path($path));
})->where('path', '.*')->name('storage.public');

// 1. HOME: Halaman Depan
Route::get('/', function () {
    $popularResearchThisMonth = Research::published()
        ->where('published_at', '>=', now()->subDays(30))
        ->orderByDesc('download_count')
        ->first()
        ?: Research::published()
            ->orderByDesc('download_count')
            ->first();

    return view('home', [
        'programs' => Program::published()
            ->where('show_on_home', true)
            ->orderByDesc('featured')
            ->latest()
            ->take(2)
            ->get(),
        'insights' => Insight::where('status', 'published')
            ->with('category')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->take(8)
            ->get(),
        'researches' => Research::published()
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->get(),
        'totalResearchDownloads' => Research::published()->sum('download_count'),
        'totalResearchDocuments' => Research::published()->count(),
        'popularResearchThisMonth' => $popularResearchThisMonth,
        'heroSlides' => Hero::active()
            ->orderBy('sort_order')
            ->limit(5)
            ->get(),
        'testimonials' => Testimonial::where('status', 'published')
            ->orderBy('sort_order')
            ->limit(3)
            ->get(),
    ]);
})->name('home');

// 2. PROGRAMS: Halaman Daftar Program (Menu "Program")
Route::get('/programs', function () {
    $today = now()->toDateString();
    $activePrograms = Program::published()
        ->where(function ($query) use ($today) {
            $query
                ->where('event_status', 'upcoming')
                ->orWhere(function ($builder) use ($today) {
                    $builder
                        ->whereNotNull('start_date')
                        ->whereNotNull('end_date')
                        ->whereDate('end_date', '>=', $today)
                        ->whereNull('event_status');
                });
        })
        ->orderByRaw("CASE WHEN event_status = 'upcoming' THEN 0 ELSE 1 END")
        ->orderByRaw('CASE WHEN start_date <= ? THEN 0 ELSE 1 END', [$today])
        ->orderBy('start_date')
        ->orderBy('sort_order')
        ->get();

    $portfolioPrograms = Program::published()
        ->where(function ($query) use ($today) {
            $query
                ->whereIn('event_status', ['completed', 'portfolio'])
                ->orWhere(function ($builder) use ($today) {
                    $builder
                        ->where(function ($legacy) use ($today) {
                            $legacy
                                ->whereDate('end_date', '<', $today)
                                ->orWhereNull('start_date')
                                ->orWhereNull('end_date');
                        })
                        ->where(function ($legacyStatus) {
                            $legacyStatus
                                ->whereNull('event_status')
                                ->orWhere('event_status', '!=', 'upcoming');
                        });
                });
        })
        ->latest('start_date')
        ->orderBy('sort_order')
        ->get();

    return view('programs.index', [
        'activePrograms' => $activePrograms,
        'portfolioPrograms' => $portfolioPrograms,
        'programs' => $activePrograms->concat($portfolioPrograms),
    ]);
})->name('programs.index'); // <-- Ini yang tadi dicari Laravel

Route::get('/programs/{program}', function (string $program) {
    $program = Program::published()
        ->where(function ($query) use ($program) {
            $query->where('slug', $program);

            if (is_numeric($program)) {
                $query->orWhere('id', (int) $program);
            }
        })
        ->firstOrFail();

    abort_unless($program->publication_status === 'published', 404);

    return view('programs.show', compact('program'));
})->name('programs.show');

Route::get('/search', function () {
    $query = trim((string) request('q'));
    $scope = request('scope', 'all');

    return view('search.index', [
        'query' => $query,
        'scope' => $scope,
        'insights' => $query === '' || ! in_array($scope, ['all', 'insight', 'putusan', 'topik'], true)
            ? collect()
            : Insight::where('status', 'published')
                ->with('category')
                ->where(function ($builder) use ($query) {
                    $builder
                        ->where('title', 'like', "%{$query}%")
                        ->orWhere('excerpt', 'like', "%{$query}%")
                        ->orWhere('summary', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%")
                        ->orWhere('author_name', 'like', "%{$query}%");
                })
                ->orderByRaw('COALESCE(published_at, created_at) DESC')
                ->limit(8)
                ->get(),
        'publications' => $query === '' || ! in_array($scope, ['all', 'publikasi', 'putusan', 'topik'], true)
            ? collect()
            : Research::published()
                ->where(function ($builder) use ($query) {
                    $builder
                        ->where('title', 'like', "%{$query}%")
                        ->orWhere('authors', 'like', "%{$query}%")
                        ->orWhere('abstract', 'like', "%{$query}%")
                        ->orWhere('preview_note', 'like', "%{$query}%")
                        ->orWhere('citation', 'like', "%{$query}%");
                })
                ->orderByRaw('COALESCE(published_at, created_at) DESC')
                ->limit(8)
                ->get(),
        'programs' => $query === '' || ! in_array($scope, ['all', 'program', 'topik'], true)
            ? collect()
            : Program::published()
                ->where(function ($builder) use ($query) {
                    $builder
                        ->where('title', 'like', "%{$query}%")
                        ->orWhere('short_title', 'like', "%{$query}%")
                        ->orWhere('subtitle', 'like', "%{$query}%")
                        ->orWhere('program_family', 'like', "%{$query}%")
                        ->orWhere('program_type', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('detailed_description', 'like', "%{$query}%");
                })
                ->orderBy('sort_order')
                ->limit(8)
                ->get(),
        'issueSuggestions' => [
            'Putusan MK',
            'Revisi UU TNI',
            'AI & Hukum',
            'Demokrasi Digital',
            'Kebijakan Publik',
        ],
    ]);
})->name('search.index');

Route::post('/newsletter', function () {
    request()->validate([
        'email' => ['required', 'email'],
    ]);

    return back()->with('newsletter_status', 'Terima kasih. Anda sudah tercatat untuk menerima Weekly Legal Intelligence Edulaw.');
})->name('newsletter.subscribe');

Route::get('/community', function () {
    return view('community', [
        'contributorCount' => \App\Models\User::where('role', 'contributor')->count(),
        'submittedCount' => Insight::whereIn('status', ['submitted', 'under_review', 'revision'])->count(),
        'publishedContributorInsights' => Insight::where('status', 'published')
            ->whereNotNull('author_name')
            ->where('author_name', '!=', '')
            ->count(),
    ]);
})->name('community.index');

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['id', 'en'], true), 404);

    session(['locale' => $locale]);

    return back();
})->name('language.switch');

Route::get('/founders/{founder:slug}', function (Founder $founder) {
    abort_unless($founder->status === 'published', 404);

    $otherFounders = Founder::published()
        ->whereKeyNot($founder->id)
        ->ordered()
        ->get();

    return view('founders.show', [
        'founder' => $founder,
        'otherFounders' => $otherFounders,
    ]);
})->name('founders.show');

// 3. INSIGHTS: Halaman Daftar Berita (Menu "Insight")
Route::get('/insights', function () {
    $featuredInsight = Insight::where('status', 'published')
        ->with('category')
        ->orderByDesc('featured')
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->first();

    $query = Insight::query()
        ->with('category')
        ->where('status', 'published');

    if ($featuredInsight) {
        $query->whereKeyNot($featuredInsight->id);
    }

    if (request('search')) {
        $query->where(function ($builder) {
            $builder
                ->where('title', 'like', '%'.request('search').'%')
                ->orWhere('excerpt', 'like', '%'.request('search').'%')
                ->orWhere('summary', 'like', '%'.request('search').'%')
                ->orWhere('content', 'like', '%'.request('search').'%')
                ->orWhere('author_name', 'like', '%'.request('search').'%');
        });
    }

    if (request('category')) {
        $query->where('category_id', request('category'));
    }

    if (request('topic')) {
        $query->whereJsonContains('topic', request('topic'));
    }

    if (request('year')) {
        $query->whereRaw('YEAR(COALESCE(published_at, created_at)) = ?', [request('year')]);
    }

    if (request('author')) {
        $query->where('author_name', request('author'));
    }

    if (request('reading_time') === 'short') {
        $query->whereRaw('CHAR_LENGTH(COALESCE(content, "")) <= 6000');
    }

    if (request('reading_time') === 'medium') {
        $query->whereRaw('CHAR_LENGTH(COALESCE(content, "")) BETWEEN 6001 AND 12000');
    }

    if (request('reading_time') === 'long') {
        $query->whereRaw('CHAR_LENGTH(COALESCE(content, "")) > 12000');
    }

    match (request('sort')) {
        'oldest' => $query->orderByRaw('COALESCE(published_at, created_at) ASC'),
        'reading_asc' => $query->orderByRaw('CHAR_LENGTH(COALESCE(content, "")) ASC'),
        default => $query->orderByRaw('COALESCE(published_at, created_at) DESC'),
    };

    return view('insights.index', [
        'featuredInsight' => $featuredInsight,
        'insights' => $query->paginate(9)->withQueryString(),
        'categories' => Category::orderBy('name')->get(),
        'years' => Insight::where('status', 'published')
            ->whereRaw('COALESCE(published_at, created_at) IS NOT NULL')
            ->selectRaw('YEAR(COALESCE(published_at, created_at)) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->filter(),
        'authors' => Insight::where('status', 'published')
            ->whereNotNull('author_name')
            ->where('author_name', '!=', '')
            ->distinct()
            ->orderBy('author_name')
            ->pluck('author_name'),
        'topics' => Insight::where('status', 'published')
            ->whereNotNull('topic')
            ->get(['topic'])
            ->flatMap(fn (Insight $insight): array => $insight->topic_tags)
            ->filter()
            ->map(fn (string $topic): string => trim($topic))
            ->unique()
            ->sort()
            ->values(),
        'popularInsights' => Insight::where('status', 'published')
            ->with('category')
            ->when($featuredInsight, fn ($builder) => $builder->whereKeyNot($featuredInsight->id))
            ->orderByDesc('featured')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(4)
            ->get(),
        'trendingIssues' => [
            ['label' => 'Revisi UU TNI', 'query' => 'revisi uu tni'],
            ['label' => 'Putusan MK', 'query' => 'putusan mahkamah konstitusi'],
            ['label' => 'AI & Hukum', 'query' => 'ai hukum'],
            ['label' => 'Demokrasi Digital', 'query' => 'demokrasi digital'],
        ],
    ]);
})->name('insights.index');

Route::get('/authors/{authorSlug}', function (string $authorSlug) {
    $authorName = Insight::where('status', 'published')
        ->whereNotNull('author_name')
        ->where('author_name', '!=', '')
        ->pluck('author_name')
        ->unique()
        ->first(fn ($name) => Str::slug($name) === $authorSlug);

    abort_unless($authorName, 404);

    $authorInsights = Insight::where('status', 'published')
        ->with('category')
        ->where('author_name', $authorName)
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->paginate(9);

    $profileInsight = $authorInsights->first();
    $authorBaseQuery = Insight::where('status', 'published')
        ->where('author_name', $authorName);
    $firstPublishedAt = (clone $authorBaseQuery)
        ->oldest('created_at')
        ->value('published_at') ?: (clone $authorBaseQuery)->oldest('created_at')->value('created_at');
    $latestPublishedAt = (clone $authorBaseQuery)
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->value('published_at') ?: (clone $authorBaseQuery)
        ->latest('created_at')
        ->value('created_at');

    return view('authors.show', [
        'authorName' => $authorName,
        'authorSlug' => $authorSlug,
        'authorInsights' => $authorInsights,
        'authorAffiliation' => $profileInsight?->author_affiliation ?: 'Edulaw Project',
        'authorPhoto' => $profileInsight?->author_photo,
        'firstPublishedAt' => $firstPublishedAt,
        'latestPublishedAt' => $latestPublishedAt,
        'totalViews' => (clone $authorBaseQuery)
            ->sum('views_count'),
        'popularInsights' => (clone $authorBaseQuery)
            ->orderByDesc('views_count')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(3)
            ->get(),
        'categories' => (clone $authorBaseQuery)
            ->with('category')
            ->get()
            ->map(fn ($insight) => $insight->category?->name)
            ->filter()
            ->unique()
            ->values(),
    ]);
})->name('authors.show');

// 4. INSIGHT DETAIL: Halaman Baca Artikel
Route::get('/insight/{slug}', function (string $slug) {
    $insight = Insight::with('category')
        ->where('slug', $slug)
        ->when(is_numeric($slug), fn ($query) => $query->orWhere('id', $slug))
        ->firstOrFail();

    if ($insight->slug && $slug !== $insight->slug) {
        return redirect()->route('insight.show', $insight->slug);
    }

    abort_unless(
        $insight->status === 'published'
            || auth()->user()?->isAdmin()
            || auth()->user()?->isEditor(),
        404
    );

    if ($insight->status === 'published') {
        $insight->increment('views_count');
    }

    $relatedInsights = Insight::where('status', 'published')
        ->with('category')
        ->whereKeyNot($insight->id)
        ->when($insight->category_id, fn ($query) => $query->where('category_id', $insight->category_id))
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->limit(3)
        ->get();

    if ($relatedInsights->count() < 3) {
        $fallbackInsights = Insight::where('status', 'published')
            ->with('category')
            ->whereKeyNot($insight->id)
            ->whereNotIn('id', $relatedInsights->pluck('id'))
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(3 - $relatedInsights->count())
            ->get();

        $relatedInsights = $relatedInsights->concat($fallbackInsights);
    }

    $authorInsights = collect();

    if ($insight->author_name) {
        $authorInsights = Insight::where('status', 'published')
            ->whereKeyNot($insight->id)
            ->where('author_name', $insight->author_name)
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(4)
            ->get();
    }

    $insightCategoryName = $insight->relationLoaded('category') && $insight->getRelation('category')
        ? $insight->getRelation('category')->name
        : '';

    $relatedReferences = Research::published()
        ->where(function ($query) use ($insight, $insightCategoryName) {
            $query
                ->where('title', 'like', '%'.$insight->title.'%')
                ->orWhere('abstract', 'like', '%'.$insightCategoryName.'%')
                ->orWhere('preview_note', 'like', '%'.$insightCategoryName.'%');
        })
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->limit(3)
        ->get();

    if ($relatedReferences->isEmpty()) {
        $relatedReferences = Research::published()
            ->orderByDesc('download_count')
            ->limit(3)
            ->get();
    }

    return view('detail', compact('insight', 'relatedInsights', 'authorInsights', 'relatedReferences'));
})->name('insight.show');

// 5. RESEARCH: Halaman Daftar Riset (Menu "Riset")
Route::get('/research', function () {
    $popularThisMonth = Research::published()
        ->where('published_at', '>=', now()->subDays(30))
        ->orderByDesc('download_count')
        ->first();
    $featuredPublication = $popularThisMonth
        ?: Research::published()
            ->orderByDesc('download_count')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->first();

    $researchQuery = Research::published()
        ->when(request('q'), fn ($query, $search) => $query->where(function ($builder) use ($search) {
            $builder
                ->where('title', 'like', "%{$search}%")
                ->orWhere('authors', 'like', "%{$search}%")
                ->orWhere('abstract', 'like', "%{$search}%")
                ->orWhere('preview_note', 'like', "%{$search}%");
        }))
        ->when(request('type'), fn ($query, $type) => $query->where(fn ($builder) => $builder
            ->where('document_type', $type)
            ->orWhere('category', $type)))
        ->when(request('issue'), fn ($query, $issue) => $query->where(function ($builder) use ($issue) {
            $builder
                ->where('title', 'like', "%{$issue}%")
                ->orWhere('abstract', 'like', "%{$issue}%")
                ->orWhere('preview_note', 'like', "%{$issue}%")
                ->orWhere('keywords', 'like', "%{$issue}%");
        }))
        ->when(request('language'), fn ($query, $language) => $query->where('language', $language))
        ->when(request('year'), fn ($query, $year) => $query->where('year', $year))
        ->when(request('date_from'), fn ($query, $date) => $query->whereRaw('DATE(COALESCE(published_at, created_at)) >= ?', [$date]))
        ->when(request('date_to'), fn ($query, $date) => $query->whereRaw('DATE(COALESCE(published_at, created_at)) <= ?', [$date]));

    return view('research.index', [
        'researches' => $researchQuery
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(10)
            ->withQueryString(),
        'totalDownloads' => Research::published()->sum('download_count'),
        'totalDocuments' => Research::published()->count(),
        'popularThisMonth' => $popularThisMonth,
        'featuredPublication' => $featuredPublication,
        'documentTypes' => Research::documentTypeOptions(),
        'languages' => Research::LANGUAGES,
        'years' => Research::published()->distinct()->orderByDesc('year')->pluck('year')->filter(),
        'collections' => Research::documentTypeOptions(),
        'publicationCategories' => Research::documentTypeOptions(),
        'issueCategories' => [
            'Hukum Tata Negara',
            'Pemilu & Pilkada',
            'Mahkamah Konstitusi',
            'HAM Digital',
            'Legislasi',
            'Demokrasi',
            'Peradilan',
            'Antikorupsi',
        ],
    ]);
})->name('research.index');

Route::get('/research/{publication}', function (Research $publication) {
    abort_unless($publication->status === 'published', 404);

    $relatedPublications = Research::published()
        ->whereKeyNot($publication->id)
        ->when($publication->category ?: $publication->document_type, fn ($query, $type) => $query->where(function ($builder) use ($type) {
            $builder
                ->where('category', $type)
                ->orWhere('document_type', $type);
        }))
        ->orderByRaw('COALESCE(published_at, created_at) DESC')
        ->limit(3)
        ->get();

    return view('research.show', [
        'publication' => $publication,
        'relatedPublications' => $relatedPublications,
        'documentTypes' => Research::documentTypeOptions(),
        'languages' => Research::LANGUAGES,
    ]);
})->name('research.show');

Route::get('/research/{publication}/download', function (Research $publication) {
    abort_unless($publication->status === 'published', 404);

    $publication->increment('download_count');

    return redirect(asset('storage/'.$publication->file));
})->name('research.download');

Route::get('/research/{publication}/citation', function (Research $publication) {
    abort_unless($publication->status === 'published', 404);

    $citation = $publication->citation
        ?: sprintf(
            'Edulaw Project. (%s). %s. Edulaw Project.%s',
            $publication->year ?: optional($publication->published_at)->format('Y') ?: now()->year,
            $publication->title,
            $publication->doi ? ' https://doi.org/'.$publication->doi : ''
        );

    return response($citation, 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="edulaw-citation-'.$publication->id.'.txt"',
    ]);
})->name('research.citation');

// 6. TENTANG: Halaman Profil (Menu "Tentang")
Route::get('/tentang', function () {
    return view('tentang', [
        'founders' => Founder::published()->ordered()->get(),
        'publishedInsightsCount' => Insight::where('status', 'published')->count(),
        'publishedResearchCount' => Research::published()->count(),
        'totalResearchDownloads' => Research::published()->sum('download_count'),
        'latestResearchYear' => Research::published()->max('year'),
    ]);
})->name('tentang');
