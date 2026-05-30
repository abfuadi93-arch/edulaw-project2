<?php

namespace App\Filament\Widgets;

use App\Models\Hero;
use App\Models\Insight;
use App\Models\Program;
use App\Models\Research;
use Filament\Widgets\Widget;

class EditorialActivityWidget extends Widget
{
    protected static string $view = 'filament.widgets.editorial-activity-widget';

    protected static ?int $sort = 6;

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
        $activities = collect()
            ->merge($this->latestFor(Insight::class, 'menambahkan insight baru'))
            ->merge($this->latestFor(Research::class, 'memperbarui publikasi riset'))
            ->merge($this->latestFor(Hero::class, 'mengunggah hero slider baru'))
            ->merge($this->latestFor(Program::class, 'memperbarui informasi program'))
            ->sortByDesc('updated_at')
            ->take(4)
            ->values();

        return ['activities' => $activities];
    }

    private function latestFor(string $model, string $action): array
    {
        return $model::query()
            ->latest('updated_at')
            ->limit(1)
            ->get()
            ->map(fn ($record): array => [
                'action' => $action,
                'title' => $record->title ?? $record->name ?? null,
                'updated_at' => $record->updated_at,
                'icon' => match ($model) {
                    Insight::class => 'heroicon-o-plus-circle',
                    Research::class => 'heroicon-o-pencil-square',
                    Hero::class => 'heroicon-o-photo',
                    Program::class => 'heroicon-o-academic-cap',
                    default => 'heroicon-o-clock',
                },
            ])
            ->all();
    }
}
