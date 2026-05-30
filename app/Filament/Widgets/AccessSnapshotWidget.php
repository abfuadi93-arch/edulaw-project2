<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Schema;

class AccessSnapshotWidget extends Widget
{
    protected static string $view = 'filament.widgets.access-snapshot-widget';

    protected static ?int $sort = 8;

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
        $hasEmailVerifiedColumn = Schema::hasColumn('users', 'email_verified_at');

        return [
            'adminCount' => User::where('role', 'admin')->count(),
            'editorCount' => User::where('role', 'editor')->count(),
            'contributorCount' => User::where('role', 'contributor')->count(),
            'unverifiedCount' => $hasEmailVerifiedColumn ? User::whereNull('email_verified_at')->count() : 0,
            'usersUrl' => UserResource::getUrl('index'),
        ];
    }
}
