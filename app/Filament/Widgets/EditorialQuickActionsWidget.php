<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class EditorialQuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.editorial-quick-actions-widget';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 4,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor();
    }
}
