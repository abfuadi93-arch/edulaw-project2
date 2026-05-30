<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ContributorArticlesWidget;
use App\Filament\Widgets\ContributorNextStepsWidget;
use App\Filament\Widgets\ContributorOverviewWidget;
use App\Filament\Widgets\ContributorProfileCompletenessWidget;
use App\Filament\Widgets\ContributorQuickActionsWidget;
use App\Filament\Widgets\ContributorWritingGuideWidget;
use App\Filament\Widgets\AccessSnapshotWidget;
use App\Filament\Widgets\EdulawOverviewWidget;
use App\Filament\Widgets\EditorialActivityWidget;
use App\Filament\Widgets\EditorialQueueWidget;
use App\Filament\Widgets\EditorialQuickActionsWidget;
use App\Filament\Widgets\LatestPublicationsWidget;
use App\Filament\Widgets\PopularContentWidget;
use App\Filament\Widgets\SecurityIssuesWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Dashboard';

    protected static ?int $navigationSort = 0;

    public static function getNavigationGroup(): ?string
    {
        return auth()->user()?->isContributor() ? 'Overview' : null;
    }

    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'md' => 2,
            'xl' => 4,
        ];
    }

    public function getWidgets(): array
    {
        return [
            EditorialQuickActionsWidget::class,
            EdulawOverviewWidget::class,
            EditorialQueueWidget::class,
            EditorialActivityWidget::class,
            PopularContentWidget::class,
            LatestPublicationsWidget::class,
            SecurityIssuesWidget::class,
            AccessSnapshotWidget::class,
            ContributorQuickActionsWidget::class,
            ContributorOverviewWidget::class,
            ContributorProfileCompletenessWidget::class,
            ContributorNextStepsWidget::class,
            ContributorArticlesWidget::class,
            ContributorWritingGuideWidget::class,
        ];
    }
}
