<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Models\Hero;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Hero Slider';

    protected static ?string $modelLabel = 'Hero Slide';

    protected static ?string $pluralModelLabel = 'Hero Slider';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Judul Slide')
                    ->placeholder('Contoh: Ruang belajar hukum berbasis riset')
                    ->required()
                    ->maxLength(255),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->helperText('Beranda hanya menampilkan maksimal 5 slide aktif.')
                    ->required(),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),

                FileUpload::make('image')
                    ->label('Foto Hero')
                    ->image()
                    ->imageEditor()
                    ->directory('heroes')
                    ->disk('public')
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'image/jpg',
                    ])
                    ->helperText('Gunakan gambar horizontal. Rasio ideal 4:3 atau 16:10. Rekomendasi ukuran file maksimal 5 MB.')
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('subtitle')
                    ->label('Keterangan')
                    ->rows(3)
                    ->placeholder('Keterangan singkat opsional untuk kebutuhan internal atau caption.')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->height(56),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}
