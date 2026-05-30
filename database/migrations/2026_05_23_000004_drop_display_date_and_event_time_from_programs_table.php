<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['display_date', 'event_time']);
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('display_date')->nullable()->after('end_date');
            $table->string('event_time')->nullable()->after('display_date');
        });
    }
};
