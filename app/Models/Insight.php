<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Insight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'author_id',
        'author_name',
        'author_affiliation',
        'author_photo',
        'co_authors',
        'title',
        'slug',
        'seo_title',
        'meta_description',
        'category_id',
        'topic',
        'status',
        'excerpt',
        'summary',
        'content',
        'revision_notes',
        'author',
        'published_at',
        'featured',
        'views_count',
        'thumbnail',
        'image',
        'is_visible',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'featured' => 'boolean',
        'topic' => 'array',
        'co_authors' => 'array',
        'views_count' => 'integer',
        'is_visible' => 'boolean',
    ];

    public function getTopicTagsAttribute(): array
    {
        $topic = $this->topic;

        if (is_array($topic)) {
            return collect($topic)
                ->flatMap(function ($tag): array {
                    if (! is_string($tag)) {
                        return [$tag];
                    }

                    $decoded = json_decode($tag, true);

                    return is_array($decoded) ? $decoded : [$tag];
                })
                ->filter(fn ($tag): bool => filled($tag))
                ->map(fn ($tag): string => trim((string) $tag))
                ->values()
                ->all();
        }

        return filled($topic) ? [trim((string) $topic)] : [];
    }

    public function getTopicLabelAttribute(): ?string
    {
        $tags = $this->topic_tags;

        return $tags === [] ? null : implode(', ', $tags);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
