<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected static string $layout = 'filament-panels::components.layout.base';

    protected static string $view = 'filament.pages.auth.login';

    public function getTitle(): string|Htmlable
    {
        return 'Masuk Console Edulaw';
    }

    public function getHeading(): string|Htmlable
    {
        return 'Masuk ke Dashboard Edulaw';
    }

    protected function getEmailFormComponent(): Component
    {
        return parent::getEmailFormComponent()
            ->label('Email')
            ->placeholder('nama@email.com');
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->label('Password')
            ->placeholder('Masukkan password');
    }

    protected function getRememberFormComponent(): Component
    {
        return parent::getRememberFormComponent()
            ->label('Ingat saya');
    }

    protected function getAuthenticateFormAction(): Action
    {
        return parent::getAuthenticateFormAction()
            ->label('Masuk');
    }

    public function registerAction(): Action
    {
        return parent::registerAction()
            ->label('Daftar contributor');
    }
}
