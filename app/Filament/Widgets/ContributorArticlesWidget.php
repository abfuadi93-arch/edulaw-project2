<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InsightResource;
use App\Models\Insight;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ContributorArticlesWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.contributor-articles-widget';

    protected static ?string $heading = 'Tulisan Saya';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 4,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isContributor();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Insight::query()
                    ->with('category')
                    ->where('author_id', auth()->id())
                    ->latest('updated_at')
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->limit(110)
                    ->wrap()
                    ->width('42%')
                    ->weight('bold')
                    ->description(fn (Insight $record): ?string => filled($record->revision_notes) && $record->status === 'revision'
                        ? 'Catatan editor: ' . str($record->revision_notes)->limit(90)
                        : null),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->placeholder('Belum dikategorikan')
                    ->width('18%')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->width('16%')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'submitted' => 'Diajukan',
                        'under_review' => 'Dalam Review',
                        'revision' => 'Perlu Revisi',
                        'published' => 'Terbit',
                        'rejected' => 'Ditolak',
                        default => str($state)->headline(),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'submitted', 'under_review' => 'warning',
                        'revision' => 'danger',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->width('16%')
                    ->since()
                    ->sortable(),
            ])
            ->searchable(false)
            ->actions([
                Tables\Actions\Action::make('next_action')
                    ->label(fn (Insight $record): string => match ($record->status) {
                        'draft' => 'Lanjutkan',
                        'revision' => 'Revisi',
                        'submitted', 'under_review' => 'Lihat Status',
                        'published' => 'Lihat',
                        default => 'Detail',
                    })
                    ->icon(fn (Insight $record): string => match ($record->status) {
                        'draft', 'revision' => 'heroicon-m-pencil-square',
                        'published' => 'heroicon-m-arrow-top-right-on-square',
                        default => 'heroicon-m-eye',
                    })
                    ->color(fn (Insight $record): string => match ($record->status) {
                        'revision' => 'danger',
                        'submitted', 'under_review' => 'warning',
                        'published' => 'success',
                        default => 'primary',
                    })
                    ->iconButton()
                    ->tooltip(fn (Insight $record): string => match ($record->status) {
                        'draft' => 'Lanjutkan tulisan',
                        'revision' => 'Revisi tulisan',
                        'submitted', 'under_review' => 'Lihat status tulisan',
                        'published' => 'Lihat artikel',
                        default => 'Lihat detail',
                    })
                    ->url(fn (Insight $record): string => in_array($record->status, ['draft', 'revision'], true)
                        ? InsightResource::getUrl('edit', ['record' => $record])
                        : ($record->status === 'published' ? route('insight.show', $record->slug) : InsightResource::getUrl('index')))
                    ->openUrlInNewTab(fn (Insight $record): bool => $record->status === 'published'),

                Tables\Actions\Action::make('submit_review')
                    ->label('Submit Review')
                    ->icon('heroicon-m-paper-airplane')
                    ->iconButton()
                    ->tooltip('Kirim ke editor')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Submit tulisan ke editor?')
                    ->modalDescription('Setelah dikirim, tulisan akan masuk antrean kurasi editorial dan tidak bisa dipublikasikan sendiri. Seluruh tulisan merupakan opini pribadi penulis, proses editorial dilakukan untuk menjaga akurasi, relevansi, etika, dan kualitas argumentasi.')
                    ->modalSubmitActionLabel('Submit Review')
                    ->visible(fn (Insight $record): bool => $record->author_id === auth()->id()
                        && in_array($record->status, ['draft', 'revision'], true))
                    ->action(fn (Insight $record): bool => $record->update([
                        'status' => 'submitted',
                    ])),
            ])
            ->emptyStateIcon('heroicon-o-document-plus')
            ->emptyStateHeading('Belum ada tulisan')
            ->emptyStateDescription('Mulai tulis insight pertama Anda untuk dikirim ke editor Edulaw.')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Tulis Insight')
                    ->icon('heroicon-o-pencil-square')
                    ->url(InsightResource::getUrl('create')),
            ])
            ->paginated(false);
    }
}
