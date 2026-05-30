<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ContributorProfileCompletenessWidget extends Widget
{
    protected static string $view = 'filament.widgets.contributor-profile-completeness-widget';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 2,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isContributor();
    }

    protected function getViewData(): array
    {
        $user = auth()->user();
        $items = [
            'Bio' => filled($user?->author_bio),
            'Afiliasi' => filled($user?->author_affiliation),
            'Keahlian' => filled($user?->author_expertise),
            'Foto' => filled($user?->author_photo),
        ];

        $completed = collect($items)->filter()->count();

        return [
            'items' => $items,
            'percentage' => (int) round(($completed / count($items)) * 100),
            'profileUrl' => url('/admin/profile'),
        ];
    }
}
