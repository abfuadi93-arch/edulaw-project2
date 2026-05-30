<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FounderResource\Pages;
use App\Models\Founder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FounderResource extends Resource
{
    protected static ?string $model = Founder::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Founder & Co-Founder';

    protected static ?string $modelLabel = 'Founder';

    protected static ?string $pluralModelLabel = 'Founder & Co-Founder';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil')
                    ->description('Data ini tampil di halaman Tentang dan halaman detail founder/co-founder.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (?string $state, callable $set) => $set('slug', Str::slug($state ?? ''))),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('role')
                            ->label('Peran')
                            ->options([
                                'Founder' => 'Founder',
                                'Co-Founder' => 'Co-Founder',
                            ])
                            ->native(false)
                            ->required(),

                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Contoh: Founder Edulaw Project')
                            ->maxLength(255),

                        TextInput::make('affiliation')
                            ->label('Afiliasi')
                            ->default('Edulaw Project')
                            ->maxLength(255),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('published')
                            ->native(false)
                            ->required(),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Konten Halaman')
                    ->schema([
                        FileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->imageEditor()
                            ->avatar()
                            ->disk('public')
                            ->directory('founders')
                            ->helperText('Foto lama dari folder public/images/founders tetap didukung. Upload baru akan tersimpan di storage/app/public/founders.')
                            ->columnSpanFull(),

                        Textarea::make('bio')
                            ->label('Bio')
                            ->rows(5)
                            ->maxLength(1500)
                            ->columnSpanFull(),

                        TagsInput::make('expertise')
                            ->label('Bidang Fokus')
                            ->placeholder('Tambahkan fokus')
                            ->helperText('Contoh: Literasi Hukum, Kebijakan Publik, Konstitusi.')
                            ->columnSpanFull(),

                        Textarea::make('quote')
                            ->label('Kutipan')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(2),
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

                ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->size(40)
                    ->getStateUsing(fn (Founder $record): ?string => $record->photo_url ?: null),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Founder $record): string => trim(($record->title ?: $record->role) . ' · ' . ($record->affiliation ?: 'Edulaw Project'))),

                TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Founder' ? 'info' : 'success')
                    ->sortable(),

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
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFounders::route('/'),
            'create' => Pages\CreateFounder::route('/create'),
            'edit' => Pages\EditFounder::route('/{record}/edit'),
        ];
    }
}
