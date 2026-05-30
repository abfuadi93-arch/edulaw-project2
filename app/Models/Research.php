<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    // Jika nama tabel Anda dianggap 'researches' oleh Laravel tapi Anda buat 'research',
    // tambahkan baris ini. Jika migrasinya tadi 'create_research_table', biasanya aman.
    protected $table = 'research'; 
    
    protected $guarded = [];

    protected $casts = [
        'download_count' => 'integer',
        'published_at' => 'datetime',
        'keywords' => 'array',
        'key_findings' => 'array',
    ];

    public const DOCUMENT_TYPES = [
        'constitutional_brief' => 'Constitutional Brief',
        'policy_brief' => 'Policy Brief',
        'policy_paper' => 'Policy Paper',
        'toolkit' => 'Toolkit',
        'regulatory_review' => 'Kajian Regulasi',
        'working_paper' => 'Working Paper',
        'research_report' => 'Research Report',
        'journal_article' => 'Journal Article',
    ];

    public const LANGUAGES = [
        'id' => 'Indonesia',
        'en' => 'English',
    ];

    public static function documentTypeOptions(): array
    {
        $storedTypes = static::query()
            ->whereNotNull('document_type')
            ->where('document_type', '!=', '')
            ->distinct()
            ->orderBy('document_type')
            ->pluck('document_type')
            ->mapWithKeys(fn (string $type): array => [$type => static::documentTypeLabel($type)])
            ->all();

        return $storedTypes + self::DOCUMENT_TYPES;
    }

    public static function documentTypeLabels(): array
    {
        return array_values(array_unique(static::documentTypeOptions()));
    }

    public static function documentTypeLabel(?string $type): string
    {
        if (! $type) {
            return 'Publikasi';
        }

        return self::DOCUMENT_TYPES[$type] ?? str($type)->headline()->toString();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}
