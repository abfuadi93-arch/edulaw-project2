<?php

namespace App\Filament\Resources\InsightResource\Pages;

use App\Filament\Resources\InsightResource;
use App\Models\Insight;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class CreateInsight extends CreateRecord
{
    protected static string $resource = InsightResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Buat Insight';
    }

    public function getHeading(): string|Htmlable
    {
        return 'Buat Insight';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Kelola artikel, metadata, penulis, dan publikasi Edulaw Insight.';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $baseSlug = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['title'] ?? '');
        $data['slug'] = self::uniqueSlug($baseSlug);
        $data['author_id'] = $data['author_id'] ?? auth()->id();
        $data = self::syncAuthorProfile($data);
        $data['co_authors'] = self::normalizeCoAuthors($data['co_authors'] ?? []);
        $data['topic'] = self::normalizeTopics($data['topic'] ?? []);

        if (($data['status'] ?? null) === 'published' && blank($data['published_at'] ?? null)) {
            $data['published_at'] = now();
        }

        if (auth()->user()?->isContributor()) {
            $data['author_id'] = auth()->id();
            $data = self::syncAuthorProfile($data, overwrite: false);
            $data['status'] = 'draft';
            $data['published_at'] = null;
            $data['category_id'] = null;
        }

        return $data;
    }

    private static function syncAuthorProfile(array $data, bool $overwrite = true): array
    {
        $user = User::find($data['author_id'] ?? null);

        if (! $user) {
            $data['author_name'] ??= auth()->user()?->name;

            return $data;
        }

        if ($overwrite || blank($data['author_name'] ?? null)) {
            $data['author_name'] = $user->name;
        }

        if ($overwrite || blank($data['author_affiliation'] ?? null)) {
            $data['author_affiliation'] = $user->author_affiliation ?: 'Edulaw Project';
        }

        if (($overwrite || blank($data['author_photo'] ?? null)) && filled($user->author_photo)) {
            $data['author_photo'] = $user->author_photo;
        }

        return $data;
    }

    private static function normalizeCoAuthors(array $coAuthors): array
    {
        $users = User::whereKey(
            collect($coAuthors)
                ->pluck('user_id')
                ->filter()
                ->unique()
                ->all()
        )->get()->keyBy('id');

        return collect($coAuthors)
            ->map(function (array $author) use ($users): ?array {
                $user = $users->get($author['user_id'] ?? null);

                if (! $user) {
                    return filled($author['name'] ?? null) ? $author : null;
                }

                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'affiliation' => $user->author_affiliation,
                    'expertise' => $user->author_expertise,
                    'bio' => $user->author_bio,
                    'photo' => $user->author_photo,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    private static function normalizeTopics(array|string|null $topics): array
    {
        return collect(is_array($topics) ? $topics : explode(',', (string) $topics))
            ->map(fn ($topic): string => trim((string) $topic))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private static function uniqueSlug(string $baseSlug): string
    {
        $baseSlug = $baseSlug ?: 'insight';
        $slug = $baseSlug;
        $counter = 2;

        while (Insight::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCancelFormAction(),
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            $this->getCreateFormAction(),
        ];
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Buat Insight')
            ->icon('heroicon-o-paper-airplane');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Buat & buat lainnya')
            ->icon('heroicon-o-sparkles');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }
}
