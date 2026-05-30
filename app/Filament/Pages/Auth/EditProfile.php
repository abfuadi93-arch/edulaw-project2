<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class EditProfile extends BaseEditProfile
{
    public function getHeading(): string|Htmlable
    {
        return 'Profil Penulis';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Lengkapi identitas penulis yang akan tampil pada artikel Edulaw Insight.';
    }

    public function getMaxWidth(): MaxWidth|string|null
    {
        return MaxWidth::SixExtraLarge;
    }

    public function getMaxContentWidth(): MaxWidth|string|null
    {
        return MaxWidth::SixExtraLarge;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'xl' => 3,
                ])
                    ->schema([
                        Group::make([
                            Section::make('Data Akun')
                                ->description('Data dasar akun untuk masuk ke dashboard Edulaw.')
                                ->icon('heroicon-o-user')
                                ->schema([
                                    $this->getNameFormComponent()
                                        ->label('Nama Lengkap')
                                        ->live(onBlur: true),

                                    $this->getEmailFormComponent()
                                        ->label('Email'),

                                    $this->getPasswordFormComponent()
                                        ->label('Password Baru'),

                                    $this->getPasswordConfirmationFormComponent()
                                        ->label('Konfirmasi Password Baru'),
                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 2,
                                ]),

                            Section::make('Profil Author')
                                ->description('Identitas editorial yang akan terhubung otomatis ke tulisan Anda.')
                                ->icon('heroicon-o-identification')
                                ->schema([
                                    TextInput::make('author_affiliation')
                                        ->label('Afiliasi')
                                        ->placeholder('Contoh: Edulaw Project / Fakultas Hukum / Lembaga Riset')
                                        ->maxLength(255)
                                        ->live(onBlur: true),

                                    TextInput::make('author_expertise')
                                        ->label('Bidang Keahlian')
                                        ->placeholder('Contoh: Konstitusi, HAM, Kebijakan Publik')
                                        ->helperText('Pisahkan beberapa bidang dengan koma.')
                                        ->maxLength(255)
                                        ->live(onBlur: true),

                                    Textarea::make('author_bio')
                                        ->label('Bio Singkat')
                                        ->placeholder('Tuliskan fokus kajian, pengalaman, atau latar belakang singkat Anda.')
                                        ->rows(5)
                                        ->maxLength(1000)
                                        ->live(onBlur: true)
                                        ->columnSpanFull(),
                                ])
                                ->columns([
                                    'default' => 1,
                                    'md' => 2,
                                ]),
                        ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 2,
                            ]),

                        Group::make([
                            Section::make('Foto Penulis')
                                ->description('Gunakan foto profesional dengan wajah terlihat jelas.')
                                ->icon('heroicon-o-camera')
                                ->schema([
                                    FileUpload::make('author_photo')
                                        ->label('Upload Foto')
                                        ->image()
                                        ->avatar()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('authors')
                                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                        ->maxSize(2048)
                                        ->helperText('Format JPG, PNG, atau WebP maksimal 2MB.'),
                                ]),

                            Section::make('Preview Profil')
                                ->description('Ringkasan identitas yang akan terbaca pada artikel.')
                                ->icon('heroicon-o-document-text')
                                ->schema([
                                    Placeholder::make('author_preview')
                                        ->hiddenLabel()
                                        ->content(fn (Get $get): HtmlString => $this->authorPreview($get)),
                                ]),
                        ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 1,
                            ]),
                    ]),
            ]);
    }

    private function authorPreview(Get $get): HtmlString
    {
        $name = e($get('name') ?: auth()->user()?->name ?: 'Nama Penulis');
        $affiliation = e($get('author_affiliation') ?: 'Afiliasi belum diisi');
        $expertise = e($get('author_expertise') ?: 'Bidang keahlian belum diisi');
        $bio = e($get('author_bio') ?: 'Bio singkat penulis akan tampil sebagai pengantar kredibilitas author.');
        $initial = e(str($name)->substr(0, 1)->upper());

        return new HtmlString(<<<HTML
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-900 text-sm font-bold text-white">
                        {$initial}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-950 dark:text-white">{$name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{$affiliation}</p>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm leading-6 text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-primary-700 dark:text-primary-300">{$expertise}</p>
                    <p>{$bio}</p>
                </div>
            </div>
        HTML);
    }

    public static function getLabel(): string
    {
        return 'Profil Penulis';
    }
}
