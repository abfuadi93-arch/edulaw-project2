<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ContributorWritingGuideWidget extends Widget
{
    protected static string $view = 'filament.widgets.contributor-writing-guide-widget';

    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 4,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isContributor();
    }
}
