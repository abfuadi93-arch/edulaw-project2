<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ResearchResource;
use App\Models\Research;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPublicationsWidget extends BaseWidget
{
    protected static ?string $heading = 'Publikasi Terbaru';

    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 2,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Research::query()
                    ->latest('published_at')
                    ->latest('created_at')
                    ->limit(5)
            )
            ->heading('Publikasi Terbaru')
            ->headerActions([
                Action::make('all')
                    ->label('Lihat semua')
                    ->url(ResearchResource::getUrl('index'))
                    ->button()
                    ->color('gray')
                    ->size('sm'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->limit(110)
                    ->wrap()
                    ->searchable()
                    ->grow()
                    ->width('65%')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('document_type')
                    ->label('Kategori')
                    ->formatStateUsing(fn (?string $state): string => Research::documentTypeLabel($state))
                    ->badge()
                    ->width('20%')
                    ->color('info'),

                Tables\Columns\TextColumn::make('download_count')
                    ->label('Download')
                    ->numeric()
                    ->icon('heroicon-m-arrow-down-tray')
                    ->width('15%')
                    ->sortable(),
            ])
            ->emptyStateIcon('heroicon-o-document-magnifying-glass')
            ->emptyStateHeading('Belum ada publikasi')
            ->emptyStateDescription('Mulai tambahkan publikasi riset untuk ditampilkan di website.')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Tambah Publikasi')
                    ->url(ResearchResource::getUrl('create'))
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-m-book-open'),
            ])
            ->paginated(false);
    }
}
