<?php

namespace App\Filament\Resources\InsightTopicResource\Pages;

use App\Filament\Resources\InsightTopicResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInsightTopic extends CreateRecord
{
    protected static string $resource = InsightTopicResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
