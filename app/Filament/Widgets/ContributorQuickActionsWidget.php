<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ContributorQuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.contributor-quick-actions-widget';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 4,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isContributor();
    }

    protected function getViewData(): array
    {
        $user = auth()->user();
        $profileFields = [
            $user?->author_bio,
            $user?->author_affiliation,
            $user?->author_expertise,
            $user?->author_photo,
        ];

        return [
            'isProfileComplete' => collect($profileFields)->every(fn ($field): bool => filled($field)),
        ];
    }
}
