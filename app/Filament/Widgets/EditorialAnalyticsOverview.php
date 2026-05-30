<?php

namespace App\Filament\Widgets;

use App\Models\Insight;
use App\Models\Research;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EditorialAnalyticsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor();
    }

    protected function getStats(): array
    {
        $totalViews = Insight::where('status', 'published')->sum('views_count');
        $totalDownloads = Research::published()->sum('download_count');
        $popularArticle = Insight::where('status', 'published')
            ->orderByDesc('views_count')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->first();

        return [
            Stat::make('Total Views Artikel', number_format($totalViews, 0, ',', '.'))
                ->description('Akumulasi views insight terbit')
                ->icon('heroicon-o-eye')
                ->color('primary'),

            Stat::make('Download Publikasi', number_format($totalDownloads, 0, ',', '.'))
                ->description('Akumulasi unduhan PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),

            Stat::make('Artikel Populer', $popularArticle?->title ? str($popularArticle->title)->limit(42) : 'Belum ada data')
                ->description(($popularArticle?->views_count ?? 0) . ' views')
                ->icon('heroicon-o-newspaper')
                ->color('warning'),

            Stat::make('Engagement', number_format($totalViews + $totalDownloads, 0, ',', '.'))
                ->description('Views artikel + download publikasi')
                ->icon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }
}
