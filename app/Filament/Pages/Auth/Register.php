<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Akun Contributor')
                    ->description('Daftar sebagai contributor untuk menulis dan mengajukan insight ke editorial Edulaw.')
                    ->schema([
                        $this->getNameFormComponent()
                            ->label('Nama Lengkap')
                            ->placeholder('Nama yang akan tampil sebagai penulis'),

                        $this->getEmailFormComponent()
                            ->label('Email')
                            ->placeholder('email@domain.com'),

                        $this->getPasswordFormComponent()
                            ->label('Password'),

                        $this->getPasswordConfirmationFormComponent()
                            ->label('Konfirmasi Password'),
                    ])
                    ->columns(2),

                Section::make('Bio Penulis')
                    ->description('Profil ini membantu editor dan pembaca mengenali latar belakang penulis.')
                    ->schema([
                        TextInput::make('author_affiliation')
                            ->label('Afiliasi')
                            ->placeholder('Contoh: Edulaw Project / Fakultas Hukum / Lembaga Riset')
                            ->maxLength(255),

                        TextInput::make('author_expertise')
                            ->label('Bidang Keahlian')
                            ->placeholder('Contoh: Konstitusi, HAM, Kebijakan Publik')
                            ->helperText('Pisahkan beberapa bidang dengan koma.')
                            ->maxLength(255),

                        Textarea::make('author_bio')
                            ->label('Bio Singkat')
                            ->placeholder('Tuliskan fokus kajian, pengalaman, atau latar belakang singkat Anda.')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = 'contributor';

        return $data;
    }

    public function getHeading(): string
    {
        return 'Daftar Contributor Edulaw';
    }
}
