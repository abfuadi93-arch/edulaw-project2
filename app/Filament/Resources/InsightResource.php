<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsightResource\Pages;
use App\Models\Insight;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class InsightResource extends Resource
{
    private const STATUS_OPTIONS = [
        'draft' => 'Draft',
        'submitted' => 'Diajukan ke Editorial',
        'under_review' => 'Sedang Direview',
        'revision' => 'Perlu Revisi',
        'published' => 'Dipublikasikan',
        'rejected' => 'Ditolak',
    ];

    protected static ?string $model = Insight::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Edulaw Insight';

    protected static ?string $modelLabel = 'Insight';

    protected static ?string $pluralModelLabel = 'Insight & Artikel';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return auth()->user()?->isContributor() ? 'Edulaw Insight' : static::$navigationGroup;
    }

    public static function getNavigationLabel(): string
    {
        return auth()->user()?->isContributor() ? 'Tulisan Saya' : static::$navigationLabel;
    }

    public static function getNavigationSort(): ?int
    {
        return auth()->user()?->isContributor() ? 1 : static::$navigationSort;
    }

    private static function topicOptions(): array
    {
        return Insight::query()
            ->whereNotNull('topic')
            ->get(['topic'])
            ->flatMap(fn (Insight $insight): array => $insight->topic_tags)
            ->filter()
            ->map(fn (string $topic): string => trim($topic))
            ->unique()
            ->sort()
            ->mapWithKeys(fn (string $topic): array => [$topic => $topic])
            ->all();
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() || auth()->user()?->isEditor() || auth()->user()?->isContributor();
    }

    public static function canCreate(): bool
    {
        return auth()->check();
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();

        if ($user?->isAdmin() || $user?->isEditor()) {
            return true;
        }

        return $user?->isContributor()
            && $record->author_id === $user->id
            && in_array($record->status, ['draft', 'revision'], true);
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin();
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()?->role === 'contributor') {
            return $query->where('author_id', auth()->id());
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('status')
                    ->default('draft')
                    ->visible(fn (): bool => auth()->user()?->role === 'contributor'),

                Grid::make([
                    'default' => 1,
                    'xl' => 3,
                ])
                    ->schema([
                        Group::make([
                            Section::make('1. Informasi Artikel')
                                ->description('Data utama yang membentuk identitas artikel di halaman Edulaw Insight.')
                                ->icon('heroicon-o-document-text')
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Judul Insight')
                                        ->placeholder('Contoh: Mahkamah Konstitusi dan Masa Depan Demokrasi')
                                        ->helperText('Judul singkat dan kuat untuk halaman Insight.')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (?string $state, callable $set): mixed => $set('slug', Str::slug($state ?? ''))),

                                    TextInput::make('slug')
                                        ->label('Slug')
                                        ->placeholder('contoh-mahkamah-konstitusi-dan-masa-dep')
                                        ->helperText('Otomatis dibuat dari judul, dapat disesuaikan.')
                                        ->disabled()
                                        ->dehydrated()
                                        ->unique(ignoreRecord: true)
                                        ->required()
                                        ->maxLength(255),

                                    Select::make('category_id')
                                        ->label('Kategori')
                                        ->relationship('category', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->native(false)
                                        ->helperText('Pilih jenis konten, misalnya Insight, Opini, Analisis, atau Review Putusan.')
                                        ->visible(fn (): bool => auth()->user()?->role !== 'contributor'),

                                    TagsInput::make('topic')
                                        ->label('Topik / Tags')
                                        ->placeholder('Contoh: Mahkamah Konstitusi, Pemilu, Judicial Review')
                                        ->helperText('Ketik satu atau beberapa topik, lalu tekan Enter. Topik digunakan untuk pengelompokan dan pencarian artikel.')
                                        ->separator(',')
                                        ->columnSpanFull(),

                                ])
                                ->columns(2),

                            Section::make('2. Isi Artikel')
                                ->description('Tulis artikel utama. Gunakan heading, kutipan, daftar, tautan, dan gambar seperlunya.')
                                ->icon('heroicon-o-pencil-square')
                                ->schema([
                                    RichEditor::make('content')
                                        ->label('Body')
                                        ->placeholder('Tulis artikel di sini. Gunakan H2/H3 untuk subjudul, bullet list untuk poin penting, dan blockquote untuk kutipan.')
                                        ->toolbarButtons([
                                            'attachFiles',
                                            'blockquote',
                                            'bold',
                                            'underline',
                                            'italic',
                                            'strike',
                                            'link',
                                            'h1',
                                            'h2',
                                            'h3',
                                            'bulletList',
                                            'orderedList',
                                            'codeBlock',
                                            'redo',
                                            'undo',
                                        ])
                                        ->fileAttachmentsDisk('public')
                                        ->fileAttachmentsDirectory('insight-content')
                                        ->fileAttachmentsVisibility('public')
                                        ->extraInputAttributes([
                                            'class' => 'min-h-[22rem] text-justify leading-7',
                                        ], merge: true)
                                        ->helperText('Gunakan paragraf pendek, subjudul yang rapi, dan sisipkan gambar hanya jika membantu pembaca.')
                                        ->required()
                                        ->columnSpanFull(),
                                ]),

                            Section::make('SEO & Pratinjau')
                                ->description('Metadata untuk hasil pencarian dan preview saat artikel dibagikan.')
                                ->icon('heroicon-o-magnifying-glass')
                                ->schema([
                                    TextInput::make('seo_title')
                                        ->label('SEO Title')
                                        ->placeholder('Jika kosong, judul artikel akan digunakan.')
                                        ->maxLength(70)
                                        ->helperText('Ideal 50-60 karakter.'),

                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->placeholder('Deskripsi singkat untuk mesin pencari...')
                                        ->rows(3)
                                        ->maxLength(160)
                                        ->helperText('Ideal 140-160 karakter.')
                                        ->columnSpanFull(),

                                    Placeholder::make('google_preview')
                                        ->label('Pratinjau Google')
                                        ->content(fn (Get $get): HtmlString => new HtmlString(
                                            '<div style="border:1px solid #e2e8f0;border-radius:8px;padding:16px;background:#fff;">'
                                            .'<p style="font-size:12px;color:#64748b;margin:0 0 6px;">edulawproject.id › insight › '
                                            .e($get('slug') ?: 'contoh-judul-artikel')
                                            .'</p>'
                                            .'<p style="font-size:18px;color:#1d4ed8;margin:0 0 6px;font-weight:700;">'
                                            .e($get('seo_title') ?: $get('title') ?: 'Contoh Judul Artikel Insight Edulaw Project')
                                            .'</p>'
                                            .'<p style="font-size:13px;color:#334155;margin:0;line-height:1.55;">'
                                            .e($get('meta_description') ?: 'Ini adalah contoh deskripsi meta yang akan tampil di hasil pencarian Google.')
                                            .'</p>'
                                            .'</div>'
                                        ))
                                        ->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->collapsible(),
                        ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 2,
                            ]),

                        Group::make([
                            Section::make('Status Publikasi')
                                ->description('Status dan waktu tayang artikel.')
                                ->icon('heroicon-o-paper-airplane')
                                ->schema([
                                    Select::make('status')
                                        ->label('Status Editorial')
                                        ->options(self::STATUS_OPTIONS)
                                        ->default('draft')
                                        ->native(false)
                                        ->visible(fn (): bool => auth()->user()?->role !== 'contributor'),

                                    DateTimePicker::make('published_at')
                                        ->label('Tanggal Publikasi')
                                        ->seconds(false)
                                        ->native(false)
                                        ->helperText('Admin dapat mengatur atau mengubah tanggal publikasi artikel.')
                                        ->visible(fn (): bool => auth()->user()?->role !== 'contributor'),

                                    Select::make('featured')
                                        ->label('Artikel Unggulan')
                                        ->options([
                                            0 => 'Tidak',
                                            1 => 'Ya',
                                        ])
                                        ->default(0)
                                        ->native(false)
                                        ->visible(fn (): bool => auth()->user()?->role !== 'contributor'),

                                    Placeholder::make('contributor_status_note')
                                        ->label('Status')
                                        ->content('Tulisan contributor disimpan sebagai draft dan dapat diajukan ke editorial dari tabel Insight.')
                                        ->visible(fn (): bool => auth()->user()?->role === 'contributor'),
                                ]),

                            Section::make('Penulis')
                                ->description('Pilih penulis utama dan penulis tambahan dari daftar pengguna terdaftar.')
                                ->icon('heroicon-o-user-circle')
                                ->schema([
                                    Select::make('author_id')
                                        ->label('Penulis Utama')
                                        ->relationship('author', 'name')
                                        ->default(fn (): ?int => auth()->id())
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->native(false)
                                        ->helperText('Nama, afiliasi, bio, dan foto profil akan otomatis diambil dari data user.')
                                        ->disabled(fn (): bool => auth()->user()?->role === 'contributor')
                                        ->dehydrated(),

                                    Repeater::make('co_authors')
                                        ->label('Penulis Tambahan')
                                        ->helperText('Gunakan jika artikel ditulis bersama penulis ke-2, ke-3, dan seterusnya.')
                                        ->schema([
                                            Select::make('user_id')
                                                ->label('Pilih Penulis')
                                                ->options(fn (): array => User::query()
                                                    ->orderBy('name')
                                                    ->pluck('name', 'id')
                                                    ->all())
                                                ->searchable()
                                                ->preload()
                                                ->native(false)
                                                ->required()
                                                ->helperText('Data penulis tambahan akan otomatis diambil dari profil user.'),
                                        ])
                                        ->defaultItems(0)
                                        ->addActionLabel('Tambah Penulis')
                                        ->collapsible()
                                        ->columnSpanFull(),
                                ]),

                            Section::make('Media Artikel')
                                ->description('Gambar utama untuk listing dan detail artikel.')
                                ->icon('heroicon-o-photo')
                                ->schema([
                                    FileUpload::make('thumbnail')
                                        ->label('Gambar Utama')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('insights')
                                        ->helperText('Rekomendasi rasio 16:9, ukuran maksimal 2MB.'),
                                ]),

                            Section::make('Catatan Editorial')
                                ->icon('heroicon-o-chat-bubble-left-right')
                                ->schema([
                                    Placeholder::make('editorial_note')
                                        ->content(fn (?Insight $record): string => filled($record?->revision_notes)
                                            ? 'Catatan revisi: '.$record->revision_notes
                                            : 'Seluruh tulisan merupakan opini pribadi penulis, proses editorial dilakukan untuk menjaga akurasi, relevansi, etika, dan kualitas argumentasi.'),
                                ])
                                ->visible(fn (): bool => auth()->user()?->role === 'contributor')
                                ->collapsible(),

                            Section::make('Catatan Editorial')
                                ->icon('heroicon-o-clipboard-document-check')
                                ->schema([
                                    Textarea::make('revision_notes')
                                        ->label('Catatan Revisi')
                                        ->placeholder('Tulis catatan revisi atau catatan internal tim editorial di sini...')
                                        ->rows(4),
                                ])
                                ->visible(fn (): bool => auth()->user()?->role !== 'contributor')
                                ->collapsible(),
                        ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 1,
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Daftar Artikel')
            ->description('Kelola alur editorial, status publikasi, kategori, dan penulis artikel.')
            ->searchPlaceholder('Cari artikel...')
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->circular()
                    ->size(32)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('title')
                    ->label('Artikel')
                    ->size('sm')
                    ->limit(120)
                    ->lineClamp(2)
                    ->searchable(['title', 'slug'])
                    ->sortable()
                    ->weight('semibold')
                    ->width('52%')
                    ->description(function (Insight $record): string {
                        $author = $record->author?->name ?: $record->author_name ?: 'Tanpa penulis';
                        $date = $record->published_at?->format('d M Y') ?: 'Belum rilis';
                        $release = $record->published_at ? "Rilis {$date}" : $date;

                        return Str::limit("{$author} · {$release}", 84);
                    })
                    ->wrap(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->state(fn (Insight $record): string => $record->category?->name ?: 'Belum dikategorikan')
                    ->badge()
                    ->width('16%')
                    ->color(fn (?string $state): string => match ($state) {
                        'Insight' => 'info',
                        'Opini' => 'warning',
                        'Riset' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('topic')
                    ->label('Topik / Tags')
                    ->state(fn (Insight $record): ?string => $record->topic_label)
                    ->badge()
                    ->color('gray')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->width('12%')
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'submitted', 'under_review' => 'warning',
                        'revision' => 'danger',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'submitted' => 'Diajukan',
                        'under_review' => 'Dalam Review',
                        'revision' => 'Perlu Revisi',
                        'published' => 'Terbit',
                        'rejected' => 'Ditolak',
                        default => 'Draft',
                    })
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Update')
                    ->since()
                    ->width('12%')
                    ->sortable()
                    ->color('gray'),
            ])
            ->defaultSort('published_at', 'desc') // Otomatis urutkan dari yang terbaru
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::STATUS_OPTIONS),

                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('topic')
                    ->label('Topik / Tags')
                    ->options(fn (): array => self::topicOptions())
                    ->query(fn (Builder $query, array $data): Builder => filled($data['value'] ?? null)
                        ? $query->whereJsonContains('topic', $data['value'])
                        : $query),
            ])
            ->filtersFormColumns(2)
            ->actionsColumnLabel('Aksi')
            ->actionsAlignment('end')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Edit'),

                    Tables\Actions\Action::make('view')
                        ->label('Lihat')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->url(fn (Insight $record): string => route('insight.show', $record->slug))
                        ->openUrlInNewTab()
                        ->visible(fn (Insight $record): bool => $record->status === 'published' && filled($record->slug)),

                    Tables\Actions\Action::make('submit')
                        ->label('Submit Review')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('info')
                        ->requiresConfirmation()
                        ->visible(fn (Insight $record): bool => auth()->user()?->isContributor()
                            && $record->author_id === auth()->id()
                            && in_array($record->status, ['draft', 'revision'], true))
                        ->action(fn (Insight $record): bool => $record->update([
                            'status' => 'submitted',
                            'published_at' => null,
                        ])),

                    Tables\Actions\Action::make('startReview')
                        ->label('Mulai Review')
                        ->icon('heroicon-o-eye')
                        ->color('primary')
                        ->visible(fn (Insight $record): bool => (auth()->user()?->isAdmin() || auth()->user()?->isEditor())
                            && $record->status === 'submitted')
                        ->action(fn (Insight $record): bool => $record->update([
                            'status' => 'under_review',
                        ])),

                    Tables\Actions\Action::make('requestRevision')
                        ->label('Minta Revisi')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->form([
                            Textarea::make('revision_notes')
                                ->label('Catatan Revisi')
                                ->rows(4)
                                ->required(),
                        ])
                        ->requiresConfirmation()
                        ->visible(fn (Insight $record): bool => (auth()->user()?->isAdmin() || auth()->user()?->isEditor())
                            && in_array($record->status, ['submitted', 'under_review'], true))
                        ->action(fn (Insight $record, array $data): bool => $record->update([
                            'status' => 'revision',
                            'revision_notes' => $data['revision_notes'],
                            'published_at' => null,
                        ])),

                    Tables\Actions\Action::make('publish')
                        ->label('Terbitkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Insight $record): bool => (auth()->user()?->isAdmin() || auth()->user()?->isEditor())
                            && in_array($record->status, ['submitted', 'under_review', 'revision'], true))
                        ->action(fn (Insight $record): bool => $record->update([
                            'status' => 'published',
                            'revision_notes' => null,
                            'published_at' => $record->published_at ?? now(),
                        ])),

                    Tables\Actions\Action::make('changeStatus')
                        ->label('Ubah Status')
                        ->icon('heroicon-o-adjustments-horizontal')
                        ->form([
                            Select::make('status')
                                ->label('Status')
                                ->options(self::STATUS_OPTIONS)
                                ->required()
                                ->native(false),
                        ])
                        ->fillForm(fn (Insight $record): array => [
                            'status' => $record->status,
                        ])
                        ->visible(fn (): bool => auth()->user()?->isAdmin() || auth()->user()?->isEditor())
                        ->action(fn (Insight $record, array $data): bool => $record->update([
                            'status' => $data['status'],
                            'published_at' => $data['status'] === 'published'
                                ? ($record->published_at ?? now())
                                : ($data['status'] === 'draft' ? null : $record->published_at),
                        ])),

                    Tables\Actions\Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn (Insight $record): bool => (auth()->user()?->isAdmin() || auth()->user()?->isEditor())
                            && in_array($record->status, ['submitted', 'under_review'], true))
                        ->action(fn (Insight $record): bool => $record->update([
                            'status' => 'rejected',
                            'published_at' => null,
                        ])),
                ])
                    ->label('Aksi')
                    ->icon('heroicon-m-ellipsis-horizontal')
                    ->button()
                    ->color('primary')
                    ->size('sm'),

                Tables\Actions\DeleteAction::make()
                    ->iconButton()
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
            'index' => Pages\ListInsights::route('/'),
            'create' => Pages\CreateInsight::route('/create'),
            'edit' => Pages\EditInsight::route('/{record}/edit'),
        ];
    }
}
