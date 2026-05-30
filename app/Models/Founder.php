<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Founder extends Model
{
    protected $guarded = [];

    protected $casts = [
        'expertise' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Founder $founder): void {
            if (blank($founder->slug)) {
                $founder->slug = Str::slug($founder->name);
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getPhotoUrlAttribute(): string
    {
        if (blank($this->photo)) {
            return '';
        }

        return Str::startsWith($this->photo, ['images/', 'http://', 'https://'])
            ? asset($this->photo)
            : asset('storage/' . $this->photo);
    }
}
