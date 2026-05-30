<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InsightResource;
use App\Models\Insight;
use Filament\Widgets\Widget;

class ContributorNextStepsWidget extends Widget
{
    protected static string $view = 'filament.widgets.contributor-next-steps-widget';

    protected static ?int $sort = 4;

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
        $draft = Insight::query()
            ->where('author_id', auth()->id())
            ->whereIn('status', ['draft', 'revision'])
            ->latest('updated_at')
            ->first();

        return [
            'draft' => $draft,
            'createUrl' => InsightResource::getUrl('create'),
            'draftUrl' => $draft ? InsightResource::getUrl('edit', ['record' => $draft]) : null,
            'isProfileComplete' => collect([
                $user?->author_bio,
                $user?->author_affiliation,
                $user?->author_expertise,
                $user?->author_photo,
            ])->every(fn ($field): bool => filled($field)),
        ];
    }
}
