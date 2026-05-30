<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('insights')
            ->whereNotNull('topic')
            ->orderBy('id')
            ->select(['id', 'topic'])
            ->chunk(100, function ($insights): void {
                foreach ($insights as $insight) {
                    $tags = json_decode((string) $insight->topic, true);

                    if (! is_array($tags)) {
                        continue;
                    }

                    $normalized = collect($tags)
                        ->flatMap(function ($tag): array {
                            if (! is_string($tag)) {
                                return [$tag];
                            }

                            $decoded = json_decode($tag, true);

                            return is_array($decoded) ? $decoded : [$tag];
                        })
                        ->map(fn ($tag): string => trim((string) $tag))
                        ->filter()
                        ->unique()
                        ->values()
                        ->all();

                    DB::table('insights')
                        ->where('id', $insight->id)
                        ->update([
                            'topic' => $normalized === [] ? null : json_encode($normalized),
                        ]);
                }
            });
    }

    public function down(): void
    {
        //
    }
};
