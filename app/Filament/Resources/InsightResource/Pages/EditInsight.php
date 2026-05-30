<?php

namespace App\Filament\Resources\InsightResource\Pages;

use App\Filament\Resources\InsightResource;
use App\Models\Insight;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditInsight extends EditRecord
{
    protected static string $resource = InsightResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $baseSlug = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['title'] ?? '');
        $data['slug'] = self::uniqueSlug($baseSlug, $this->record->id);
        $data = self::syncAuthorProfile($data);
        $data['co_authors'] = self::normalizeCoAuthors($data['co_authors'] ?? []);
        $data['topic'] = self::normalizeTopics($data['topic'] ?? []);

        if (($data['status'] ?? null) === 'published' && blank($data['published_at'] ?? null)) {
            $data['published_at'] = now();
        }

        if (auth()->user()?->isContributor()) {
            $data['author_id'] = auth()->id();
            $data = self::syncAuthorProfile($data, overwrite: false);
            $data['status'] = in_array($data['status'] ?? 'draft', ['draft', 'submitted', 'revision'], true)
                ? $data['status']
                : 'draft';
            $data['published_at'] = null;
            unset($data['category_id']);
        }

        return $data;
    }

    private static function syncAuthorProfile(array $data, bool $overwrite = true): array
    {
        $user = User::find($data['author_id'] ?? null);

        if (! $user) {
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

    private static function uniqueSlug(string $baseSlug, int $recordId): string
    {
        $baseSlug = $baseSlug ?: 'insight';
        $slug = $baseSlug;
        $counter = 2;

        while (Insight::where('slug', $slug)->whereKeyNot($recordId)->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn (): bool => auth()->user()?->isAdmin()),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
