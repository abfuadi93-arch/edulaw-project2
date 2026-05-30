<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'label',
        'program_family',
        'program_type',
        'short_title',
        'subtitle',
        'duration',
        'level',
        'format',
        'start_date',
        'end_date',
        'event_status',
        'speakers',
        'speaker_name',
        'speaker_title',
        'moderator_name',
        'moderator_affiliation',
        'description',
        'detailed_description',
        'highlights',
        'orientation',
        'method',
        'output',
        'notes',
        'image',
        'hero_image',
        'registration_url',
        'youtube_url',
        'material_url',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'publication_status',
        'featured',
        'show_on_home',
        'sort_order',
    ];

    protected $casts = [
        'highlights' => 'array',
        'speakers' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'featured' => 'boolean',
        'show_on_home' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('publication_status', 'published');
    }

    protected static function booted(): void
    {
        static::creating(function (Program $program): void {
            if (blank($program->sort_order)) {
                $program->sort_order = ((int) static::max('sort_order')) + 1;
            }
        });

        static::saving(function (Program $program): void {
            if (blank($program->slug)) {
                $program->slug = static::uniqueSlug($program->title, $program->id);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    private static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'program';
        $slug = $baseSlug;
        $counter = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn (Builder $query): Builder => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
