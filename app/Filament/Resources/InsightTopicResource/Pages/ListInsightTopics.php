<?php

namespace App\Filament\Resources\InsightTopicResource\Pages;

use App\Filament\Resources\InsightTopicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInsightTopics extends ListRecords
{
    protected static string $resource = InsightTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
