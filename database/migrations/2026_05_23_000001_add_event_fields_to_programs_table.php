<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('program_type')->nullable()->after('label');
            $table->string('short_title')->nullable()->after('program_type');
            $table->string('subtitle')->nullable()->after('short_title');
            $table->string('display_date')->nullable()->after('end_date');
            $table->string('event_time')->nullable()->after('display_date');
            $table->string('event_status')->default('portfolio')->after('event_time');
            $table->string('speaker_name')->nullable()->after('event_status');
            $table->text('speaker_title')->nullable()->after('speaker_name');
            $table->string('moderator_name')->nullable()->after('speaker_title');
            $table->string('moderator_affiliation')->nullable()->after('moderator_name');
            $table->string('hero_image')->nullable()->after('image');
            $table->text('detailed_description')->nullable()->after('description');
            $table->text('orientation')->nullable()->after('highlights');
            $table->text('method')->nullable()->after('orientation');
            $table->text('output')->nullable()->after('method');
            $table->text('notes')->nullable()->after('output');
            $table->string('registration_url')->nullable()->after('notes');
            $table->string('youtube_url')->nullable()->after('registration_url');
            $table->string('material_url')->nullable()->after('youtube_url');
            $table->string('primary_button_text')->nullable()->after('material_url');
            $table->string('primary_button_url')->nullable()->after('primary_button_text');
            $table->string('secondary_button_text')->nullable()->after('primary_button_url');
            $table->string('secondary_button_url')->nullable()->after('secondary_button_text');
            $table->string('publication_status')->default('published')->after('secondary_button_url');
            $table->boolean('featured')->default(false)->after('publication_status');
        });

        DB::table('programs')->update([
            'event_status' => DB::raw("
                CASE
                    WHEN start_date IS NOT NULL AND end_date IS NOT NULL AND end_date >= CURRENT_DATE THEN 'upcoming'
                    WHEN end_date IS NOT NULL AND end_date < CURRENT_DATE THEN 'completed'
                    ELSE 'portfolio'
                END
            "),
            'publication_status' => 'published',
            'featured' => false,
        ]);
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn([
                'program_type',
                'short_title',
                'subtitle',
                'display_date',
                'event_time',
                'event_status',
                'speaker_name',
                'speaker_title',
                'moderator_name',
                'moderator_affiliation',
                'hero_image',
                'detailed_description',
                'orientation',
                'method',
                'output',
                'notes',
                'registration_url',
                'youtube_url',
                'material_url',
                'primary_button_text',
                'primary_button_url',
                'secondary_button_text',
                'secondary_button_url',
                'publication_status',
                'featured',
            ]);
        });
    }
};
