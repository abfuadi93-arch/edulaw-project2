<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InsightResource;
use App\Models\Insight;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularContentWidget extends BaseWidget
{
    protected static ?string $heading = 'Insight Populer';

    protected static ?int $sort = 5;

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
                Insight::query()
                    ->with('category')
                    ->where('status', 'published')
                    ->orderByDesc('views_count')
                    ->orderByRaw('COALESCE(published_at, created_at) DESC')
                    ->limit(6)
            )
            ->heading('Insight Populer')
            ->headerActions([
                Action::make('all')
                    ->label('Lihat semua')
                    ->url(InsightResource::getUrl('index'))
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

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->width('20%')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->icon('heroicon-m-eye')
                    ->width('15%')
                    ->sortable(),
            ])
            ->emptyStateIcon('heroicon-o-newspaper')
            ->emptyStateHeading('Belum ada insight populer')
            ->emptyStateDescription('Insight yang sudah terbit akan tampil berdasarkan jumlah views.')
            ->paginated(false);
    }
}
