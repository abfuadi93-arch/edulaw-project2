<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->boolean('show_on_home')->default(false)->after('featured');
        });

        DB::table('programs')
            ->orderBy('id')
            ->get(['id', 'title'])
            ->each(function (object $program): void {
                $baseSlug = Str::slug($program->title) ?: 'program-' . $program->id;
                $slug = $baseSlug;
                $counter = 2;

                while (DB::table('programs')->where('slug', $slug)->where('id', '!=', $program->id)->exists()) {
                    $slug = "{$baseSlug}-{$counter}";
                    $counter++;
                }

                DB::table('programs')
                    ->where('id', $program->id)
                    ->update([
                        'slug' => $slug,
                        'show_on_home' => true,
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'show_on_home']);
        });
    }
};
