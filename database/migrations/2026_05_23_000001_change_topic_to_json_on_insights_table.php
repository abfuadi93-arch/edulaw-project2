<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
                    $topic = trim((string) $insight->topic);

                    DB::table('insights')
                        ->where('id', $insight->id)
                        ->update([
                            'topic' => $topic === '' ? null : json_encode([$topic]),
                        ]);
                }
            });

        Schema::table('insights', function (Blueprint $table): void {
            $table->json('topic')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('insights')
            ->whereNotNull('topic')
            ->orderBy('id')
            ->select(['id', 'topic'])
            ->chunk(100, function ($insights): void {
                foreach ($insights as $insight) {
                    $tags = json_decode((string) $insight->topic, true);

                    DB::table('insights')
                        ->where('id', $insight->id)
                        ->update([
                            'topic' => is_array($tags) ? implode(', ', array_filter($tags)) : $insight->topic,
                        ]);
                }
            });

        Schema::table('insights', function (Blueprint $table): void {
            $table->string('topic')->nullable()->change();
        });
    }
};
