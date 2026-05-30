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
            $table->json('speakers')->nullable()->after('event_status');
        });

        DB::table('programs')
            ->whereNotNull('speaker_name')
            ->orderBy('id')
            ->get(['id', 'speaker_name', 'speaker_title'])
            ->each(function (object $program): void {
                DB::table('programs')
                    ->where('id', $program->id)
                    ->update([
                        'speakers' => json_encode([
                            [
                                'name' => $program->speaker_name,
                                'title' => $program->speaker_title,
                            ],
                        ]),
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('speakers');
        });
    }
};
