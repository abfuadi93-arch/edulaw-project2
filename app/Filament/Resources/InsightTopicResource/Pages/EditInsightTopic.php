<?php

namespace App\Filament\Resources\InsightTopicResource\Pages;

use App\Filament\Resources\InsightTopicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInsightTopic extends EditRecord
{
    protected static string $resource = InsightTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn (): bool => auth()->user()?->isAdmin()),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
