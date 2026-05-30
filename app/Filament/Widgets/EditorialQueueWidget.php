<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InsightResource;
use App\Models\Insight;
use Filament\Widgets\Widget;

class EditorialQueueWidget extends Widget
{
    protected static string $view = 'filament.widgets.editorial-queue-widget';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 2,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor();
    }

    protected function getViewData(): array
    {
        $items = Insight::query()
            ->whereIn('status', ['draft', 'submitted', 'under_review', 'revision'])
            ->latest('updated_at')
            ->limit(3)
            ->get();

        return [
            'items' => $items,
            'queueCount' => Insight::whereIn('status', ['draft', 'submitted', 'under_review', 'revision'])->count(),
            'insightsUrl' => InsightResource::getUrl('index'),
            'statusLabels' => [
                'draft' => 'Draft',
                'submitted' => 'Pending',
                'under_review' => 'Dalam Review',
                'revision' => 'Revisi',
            ],
        ];
    }
}
