<?php

namespace App\Filament\Resources\FounderResource\Pages;

use App\Filament\Resources\FounderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFounder extends EditRecord
{
    protected static string $resource = FounderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
