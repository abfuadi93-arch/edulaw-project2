<?php

namespace App\Filament\Resources\InsightResource\Pages;

use App\Filament\Resources\InsightResource;
use App\Models\Insight;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListInsights extends ListRecords
{
    protected static string $resource = InsightResource::class;

    protected static string $view = 'filament.resources.insight-resource.pages.list-insights';

    public function getInsightSummaryCards(): array
    {
        $query = $this->getSummaryQuery();

        return [
            [
                'label' => 'Total Artikel',
                'value' => (clone $query)->count(),
                'tone' => 'blue',
            ],
            [
                'label' => 'Draft',
                'value' => (clone $query)->where('status', 'draft')->count(),
                'tone' => 'gray',
            ],
            [
                'label' => 'Dalam Review',
                'value' => (clone $query)->whereIn('status', ['submitted', 'under_review'])->count(),
                'tone' => 'orange',
            ],
            [
                'label' => 'Terbit',
                'value' => (clone $query)->where('status', 'published')->count(),
                'tone' => 'green',
            ],
            [
                'label' => 'Perlu Revisi',
                'value' => (clone $query)->where('status', 'revision')->count(),
                'tone' => 'rose',
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    private function getSummaryQuery(): Builder
    {
        return Insight::query()
            ->when(auth()->user()?->isContributor(), fn (Builder $query): Builder => $query->where('author_id', auth()->id()));
    }
}
