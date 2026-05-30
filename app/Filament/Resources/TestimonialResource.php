<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Testimoni';

    protected static ?string $modelLabel = 'Testimoni';

    protected static ?string $pluralModelLabel = 'Testimonials';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?int $navigationSort = 7;

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->placeholder('Contoh: Abdul Basid Fuadi')
                    ->required()
                    ->maxLength(255),

                TextInput::make('role')
                    ->label('Peran/Institusi')
                    ->placeholder('Contoh: Mahasiswa Hukum UI / Edulaw Project')
                    ->maxLength(255),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->helperText('Gunakan angka positif: 1, 2, 3, 4, dan seterusnya.')
                    ->required(),

                Textarea::make('content')
                    ->label('Isi Testimoni')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('avatar')
                    ->label('Foto/Avatar Opsional')
                    ->image()
                    ->imageEditor()
                    ->avatar()
                    ->disk('public')
                    ->directory('testimonials')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->alignCenter()
                    ->width('64px'),

                ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular()
                    ->size(36),

                TextColumn::make('name')
                    ->label('Nama')
                    ->size('sm')
                    ->weight('medium')
                    ->limit(32)
                    ->description(function (Testimonial $record): string {
                        $detail = collect([$record->role, $record->content])
                            ->filter()
                            ->implode(' · ');

                        return Str::limit($detail, 82);
                    })
                    ->searchable()
                    ->sortable()
                    ->wrap(false),

                TextColumn::make('role')
                    ->label('Peran/Institusi')
                    ->searchable()
                    ->limit(28)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('content')
                    ->label('Testimoni')
                    ->limit(48)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                    ])
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
