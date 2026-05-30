<?php

namespace App\Filament\Widgets;

use App\Models\Insight;
use App\Models\Research;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EdulawOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 4,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor();
    }

    protected function getStats(): array
    {
        $totalInsights = Insight::count();
        $publishedInsights = Insight::where('status', 'published')->count();
        $totalPublications = Research::count();
        $publishedPublications = Research::published()->count();
        $totalViews = Insight::where('status', 'published')->sum('views_count');
        $totalDownloads = Research::published()->sum('download_count');

        return [
            Stat::make('Insight Terbit', number_format($publishedInsights, 0, ',', '.'))
                ->description('Artikel terpublikasi')
                ->descriptionIcon('heroicon-m-document-text')
                ->icon('heroicon-o-document-text')
                ->chart([2, 3, 4, 6, 5, 8, max(8, $publishedInsights)])
                ->color('primary'),

            Stat::make('Publikasi Riset', number_format($publishedPublications, 0, ',', '.'))
                ->description('Dokumen terunggah')
                ->descriptionIcon('heroicon-m-book-open')
                ->icon('heroicon-o-book-open')
                ->chart([1, 1, 2, 2, 3, 3, max(3, $publishedPublications)])
                ->color('success'),

            Stat::make('Pembaca Artikel', number_format($totalViews, 0, ',', '.'))
                ->description('Total views insight')
                ->descriptionIcon('heroicon-m-eye')
                ->icon('heroicon-o-eye')
                ->chart([4, 8, 6, 13, 9, 16, max(16, (int) $totalViews)])
                ->color('warning'),

            Stat::make('Unduhan Publikasi', number_format($totalDownloads, 0, ',', '.'))
                ->description('Total file diunduh')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->icon('heroicon-o-arrow-down-tray')
                ->chart([0, 1, 1, 2, 2, 3, max(3, (int) $totalDownloads)])
                ->color('info'),
        ];
    }
}
