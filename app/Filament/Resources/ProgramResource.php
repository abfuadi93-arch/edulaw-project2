<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Filament\Resources\ProgramResource\RelationManagers;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $recordRouteKeyName = 'slug';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Program';

    protected static ?string $modelLabel = 'Program';

    protected static ?string $pluralModelLabel = 'Program';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas Kegiatan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('program_family')
                                    ->label('Rumpun Program')
                                    ->options([
                                        'Lecturer' => 'Lecturer',
                                        'Discussion' => 'Discussion',
                                        'Training' => 'Training',
                                    ])
                                    ->helperText('Lecturer untuk kuliah/panggung besar, Discussion untuk forum dialogis, Training untuk kelas atau pelatihan.')
                                    ->native(false),

                                Select::make('program_type')
                                    ->label('Jenis Program')
                                    ->options([
                                        'Inspiring Lecture' => 'Inspiring Lecture',
                                        'Public Lecture' => 'Public Lecture',
                                        'Keynote Forum' => 'Keynote Forum',
                                        'Launching Forum' => 'Launching Forum',
                                        'Diskusi Diseminasi Disertasi' => 'Diskusi Diseminasi Disertasi',
                                        'Diskusi Diseminasi Tesis' => 'Diskusi Diseminasi Tesis',
                                        'Diskusi Literasi Konstitusi' => 'Diskusi Literasi Konstitusi',
                                        'Diskusi Respons Isu' => 'Diskusi Respons Isu',
                                        'Bedah Buku Hukum' => 'Bedah Buku Hukum',
                                        'Ngabuburit Virtual' => 'Ngabuburit Virtual',
                                        'Kelas Tematik' => 'Kelas Tematik',
                                        'Workshop' => 'Workshop',
                                        'Klinik Akademik' => 'Klinik Akademik',
                                        'Pelatihan Riset' => 'Pelatihan Riset',
                                        'Pelatihan Penulisan Hukum' => 'Pelatihan Penulisan Hukum',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->helperText('Pilih jenis paling dekat dengan karakter kegiatan.')
                                    ->searchable()
                                    ->native(false),

                                TextInput::make('title')
                                    ->label('Judul Kegiatan')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old): void {
                                        if (blank($state)) {
                                            return;
                                        }

                                        $currentSlug = (string) $get('slug');
                                        if (filled($currentSlug) && $currentSlug !== Str::slug((string) $old)) {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    })
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->label('Slug / URL')
                                    ->helperText('Otomatis dari judul, tetapi boleh diedit manual.')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                TextInput::make('short_title')
                                    ->label('Judul Pendek')
                                    ->placeholder('Inspiring Lecture #1')
                                    ->maxLength(255),

                                TextInput::make('subtitle')
                                    ->label('Tema / Subjudul')
                                    ->placeholder('Dinamika Perubahan Konstitusi di Berbagai Negara')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Detail Pelaksanaan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('duration')
                                    ->label('Durasi')
                                    ->placeholder('1 sesi')
                                    ->maxLength(255),

                                TextInput::make('level')
                                    ->label('Level')
                                    ->placeholder('Umum')
                                    ->datalist([
                                        'Umum',
                                        'Intermediate',
                                        'Advanced',
                                    ])
                                    ->helperText('Umum untuk kegiatan terbuka, Intermediate untuk pembahasan dengan dasar hukum, Advanced untuk riset/disertasi atau kajian teoritis.')
                                    ->maxLength(255),

                                Select::make('format')
                                    ->label('Format')
                                    ->options([
                                        'Online' => 'Online',
                                        'Offline' => 'Offline',
                                        'Hybrid' => 'Hybrid',
                                    ])
                                    ->default('Online')
                                    ->native(false)
                                    ->required(),

                                DatePicker::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->native(),

                                DatePicker::make('end_date')
                                    ->label('Tanggal Selesai')
                                    ->native(),

                                Select::make('event_status')
                                    ->label('Status Kegiatan')
                                    ->options([
                                        'upcoming' => 'Akan Datang',
                                        'completed' => 'Selesai',
                                        'portfolio' => 'Portfolio',
                                    ])
                                    ->default('portfolio')
                                    ->native(false)
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Narasumber')
                    ->schema([
                        Repeater::make('speakers')
                            ->label('Daftar Narasumber')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama')
                                    ->placeholder('Pan Mohamad Faiz, S.H., M.C.L., Ph.D.')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('title')
                                    ->label('Jabatan/Afiliasi')
                                    ->placeholder('Kepala Pusat Penelitian Pengkajian Perkara dan Pengelolaan Perpustakaan Mahkamah Konstitusi')
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Narasumber')
                            ->reorderable()
                            ->collapsible()
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('moderator_name')
                                    ->label('Nama Moderator')
                                    ->maxLength(255),

                                TextInput::make('moderator_affiliation')
                                    ->label('Afiliasi Moderator')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Media')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Poster Kegiatan')
                                    ->image()
                                    ->disk('public')
                                    ->directory('programs/posters'),

                                FileUpload::make('hero_image')
                                    ->label('Gambar Hero')
                                    ->helperText('Opsional. Jika kosong, halaman publik memakai poster kegiatan.')
                                    ->image()
                                    ->disk('public')
                                    ->directory('programs/heroes'),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Konten Halaman')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('detailed_description')
                            ->label('Deskripsi Detail')
                            ->rows(5)
                            ->columnSpanFull(),

                        TagsInput::make('highlights')
                            ->label('Apa yang Dipelajari')
                            ->placeholder('Tambahkan poin pembelajaran')
                            ->helperText('Tekan Enter setelah menulis setiap poin.')
                            ->columnSpanFull(),

                        Grid::make(3)
                            ->schema([
                                Textarea::make('orientation')
                                    ->label('Orientasi')
                                    ->rows(3),

                                Textarea::make('method')
                                    ->label('Metode')
                                    ->rows(3),

                                Textarea::make('output')
                                    ->label('Output')
                                    ->rows(3),
                            ]),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Link dan CTA')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('registration_url')
                                    ->label('Link Pendaftaran')
                                    ->url()
                                    ->maxLength(255),

                                TextInput::make('youtube_url')
                                    ->label('Link Dokumentasi YouTube')
                                    ->url()
                                    ->maxLength(255),

                                TextInput::make('material_url')
                                    ->label('Link Materi')
                                    ->url()
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('primary_button_text')
                                    ->label('Teks Tombol Utama')
                                    ->maxLength(255),

                                TextInput::make('primary_button_url')
                                    ->label('Link Tombol Utama')
                                    ->maxLength(255),

                                TextInput::make('secondary_button_text')
                                    ->label('Teks Tombol Kedua')
                                    ->maxLength(255),

                                TextInput::make('secondary_button_url')
                                    ->label('Link Tombol Kedua')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Pengaturan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Urutan Otomatis')
                                    ->numeric()
                                    ->minValue(1)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder('Diisi otomatis')
                                    ->helperText('Urutan tampil dibuat otomatis saat program disimpan.'),

                                Select::make('publication_status')
                                    ->label('Status Publikasi')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                    ])
                                    ->default('published')
                                    ->native(false)
                                    ->required(),

                                Toggle::make('featured')
                                    ->label('Featured')
                                    ->default(false),

                                Toggle::make('show_on_home')
                                    ->label('Tampilkan di Beranda')
                                    ->default(false),
                            ]),
                    ])
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
                    ->width('56px'),

                TextColumn::make('title')
                    ->label('Kegiatan')
                    ->searchable()
                    ->weight('bold')
                    ->wrap()
                    ->description(fn (Program $record): string => Str::limit((string) ($record->short_title ?: $record->description), 96)),

                TextColumn::make('program_family')
                    ->label('Klasifikasi')
                    ->badge()
                    ->placeholder('-')
                    ->color(fn (?string $state): string => match ($state) {
                        'Lecturer' => 'info',
                        'Training' => 'success',
                        default => 'warning',
                    })
                    ->description(fn (Program $record): string => $record->program_type ?: '-'),

                TextColumn::make('format')
                    ->label('Pelaksanaan')
                    ->formatStateUsing(fn (?string $state, Program $record): string => collect([
                        $state,
                        $record->duration,
                        $record->level,
                    ])->filter()->join(' / ') ?: '-')
                    ->wrap()
                    ->description(fn (Program $record): string => $record->start_date?->format('d M Y') ?: '-'),

                TextColumn::make('event_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'upcoming' => 'Akan Datang',
                        'completed' => 'Selesai',
                        default => 'Portfolio',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'upcoming' => 'info',
                        'completed' => 'success',
                        default => 'gray',
                    })
                    ->description(fn (Program $record): string => $record->show_on_home ? 'Beranda' : ($record->featured ? 'Featured' : '')),

                TextColumn::make('publication_status')
                    ->label('Publikasi')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state === 'draft' ? 'Draft' : 'Published')
                    ->color(fn (?string $state): string => $state === 'draft' ? 'warning' : 'success'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(28),
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
