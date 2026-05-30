<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResearchResource\Pages;
use App\Filament\Resources\ResearchResource\RelationManagers;
use App\Models\Research;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ResearchResource extends Resource
{
    protected static ?string $model = Research::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Publikasi';

    protected static ?string $modelLabel = 'Publikasi';

    protected static ?string $pluralModelLabel = 'Riset & Publikasi';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user?->isAdmin() || $user?->isEditor();
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();

        return $user?->isAdmin() || $user?->isEditor() || $user?->isContributor();
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();

        return $user?->isAdmin() || $user?->isEditor() || $user?->isContributor();
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
                TextInput::make('title')
                    ->label('Judul Publikasi')
                    ->required(),

                TextInput::make('authors')
                    ->label('Penulis')
                    ->placeholder('Contoh: Tim Riset Edulaw Project')
                    ->maxLength(255),

                TextInput::make('year')
                    ->label('Tahun')
                    ->numeric()
                    ->required()
                    ->maxLength(4),

                TextInput::make('document_type')
                    ->label('Jenis Dokumen')
                    ->datalist(fn (): array => Research::documentTypeLabels())
                    ->default('Policy Brief')
                    ->helperText('Ketik jenis dokumen baru, atau pilih dari saran yang sudah pernah digunakan.')
                    ->maxLength(255)
                    ->required(),

                Select::make('language')
                    ->label('Bahasa')
                    ->options(Research::LANGUAGES)
                    ->default('id')
                    ->native(false)
                    ->required(),

                Select::make('category')
                    ->label('Research Collection')
                    ->options(fn (): array => Research::documentTypeOptions())
                    ->placeholder('Pilih koleksi riset')
                    ->native(false),

                TagsInput::make('keywords')
                    ->label('Kata Kunci')
                    ->placeholder('Tambah kata kunci')
                    ->helperText('Contoh: konstitusi, demokrasi, pesisir, regulasi')
                    ->columnSpanFull(),

                Textarea::make('abstract')
                    ->label('Abstract / Ringkasan')
                    ->rows(5)
                    ->helperText('Ringkasan publikasi yang ditampilkan sebelum pengunjung mengunduh PDF.')
                    ->columnSpanFull(),

                TagsInput::make('key_findings')
                    ->label('Highlight Temuan')
                    ->placeholder('Tambah temuan utama')
                    ->helperText('Gunakan 3-5 poin temuan utama.')
                    ->columnSpanFull(),

                Textarea::make('preview_note')
                    ->label('Catatan Preview')
                    ->rows(3)
                    ->helperText('Catatan singkat tentang cakupan dokumen atau rekomendasi penggunaan.')
                    ->columnSpanFull(),

                TextInput::make('doi')
                    ->label('DOI')
                    ->placeholder('Contoh: 10.1234/edulaw.2026.001')
                    ->maxLength(255),

                Textarea::make('citation')
                    ->label('Manual Citation')
                    ->rows(3)
                    ->helperText('Jika kosong, citation otomatis dibuat dari judul, tahun, dan penerbit Edulaw Project.')
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('published')
                    ->required(),

                TextInput::make('download_count')
                    ->label('Jumlah Unduhan')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Dapat diisi manual sampai tracking unduhan otomatis diaktifkan.'),

                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->seconds(false)
                    ->native(false)
                    ->helperText('Tanggal publikasi riset atau policy brief.'),

                FileUpload::make('file')
                    ->label('File PDF Publikasi')
                    ->disk('public')
                    ->directory('research-files')
                    ->acceptedFileTypes(['application/pdf'])
                    ->helperText('Cover publikasi otomatis menggunakan halaman pertama PDF. Tidak perlu mengunggah foto atau sampul terpisah.')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Publikasi')
                    ->searchable()
                    ->size('sm')
                    ->weight('semibold')
                    ->limit(120)
                    ->lineClamp(2)
                    ->width('42%')
                    ->description(function (Research $record): HtmlString {
                        $fileStatus = $record->file ? 'Tersedia' : 'Belum tersedia';
                        $fileClass = $record->file ? 'is-available' : 'is-missing';
                        $authors = $record->authors ?: 'Tanpa penulis';

                        return new HtmlString(
                            '<span class="edulaw-publication-meta">'
                            .'<span class="edulaw-publication-pdf-badge '.$fileClass.'">'.e($fileStatus).'</span>'
                            .'<span>'.e(Str::limit($authors, 62)).'</span>'
                            .'</span>'
                        );
                    })
                    ->wrap(),

                TextColumn::make('year')
                    ->label('Tahun')
                    ->width('10%')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('category')
                    ->label('Koleksi')
                    ->formatStateUsing(fn (?string $state): string => Research::documentTypeLabel($state))
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('document_type')
                    ->label('Jenis')
                    ->formatStateUsing(fn (?string $state): string => Research::documentTypeLabel($state))
                    ->badge()
                    ->limit(24)
                    ->width('16%'),

                TextColumn::make('language')
                    ->label('Bahasa')
                    ->formatStateUsing(fn (?string $state): string => Research::LANGUAGES[$state] ?? strtoupper((string) $state))
                    ->badge()
                    ->width('14%'),

                TextColumn::make('download_count')
                    ->label('Unduhan')
                    ->width('10%')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('published_at')
                    ->label('Terbit')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
                SelectFilter::make('document_type')
                    ->label('Jenis Dokumen')
                    ->options(fn (): array => Research::documentTypeOptions()),
                SelectFilter::make('category')
                    ->label('Research Collection')
                    ->options(fn (): array => Research::documentTypeOptions()),
                SelectFilter::make('language')
                    ->label('Bahasa')
                    ->options(Research::LANGUAGES),
            ])
            ->defaultSort('published_at', 'desc')
            ->actionsColumnLabel('Aksi')
            ->actionsAlignment('end')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->link()
                    ->size('sm'),
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
            'index' => Pages\ListResearch::route('/'),
            'create' => Pages\CreateResearch::route('/create'),
            'edit' => Pages\EditResearch::route('/{record}/edit'),
        ];
    }
}
