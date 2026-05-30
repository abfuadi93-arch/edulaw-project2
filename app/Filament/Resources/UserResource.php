<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Pengaturan Website';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'User';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

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
        return auth()->user()?->isAdmin() && $record->id !== auth()->id();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Akun')
                    ->description('Data login dan peran pengguna di dashboard Edulaw.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Admin',
                                'editor' => 'Editor',
                                'contributor' => 'Contributor / Penulis',
                            ])
                            ->default('contributor')
                            ->native(false)
                            ->required(),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Bio Penulis')
                    ->description('Profil publik penulis untuk memperkuat kredibilitas artikel dan contributor.')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        TextInput::make('author_affiliation')
                            ->label('Afiliasi Penulis')
                            ->placeholder('Contoh: Edulaw Project / Fakultas Hukum / Lembaga Riset')
                            ->maxLength(255),

                        TextInput::make('author_expertise')
                            ->label('Bidang Keahlian')
                            ->placeholder('Contoh: Hukum Tata Negara, Pemilu, Kebijakan Publik')
                            ->helperText('Pisahkan beberapa bidang dengan koma.')
                            ->maxLength(255),

                        Textarea::make('author_bio')
                            ->label('Bio Singkat')
                            ->placeholder('Tuliskan ringkasan profil penulis, fokus kajian, atau pengalaman yang relevan.')
                            ->rows(5)
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        FileUpload::make('author_photo')
                            ->label('Foto Profil Penulis')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('authors')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->helperText('Gunakan foto profesional. Format JPG, PNG, atau WebP maksimal 2MB.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('author_affiliation')
                    ->label('Afiliasi')
                    ->placeholder('-')
                    ->limit(28)
                    ->toggleable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'editor' => 'info',
                        'contributor' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Admin',
                        'editor' => 'Editor',
                        'contributor' => 'Contributor / Penulis',
                        default => $state,
                    })
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
