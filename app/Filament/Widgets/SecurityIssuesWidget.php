<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SecurityIssuesWidget extends Widget
{
    protected static string $view = 'filament.widgets.security-issues-widget';

    protected static ?int $sort = 7;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'xl' => 2,
    ];

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin();
    }

    protected function getViewData(): array
    {
        $issues = collect();
        $appUrl = (string) config('app.url');
        $appKey = (string) config('app.key');
        $mailMailer = (string) config('mail.default');
        $hasEmailVerifiedColumn = Schema::hasColumn('users', 'email_verified_at');
        $adminCount = User::where('role', 'admin')->count();
        $editorCount = User::where('role', 'editor')->count();
        $unverifiedUsers = $hasEmailVerifiedColumn
            ? User::whereNull('email_verified_at')->count()
            : 0;
        $invalidRoleUsers = User::whereNotIn('role', ['admin', 'editor', 'contributor'])->count();

        if (config('app.debug')) {
            $issues->push([
                'severity' => 'critical',
                'title' => 'APP_DEBUG masih aktif',
                'description' => 'Matikan debug di production agar error detail, path server, dan konfigurasi internal tidak tampil ke publik.',
                'meta' => 'Set APP_DEBUG=false lalu jalankan optimize:clear.',
            ]);
        }

        if (app()->environment(['local', 'development', 'testing'])) {
            $issues->push([
                'severity' => 'high',
                'title' => 'Environment belum production',
                'description' => 'Panel admin sebaiknya berjalan dengan APP_ENV=production pada server publik.',
                'meta' => 'APP_ENV sekarang: ' . app()->environment(),
            ]);
        }

        if (blank($appKey) || ! Str::startsWith($appKey, 'base64:')) {
            $issues->push([
                'severity' => 'critical',
                'title' => 'APP_KEY belum valid',
                'description' => 'APP_KEY diperlukan untuk enkripsi session, cookie, dan data sensitif Laravel.',
                'meta' => 'Jalankan php artisan key:generate hanya jika belum ada key production.',
            ]);
        }

        if (! Str::startsWith($appUrl, 'https://')) {
            $issues->push([
                'severity' => 'high',
                'title' => 'APP_URL belum memakai HTTPS',
                'description' => 'Gunakan HTTPS sebagai URL utama agar link aset, reset password, dan cookie lebih aman.',
                'meta' => 'APP_URL sekarang: ' . ($appUrl ?: '-'),
            ]);
        }

        if (in_array($mailMailer, ['log', 'array'], true)) {
            $issues->push([
                'severity' => 'high',
                'title' => 'Mailer belum mengirim email sungguhan',
                'description' => 'Email verification membutuhkan SMTP atau provider email aktif agar link verifikasi benar-benar terkirim ke user baru.',
                'meta' => 'MAIL_MAILER sekarang: ' . ($mailMailer ?: '-'),
            ]);
        }

        if ($adminCount === 0) {
            $issues->push([
                'severity' => 'critical',
                'title' => 'Tidak ada akun admin',
                'description' => 'Setidaknya satu akun admin diperlukan untuk pengelolaan panel dan pemulihan akses.',
                'meta' => 'Admin terdeteksi: 0',
            ]);
        } elseif ($adminCount > 2) {
            $issues->push([
                'severity' => 'medium',
                'title' => 'Akun admin terlalu banyak',
                'description' => 'Batasi role admin hanya untuk pengelola inti. Gunakan editor untuk kebutuhan editorial harian.',
                'meta' => 'Admin terdeteksi: ' . $adminCount,
            ]);
        }

        if ($invalidRoleUsers > 0) {
            $issues->push([
                'severity' => 'high',
                'title' => 'Ada user dengan role tidak dikenal',
                'description' => 'Role di luar admin, editor, dan contributor dapat menyebabkan akses panel tidak konsisten.',
                'meta' => $invalidRoleUsers . ' user perlu diperiksa.',
            ]);
        }

        if ($unverifiedUsers > 0) {
            $issues->push([
                'severity' => 'medium',
                'title' => 'Ada email pengguna belum terverifikasi',
                'description' => 'Periksa akun yang belum terverifikasi, terutama jika memiliki akses editor atau contributor.',
                'meta' => $unverifiedUsers . ' user belum terverifikasi.',
            ]);
        }

        return [
            'issues' => $issues->values(),
            'criticalCount' => $issues->where('severity', 'critical')->count(),
            'highCount' => $issues->where('severity', 'high')->count(),
            'mediumCount' => $issues->where('severity', 'medium')->count(),
            'adminCount' => $adminCount,
            'editorCount' => $editorCount,
            'usersUrl' => UserResource::getUrl('index'),
        ];
    }
}
