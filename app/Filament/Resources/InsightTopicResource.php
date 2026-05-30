<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsightTopicResource\Pages;
use App\Models\InsightTopic;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class InsightTopicResource extends Resource
{
    protected static ?string $model = InsightTopic::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Topik';

    protected static ?string $modelLabel = 'Topik Insight';

    protected static ?string $pluralModelLabel = 'Topik Insight';

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?int $navigationSort = 6;

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor();
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Topik')
                    ->placeholder('Contoh: Konstitusi, Pemilu, Hukum Digital')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Topik')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (): bool => auth()->user()?->isAdmin()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->isAdmin()),
                ])
                    ->visible(fn (): bool => auth()->user()?->isAdmin()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInsightTopics::route('/'),
            'create' => Pages\CreateInsightTopic::route('/create'),
            'edit' => Pages\EditInsightTopic::route('/{record}/edit'),
        ];
    }
}
