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
            $table->string('duration')->nullable()->after('label');
            $table->string('level')->nullable()->after('duration');
            $table->string('format')->nullable()->after('level');
        });

        DB::table('programs')->update([
            'duration' => '4 Pertemuan',
            'level' => 'Intermediate',
            'format' => 'Online',
        ]);
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['duration', 'level', 'format']);
        });
    }
};
