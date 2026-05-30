<?php

namespace App\Filament\Widgets;

use App\Models\Insight;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContributorOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 4,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isContributor();
    }

    protected function getStats(): array
    {
        $authorId = auth()->id();
        $baseQuery = Insight::query()->where('author_id', $authorId);
        $total = (clone $baseQuery)->count();
        $drafts = (clone $baseQuery)->where('status', 'draft')->count();
        $inReview = (clone $baseQuery)->whereIn('status', ['submitted', 'under_review'])->count();
        $published = (clone $baseQuery)->where('status', 'published')->count();

        return [
            Stat::make('Semua Tulisan', number_format($total, 0, ',', '.') . ' artikel')
                ->description('Total naskah Anda')
                ->color('primary'),

            Stat::make('Draft', number_format($drafts, 0, ',', '.') . ' draft')
                ->description($drafts === 0 ? 'Belum ada draft' : 'Masih bisa diedit')
                ->color('gray'),

            Stat::make('Menunggu Review', number_format($inReview, 0, ',', '.') . ' naskah')
                ->description($inReview === 0 ? 'Belum ada review' : 'Menunggu editor')
                ->color('warning'),

            Stat::make('Terbit', number_format($published, 0, ',', '.') . ' artikel')
                ->description('Sudah dipublikasikan')
                ->color('success'),
        ];
    }
}
