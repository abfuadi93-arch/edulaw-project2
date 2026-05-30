<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Kategori';

    protected static ?string $modelLabel = 'Kategori';

    protected static ?string $pluralModelLabel = 'Kategori';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 3;

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
                    ->label('Nama Kategori')
                    ->placeholder('Contoh: Opini, Insight, Analisis, Review Putusan')
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
                    ->label('Kategori')
                    ->limit(80)
                    ->lineClamp(1)
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->width('55%'),

                TextColumn::make('insights_count')
                    ->label('Jumlah Artikel')
                    ->counts('insights')
                    ->sortable()
                    ->width('25%'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->actionsColumnLabel('Aksi')
            ->actionsAlignment('end')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->link()
                    ->size('sm'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
